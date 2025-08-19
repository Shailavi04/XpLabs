<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\center;
use App\Models\Course;
use App\Models\Student;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Centers based on role
        if ($user->role_id == 1) { // Admin
            $centers = center::all();
        } elseif ($user->role_id == 2) { // Center Manager
            $centers = $user->centers; // Assuming hasMany relation
        } else { // Staff or others
            $centers = $user->centers;
        }

        // Students (role_id = 3)
        $students = User::where('role_id', 4)->get();

        return view('admin.student.index', compact('centers', 'students'));
    }
    public function getData(Request $request)
    {

        $length = $request->input('length', 10);
        $start = $request->input('start', 0);
        $search = $request->input('search.value');

        $user = auth()->user();


        $query = Student::with('enrollments.course', 'user');
        if ($user->role_id != 1) {
            $userCenterIds = DB::table('center_user')
                ->where('user_id', $user->id)
                ->pluck('center_id')
                ->toArray();
            $query->whereIn('center_id', $userCenterIds);
        }


        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%");
            });
        }



        $totalFiltered = (clone $query)->count();

        // ⚠️ Only apply skip/take if $length is valid
        if (is_numeric($length) && $length > 0) {
            $query->skip($start)->take($length);
        }

        $students = $query->orderBy('students.created_at', 'desc')->get();

        $data = [];
        foreach ($students as $index => $student) {
            $viewUrl = route('student.view', $student->id);
            $deleteUrl = route('student.destroy', $student->id);
            // <a href="' . $viewUrl . '" class="dropdown-item">
            //     <i class="fas fa-eye text-info me-1"></i> View
            // </a>
            $actionHtml = '
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

                </li>
                <li>
                    <a class="dropdown-item btn-edit" href="javascript:void(0);" data-id="' . $student->id . '">
                        <i class="fas fa-edit text-primary me-1"></i> Edit
                    </a>
                </li>
                <li>
                   <form action="' . $deleteUrl . '" method="POST" class="delete-student-form" style="margin:0;">
    ' . csrf_field() . '
    <button type="submit" class="dropdown-item text-danger student-delete-btn">
        <i class="fas fa-trash-alt me-1"></i> Delete
    </button>
</form>

                </li>
            </ul>
        </div>';

            $data[] = [
                'DT_RowIndex' => $start + $index + 1,
                'name' => $student->user->name ?? 'N/A',
                'email' => $student->user->email ?? 'N/A',
                'mobile' => $student->user->phone_number ?? 'N/A',
                'created_at' => $student->created_at ? $student->created_at->format('Y-m-d') : 'N/A',
                'status' => '<a href="' . route('student.status', $student->id) . '" 
    class="status-badge ' . ($student->status ? 'active' : 'inactive') . '"
    style="display: inline-flex; align-items: center; padding: 0.5rem 0.75rem; font-size: 0.9rem; border-radius: 0.375rem; text-decoration: none; transition: all 0.3s ease; cursor: pointer; color: white; ' . ($student->status ? 'background-color: #28a745;' : 'background-color: #dc3545;') . ' box-shadow: 0 2px 4px rgba(0,0,0,0.2);">

    ' . ($student->status ? 'Active' : 'Inactive') . '
</a>',


                'photo' => $student->image ? asset('uploads/students/' . $student->image) : null,
                'action' => $actionHtml,
            ];
        }


        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => Student::count(),
            'recordsFiltered' => $totalFiltered,
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'center_id' => 'required|exists:centers,id',
            'gender' => 'nullable|in:male,female,other',
            'dob' => 'nullable|date',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'parent_name' => 'nullable|string|max:255',
            'parent_contact_number' => 'nullable|string|max:20',
            'alternate_contact_number' => 'nullable|string|max:20',
            'nationality' => 'nullable|string|max:100',
            'education_level' => 'nullable|string|max:255',
            'blood_group' => 'nullable|string|max:5',
            'bio' => 'nullable|string',
            'status' => 'required|boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        $existingStudent = Student::where('user_id', $validated['user_id'])
            ->where('center_id', $validated['center_id'])
            ->first();


        if ($existingStudent) {

            return redirect()->route('student.index')->with('success', 'This student is already enrolled in this center.');
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/students'), $filename);
            $validated['image'] = $filename;
        }

        $icard = 'ICARD-' . strtoupper(uniqid());

        Student::create([
            'user_id' => $validated['user_id'],
            'center_id' => $validated['center_id'],
            'gender' => $validated['gender'] ?? null,
            'dob' => $validated['dob'] ?? null,
            'city' => $validated['city'] ?? null,
            'state' => $validated['state'] ?? null,
            'country' => $validated['country'] ?? null,
            'postal_code' => $validated['postal_code'] ?? null,
            'parent_name' => $validated['parent_name'] ?? null,
            'parent_contact_number' => $validated['parent_contact_number'] ?? null,
            'alternate_contact_number' => $validated['alternate_contact_number'] ?? null,
            'nationality' => $validated['nationality'] ?? null,
            'education_level' => $validated['education_level'] ?? null,
            'blood_group' => $validated['blood_group'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'status' => $validated['status'],
            'image' => $validated['image'] ?? null,
            'icard' => $icard,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Student profile created successfully.']);
        }

        return redirect()->route('student.index')->with('success', 'Student profile created successfully.');
    }


    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return response()->json($student);
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);


        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'mobile' => 'required|string|unique:students,mobile,' . $id,
            'password' => 'nullable|min:6',
            'gender' => 'nullable|in:male,female,other',
            'dob' => 'nullable|date',
            'city' => 'nullable|string|max:255',
            'education_level' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'status' => 'required|boolean',
            'image' => 'nullable|image|max:2048',
        ]);



        if ($request->hasFile('image')) {
            if ($student->image && file_exists(public_path('uploads/students/' . $student->image))) {
                unlink(public_path('uploads/students/' . $student->image));
            }
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/students'), $filename);
            $validated['image'] = $filename;
        } else {
            $validated['image'] = $student->image;
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $student->update($validated);



        return redirect()->route('student.index')->with('success', 'Student updated successfully.');
    }

    public function profile_update(Request $request, $id)
    {
        $student = Student::findOrFail($id);



        if ($request->hasFile('image')) {
            if ($student->image && file_exists(public_path('uploads/students/' . $student->image))) {
                unlink(public_path('uploads/students/' . $student->image));
            }
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/students'), $filename);
            $validated['image'] = $filename;
        } else {
            $validated['image'] = $student->image;
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $student->update($validated);


        return redirect()->route('student.view', ['id' => $id])->with('success', 'Student updated successfully.');
    }

    public function destroy(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        if ($student->image && file_exists(public_path('uploads/students/' . $student->image))) {
            unlink(public_path('uploads/students/' . $student->image));
        }

        $student->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Student deleted successfully.']);
        }

        return redirect()->route('student.index')->with('success', 'Student deleted successfully.');
    }



    public function view($studentId)
    {
        $student = Student::with([
            'enrollments.course',
            'transactions.course'
        ])->findOrFail($studentId);


        $courses = Course::all();

        return view('admin.student.view', compact('student', 'courses'));
    }


    public function toggleStatus($id)
    {
        $student = Student::findOrFail($id);

        $student->status = !$student->status;
        $student->save();

        $msg = $student->status ? 'Student activated successfully.' : 'Student deactivated successfully.';



        return redirect()->back()->with('success', $msg);
    }
}
