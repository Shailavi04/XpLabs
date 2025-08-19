<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\center;
use App\Models\students_instructor;
use App\Models\User;
use Faker\Provider\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Hash;

class InstructorController extends Controller
{
    public function index()
    {
        if (User::isAdmin()) {
            $centers = Center::all();
        } elseif (User::isCenterManager()) {;

            $user = auth()->user();
            $centers = $user->centers ?? collect();
        } else {
            $centers = collect();
        }

        $user_teacher = User::where('role_id', 3)->get();

        return view('admin.instructor.index', compact('centers', 'user_teacher'));
    }



    public function store(Request $request)
    {

        $request->validate([
            'qualification' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0',
            'joining_date' => 'nullable|date',
            'bio' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/instructor'), $imageName);
        }

        $exists = students_instructor::where('center_id', $request->center_id)
            ->where('user_id', $request->instructor_id)
            ->exists();

        if (!$exists) {

            students_instructor::create([
                'center_id' => $request->center_id,
                'user_id' => $request->instructor_id,
                'phone_number' => $request->phone_number,
                'qualification' => $request->qualification,
                'designation' => $request->designation,
                'experience_years' => $request->experience_years,
                'joining_date' => $request->joining_date,
                'bio' => $request->bio,
                'profile_image' => $imageName,
                'active' => 1,
            ]);

            return redirect()->route('student_instructors.index')->with('success', 'Instructor created successfully!');
        } else {
            return back()->with('error', 'Instructor already assigned to this center.');
        }
    }




    public function instructor_data(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'] ?? null;

        $query = students_instructor::with('user');

        // Check logged-in user role
        $user = auth()->user();

        if (auth()->user()->role_id == 2) {
            $userId = auth()->id();

            $userCenterIds = DB::table('center_user')
                ->where('user_id', $userId)
                ->pluck('center_id')
                ->toArray();

            $query->whereIn('center_id', $userCenterIds);
        }


        // dd($query->get());

        $totalRecords = $query->count();

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('email', 'like', '%' . $searchValue . '%')
                    ->orWhere('phone', 'like', '%' . $searchValue . '%')
                    ->orWhere('qualification', 'like', '%' . $searchValue . '%');
            });
        }

        $totalFiltered = (clone $query)->count();

        if (is_numeric($length) && $length > 0) {
            $query->skip($start)->take($length);
        }

        $instructors = $query->orderBy('created_at', 'desc')->get();

        $data = [];
        $i = $start + 1;

        foreach ($instructors as $instructor) {
            $row = [];
            $row['DT_RowIndex'] = $i++;
            $row['name'] = $instructor->user->name ?? '-';
            $row['email'] = $instructor->user->email ?? '-';
            $row['phone_number'] = $instructor->user->phone_number ?? '-';
            $row['joining_date'] = $instructor->created_at ? $instructor->created_at->format('Y-m-d') : '-';
            $row['status'] = $instructor->user->status == 1
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-danger">Inactive</span>';

            $deleteUrl = route('student_instructors.destroy', $instructor->id);
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
                <a class="dropdown-item edit-instructor-btn" href="javascript:void(0);" data-id="' . $instructor->id . '">
                    <i class="fas fa-edit text-primary me-1"></i> Edit
                </a>
            </li>
            <li>
                 <form id="delete-form-' . $instructor->id . '" action="' . $deleteUrl . '" method="POST" style="display: none;">
                    ' . csrf_field() . '
                </form>
                <a href="javascript:void(0);" class="dropdown-item text-danger" onclick="confirmDelete(' . $instructor->id . ')">
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
        $instructor = students_instructor::with('user')->where('id', $id)->first();

        return response()->json([
            'instructor' => $instructor,
            'user'  => $instructor->user,
        ]);
    }




    public function update(Request $request, $id)
    {
        $request->validate([
            'center_id' => 'required|string',
            'instructor_id' => 'nullable|string',
            'qualification' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer',
            'joining_date' => 'nullable|date',
            'bio' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $instructor = students_instructor::findOrFail($id);

        // Update fields from form
        $instructor->center_id = $request->center_id;
        $instructor->user_id = $request->instructor_id; // linked user id
        $instructor->qualification = $request->qualification;
        $instructor->designation = $request->designation;
        $instructor->experience_years = $request->experience_years;
        $instructor->joining_date = $request->joining_date;
        $instructor->bio = $request->bio;

        // Handle image upload
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/instructor'), $imageName);

            // Delete old image if exists
            if ($instructor->profile_image && file_exists(public_path('uploads/instructor/' . $instructor->profile_image))) {
                unlink(public_path('uploads/instructor/' . $instructor->profile_image));
            }

            $instructor->profile_image = $imageName;
        }

        $instructor->save();

        return redirect()->route('student_instructors.index')->with('success', 'Instructor updated successfully!');
    }


    public function destroy($id)
    {
        $instructor = students_instructor::findOrFail($id);
        $instructor->delete();

        return redirect()->route('student_instructors.index')->with('success', 'instructor deleted successfully.');
    }
}
