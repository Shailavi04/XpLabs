<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\center;
use App\Models\course;
use App\Models\Enrollment;
use App\Models\Student;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role_id == 1) { // Admin
            $centers = Center::all();
            $categories = Category::all();
            $courses  = [];
        } else { // Staff
            $assignedCenterIds = DB::table('center_user')
                ->where('user_id', $user->id)
                ->pluck('center_id') // returns a collection
                ->toArray();

            $centers = DB::table('centers')
                ->whereIn('id', $assignedCenterIds)
                ->pluck('name', 'id')
                ->toArray();


            $categories = [];
            $courses  = Course::all();
        }

        return view('admin.courses.index', compact('centers', 'categories', 'courses'));
    }
    public function create()
    {
        $categories = category::all();
        return view('admin.courses.create', compact('categories'));
    }

    public function data(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'] ?? null;
        $studentId = $request->get('student_id');


        $user = auth()->user();

        $query = Course::query();


        $query = $query->with(['category', 'enrollments.student']);


        if ($user->role_id != 1) { // Non-admin
            $assignedCenterIds = DB::table('center_user')
                ->where('user_id', $user->id)
                ->pluck('center_id')
                ->toArray();

            // Filter courses assigned to these centers
            $query->whereHas('centers', function ($q) use ($assignedCenterIds) {
                $q->whereIn('center_id', $assignedCenterIds);
            });
        }

        $totalRecords = $query->count();


        // Apply student filter if present
        if (!empty($studentId)) {
            $query->whereHas('enrollments', function ($q) use ($studentId) {
                $q->where('student_id', $studentId);
            });
        }

        // Apply search filter if present
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('code', 'like', '%' . $searchValue . '%')
                    ->orWhere('duration', 'like', '%' . $searchValue . '%');
            });
        }



        $totalFiltered = (clone $query)->count();

        // ⚠️ Only apply skip/take if $length is valid
        if (is_numeric($length) && $length > 0) {
            $query->skip($start)->take($length);
        }

        $courses = $query->orderBy('courses.created_at', 'desc')->get();

        $data = [];
        $i = $start + 1;

        foreach ($courses as $course) {
            $row = [];
            $row['DT_RowIndex'] = $i++;
            $row['name'] = $course->name;
            $row['code'] = $course->code;
            $row['duration'] = $course->duration;
            $row['category_name'] = $course->category->name ?? '-';

            // Get first student name from enrollments or '-'
            $row['student_name'] = '<a href="' . route('course.students_list', $course->id) . '">' . $course->enrollments->count() . '</a>';
            // Count enrolled students

            $row['image'] = asset('/uploads/courses/' . ($course->image ?: 'default.png'));

            $viewUrl = route('course.show', $course->id);
            $deleteUrl = route('course.destroy', $course->id);
            $row['action'] = '
    <div class="btn-group">
        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0.25rem 0.5rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 5.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 1.5a1.5 1.5 0 1 1 0 3 
                    1.5 1.5 0 0 1 0-3zm0 4.5a1.5 1.5 0 1 1 0 3 
                    1.5 1.5 0 0 1 0-3z"/>
            </svg>
        </button>
        <ul class="dropdown-menu">
            <li>
               <a href="' . $viewUrl . '" class="dropdown-item" target="_blank">
    <i class="fas fa-eye text-info me-1"></i> View
</a>

            </li>
            <li>
               
<a class="dropdown-item edit-course-btn" href="javascript:void(0);" data-id="' . $course->id . '">
                    <i class="fas fa-edit text-primary me-1"></i> Edit
                </a>
            </li>
            <li>
                <form action="' . $deleteUrl . '" method="POST" class="" style="margin:0;">
                    ' . csrf_field() . '
                    <button type="submit" class="dropdown-item text-danger course-delete-btn">
                        <i class="fas fa-trash-alt me-1"></i> Delete
                    </button>
                </form>
            </li>
        </ul>
    </div>';





            $data[] = $row;
        }

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ]);
    }



    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->role_id == 1) {
            // Admin validation
            $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|unique:courses,code',
                'duration' => 'required',
                'description' => 'required',
                'category_id' => 'required|exists:categories,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'curriculum' => 'required|string',
                'total_fee'  => 'required',
                'seats_available'  => 'required',
                'token_amount'  => 'required',
                'center_id' => 'required|array',
                'center_id.*' => 'exists:centers,id',
            ]);

            $data = $request->only([
                'name',
                'code',
                'duration',
                'description',
                'category_id',
                'status',
                'total_fee',
                'curriculum',
                'seats_available',
                'token_amount'
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/courses'), $filename);
                $data['image'] = $filename;
            }

            $course = Course::create($data);

            $course->centers()->sync($request->input('center_id'));
        } else {
            // Center staff validation
            $request->validate([
                'center_id' => 'required|array',
                'center_id.*' => 'exists:centers,id',

            ]);


            $course = Course::findOrFail($request->course_id);

            $course->centers()->syncWithoutDetaching([$request->center_id]);
        }

        return redirect()->route('course.index')->with('success', 'Course saved successfully.');
    }




    // public function edit($id)
    // {
    //     $course = Course::findOrFail($id);
    //     $categories = Category::all();
    //     return view('admin.courses.edit', compact('course', 'categories'));
    // }


    public function edit($id)
    {
        $course = Course::with(['category', 'centers'])->find($id);

        if (!$course) {
            return response()->json(['error' => 'Course not found'], 404);
        }

        $user = auth()->user();

        $userCenters = [];
        if ($user->role_id == 2) {
            $userCenters = $course->centers;
        }

        return response()->json([
            'success' => true,
            'course' => $course,
            'all_centers' => DB::table('centers')->select('id', 'name')->get(),
            'user_centers' => $userCenters 
        ]);
    }




    public function update(Request $request, $id)
    {
        // dd($request->all());
        $user = auth()->user();
        $course = Course::findOrFail($id);

        if ($user->role_id == 1) {
            $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|unique:courses,code,' . $id,
                'duration' => 'required',
                'description' => 'required',
                'category_id' => 'required|exists:categories,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'curriculum' => 'required|string',
                'total_fee'  => 'required',
                'seats_available'  => 'required',
                'token_amount'  => 'required',
                'center_id' => 'required|array',
                'center_id.*' => 'exists:centers,id',
            ]);

            $data = $request->only([
                'name',
                'code',
                'duration',
                'description',
                'category_id',
                'status',
                'total_fee',
                'curriculum',
                'seats_available',
                'token_amount'
            ]);

            // Image upload
            if ($request->hasFile('image')) {
                if ($course->image && file_exists(public_path('uploads/courses/' . $course->image))) {
                    unlink(public_path('uploads/courses/' . $course->image));
                }
                $image = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/courses'), $filename);
                $data['image'] = $filename;
            }

            $course->update($data);

            $course->centers()->sync($request->input('center_id'));
        } else {
            $request->validate([
                'center_id' => 'required|exists:centers,id',
            ]);

            $course->centers()->sync([$request->center_id]);
        }

        return redirect()->route('course.index')->with('success', 'Course updated successfully.');
    }


    public function show($id)
    {
        $course = Course::findOrFail($id);

        $studentcount = DB::table('enrollment')
            ->where('enrollment.course_id', $id)
            ->count();

        $student = DB::table('enrollment')
            ->join('courses', 'enrollment.course_id', '=', 'courses.id')
            ->join('students', 'enrollment.student_id', '=', 'students.id')
            ->where('courses.id', $id)
            ->select(
                'courses.name as course_name',
                'students.name as name',
                DB::raw("DATE_FORMAT(enrollment.created_at, '%Y-%m-%d') as enrolled_at")
            )
            ->get();

        //                                 foreach ($student as $s){

        // dd($s->name);

        //                                 }




        // Prepare curriculum HTML
        $curriculumHtml = '';
        if ($course->curriculum) {
            libxml_use_internal_errors(true);
            $dom = new \DOMDocument();
            $dom->loadHTML(mb_convert_encoding($course->curriculum, 'HTML-ENTITIES', 'UTF-8'));
            libxml_clear_errors();

            $body = $dom->getElementsByTagName('body')->item(0);
            if ($body) {
                foreach ($body->childNodes as $node) {
                    $curriculumHtml .= $dom->saveHTML($node);
                }
            }
        }

        return view('admin.courses.view', compact('course', 'studentcount', 'student', 'curriculumHtml'));
    }












    public function destroy($id)
    {
        $course = course::findOrFail($id);
        $course->delete();

        return redirect()->route('course.index')->with('success', 'Course deleted successfully.');
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads/courses');
            $file->move($destinationPath, $filename);

            return response()->json([
                'filePath' => asset('uploads/courses/' . $filename)
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function studentsList($id)
    {
        $course = Course::with('enrollments.student')->findOrFail($id);
        return view('admin.courses.students-list', compact('course'));
    }

    public function studentsListData(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $query = Enrollment::with('student')->where('course_id', $id);

        $totalRecords = $query->count();

        if (!empty($request->get('search')['value'])) {
            $search = $request->get('search')['value'];
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        $totalFiltered = $query->count();

        $enrollments = $query
            ->offset($request->get('start'))
            ->limit($request->get('length'))
            ->get();

        $data = [];
        $i = $request->get('start') + 1;
        foreach ($enrollments as $enrollment) {
            $data[] = [
                'DT_RowIndex' => $i++,
                'name' => $enrollment->student->name,
                'email' => $enrollment->student->email,
                'mobile' => $enrollment->student->mobile ?? '-',
                'date' => $enrollment->created_at ? $enrollment->created_at->format('d-m-Y') : '-',
            ];
        }

        return response()->json([
            'draw' => intval($request->get('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ]);
    }
}
