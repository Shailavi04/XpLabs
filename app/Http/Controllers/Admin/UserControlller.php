<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\batch;
use App\Models\center;
use App\Models\Course;
use App\Models\Role;
use App\Models\Student;
use App\Models\students_instructor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserControlller extends Controller
{
    public function index()
    {

        $roles  = Role::get();

        return view('admin.user.index', compact('roles'));
    }

    public function profile($id)
    {
        $user = User::with('centers')->findOrFail($id);

        $instructor = null;
        $student = null;

        if ($user->role_id == 3) {
            $instructor = students_instructor::where('user_id', $user->id)->first();
        } elseif ($user->role_id == 4) {
            $student = Student::where('user_id', $user->id)->first();
        }

        return view('admin.user.profile', compact('user', 'instructor', 'student'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required',
            'role'          => 'required|string|exists:roles,name',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $role = \Spatie\Permission\Models\Role::where('name', $request->role)->first();
        $role_id = $role->id;

        $profilePath = null;
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profile'), $filename);
            $profilePath = 'uploads/profile/' . $filename;
        }

        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'phone_number'  => $request->phone_number,
            'password'      => Hash::make($request->password),
            'role_id'       => $role_id,
            'active'        => 1,
            'profile_image' => $profilePath,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')
            ->with('success', 'User Created Successfully!');
    }


    public function data(Request $request)
    {

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'] ?? null;

        $query = User::with('roles');


        if ($request->role_id) {
            $query->where('role_id', $request->role_id);
        }


        if (Auth::user()->role_id != 1) {
            $query->where('id', Auth::id());
        }

        $totalRecords = $query->count();

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('email', 'like', '%' . $searchValue . '%')
                    ->orWhere('phone_number', 'like', '%' . $searchValue . '%')
                    ->orWhereHas('class', function ($q2) use ($searchValue) {
                        $q2->where('class_code', 'like', '%' . $searchValue . '%')
                            ->orWhere('name', 'like', '%' . $searchValue . '%'); // class name bhi search me add kiya
                    });
            });
        }

        $totalFiltered = (clone $query)->count();

        if (is_numeric($length) && $length > 0) {
            $query->skip($start)->take($length);
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        $data = [];
        $i = $start + 1;

        foreach ($users as $user) {
            $row = [];
            $row['DT_RowIndex'] = $i++;
            $row['name'] = $user->name;
            $row['email'] = $user->email;
            $row['role'] = $user->role->name ?? '-';
            $row['status'] = $user->status == 1
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-danger">Inactive</span>';
            // $row['image'] = asset('/uploads/classes/' . ($class->profile_image ?: 'default.png'));

            $deleteUrl = route('classes.destroy', $user->id);
            $row['action'] = '
<div class="btn-group">
    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" 
        data-bs-toggle="dropdown" aria-expanded="false" 
        style="padding: 0.25rem 0.5rem;">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 5.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 1.5a1.5 1.5 0 1 1 0 3 
                1.5 1.5 0 0 1 0-3zm0 4.5a1.5 1.5 0 1 1 0 3 
                1.5 1.5 0 0 1 0-3z"/>
        </svg>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a class="dropdown-item edit-user-btn" href="javascript:void(0);" 
               data-id="' . $user->id . '">
               <i class="fas fa-edit me-1 text-primary"></i> Edit
            </a>
        </li>
        <li>
            <form id="delete-form-' . $user->id . '" action="' . route('classes.destroy', $user->id) . '" method="POST" style="display: none;">
                ' . csrf_field() . '
            </form>
            <a href="javascript:void(0);" class="dropdown-item text-danger" onclick="confirmDelete(' . $user->id . ')">
                <i class="fas fa-trash-alt me-1"></i> Delete
            </a>
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


    public function edit($id)
    {
        $user = User::with('role')->findOrFail($id);

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role_id' => $user->role ? $user->role->id : null,
                'phone_number' => $user->phone_number,
                'status' => $user->status
            ]
        ]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|exists:roles,id',
            'status' => 'required|boolean',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role;
        $user->status = $request->status;

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profile'), $filename);

            if ($user->profile_image && file_exists(public_path('uploads/profile/' . $user->profile_image))) {
                unlink(public_path('uploads/profile/' . $user->profile_image));
            }

            $user->profile_image = $filename;
        }

        $user->save();

        return redirect()->back()->with('success', 'User updated successfully.');
    }

    public function profile_update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Common validation
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];



        $request->validate($rules);



        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $imageName = '';

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/profile'), $imageName);
            $user->profile_image = $imageName;
        }


        $user->name = $request->name;
        $user->email = $request->email;
        $user->profile_image = $imageName;
        $user->phone_number = $request->phone_number;
        $user->save();

        if ($user->role_id == 2) {
            // Find first center or create new one
            $center = $user->centers()->first();
            // dd($request->all(), $center);

            if (!$center) {
                $center = new center();
                $center->user_id = $user->id;
            }

            $center->name = $request->name;
            $center->email = $request->email;
            $center->phone_number = $request->phone_number;
            $center->country = $request->country;
            $center->state = $request->state;
            $center->city = $request->city;
            $center->postal_code = $request->postal_code;
            $center->description = $request->description;
            $center->address = $request->address;
            $center->code = $request->code;
            $center->longitude = $request->longitude;
            $center->latitude = $request->latitude;

            $center->save();
        }




        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function dashboard(Request $request)
    {
        $user = auth()->user();

        // Initialize counts
        $students = 0;
        $instructors = 0;
        $batches = 0;
        $courses = 0;
        $assignments = 0; // For 
        $quizzes = 0;


        if ($user->role_id == 1) {
            // Admin: see all
            $students    = User::where('role_id', 4)->count(); // Students
            $instructors = User::where('role_id', 3)->count(); // Instructors
            $batches     = Batch::count();
            $courses     = Course::count();
        } elseif ($user->role_id == 2) {
            // Center Staff: see only their centers
            $centerIds = DB::table('center_user')
                ->where('user_id', $user->id)
                ->pluck('center_id')
                ->toArray();

            $students = DB::table('enrollment')
                ->whereIn('center_id', $centerIds)
                ->distinct('student_id')
                ->count('student_id');

            $instructors = DB::table('students_instructors')
                ->whereIn('center_id', $centerIds)
                ->where('active', 1)
                ->count();

            $batches = DB::table('batches')
                ->join('courses', 'batches.course_id', '=', 'courses.id')
                ->whereIn('courses.center_id', $centerIds)
                ->count();

            $courses = DB::table('center_course')
                ->whereIn('center_id', $centerIds)
                ->count();
        } elseif ($user->role_id == 3) {
            // Teacher: see only their own courses and batches
            // Batches assigned to this teacher
            $batches = Batch::where('instructor_id', $user->id)->count();

            // Courses corresponding to these batches
            $courseIds = Batch::where('instructor_id', $user->id)->pluck('course_id')->unique();
            $courses = Course::whereIn('id', $courseIds)->count();

            // Students enrolled in these batches
            $students = DB::table('enrollment')
                ->whereIn('course_id', function ($q) use ($user) {
                    $q->select('course_id')
                        ->from('batches')
                        ->where('instructor_id', $user->id);
                })
                ->distinct('student_id')
                ->count('student_id');


            $assignments = DB::table('assignments')
                ->whereIn('batch_id', function ($q) use ($user) {
                    $q->select('id')
                        ->from('batches')
                        ->where('instructor_id', $user->id);
                })
                ->count();
        } elseif ($user->role_id == 4) {
            $courses = DB::table('enrollment')
                ->whereIn('student_id', function ($q) use ($user) {
                    $q->select('id')
                        ->from('students')
                        ->where('user_id', $user->id);
                })
                ->distinct('course_id')
                ->count('course_id');


            $assignments = DB::table('assignment_submissions')
                ->where('user_id', $user->id)
                ->count();

            $studentId = DB::table('students')
                ->where('user_id', $user->id)
                ->value('id');

            $quizzes = DB::table('quiz_results')
                ->where('user_id', $user->id)
                ->count();
        }

        return view('admin.dashboard.index', compact(
            'students',
            'instructors',
            'batches',
            'courses',
            'assignments'
        ));
    }
}
