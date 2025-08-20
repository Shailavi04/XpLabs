<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\center;
use App\Models\classes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ClassesController extends Controller
{
    public function index()
    {

        $user_center_staff = User::where('role_id', 2)->get();

        return view('admin.classes.index', compact('user_center_staff'));
    }


    public function store(Request $request)
    {
        // dd($request->all());
        // $request->validate([
        //     'name' => 'required|string',
        //     'code' => 'required',
        //     'email' => 'required|email|unique:users,email',
        //     'phone_number' => 'required|max:10',
        //     'country' => 'required|string|max:100',
        //     'state' => 'required|string|max:100',
        //     'city' => 'required|string|max:100',
        //     'postal_code' => 'required|string|max:20',
        //     'address' => 'required|string|max:255',
        //     'longitude' => 'nullable',
        //     'latitude' => 'nullable',
        //     'website' => 'nullable|url',
        //     'description' => 'nullable|string',
        //     'active' => 'required|boolean',
        //     'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);

        // $imageName = null;

        // if ($request->hasFile('profile_image')) {
        //     $image = $request->file('profile_image');
        //     $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        //     $image->move(public_path('uploads/classes'), $imageName);
        //     Log::info("Profile image uploaded: " . $imageName);
        // } else {
        //     Log::info("No profile image uploaded.");
        // }



        classes::create([
            'name' => $request->name,
            'code' => $request->code,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'website' => $request->website,
            'description' => $request->description,
            'active' => $request->active,
            'created_by' => Auth::user()->id,
            // 'profile_image' => $imageName,
        ]);


        return redirect()->route('classes.index')->with('success', 'Class created successfully!');
    }




    public function data(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'] ?? null;

        $query = center::query();

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
            $row['phone_number'] = $user->phone_number ?? '-';
            $row['status'] = $user->active == 1
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-danger">Inactive</span>';
            $row['created_at'] = $user->created_at ? $user->created_at->format('Y-m-d') : '-';

            // $row['image'] = asset('/uploads/classes/' . ($class->profile_image ?: 'default.png'));

            $deleteUrl = route('classes.destroy', $user->id);

            $row['action'] = '
<div class="btn-group">
    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0.25rem 0.5rem;">
        Actions
    </button>
    <ul class="dropdown-menu">
        <li>
            <a class="dropdown-item edit-class-btn" href="javascript:void(0);" data-id="' . $user->id . '">
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
        <li><hr class="dropdown-divider"></li>
        <li>
            <a href="javascript:void(0);" class="dropdown-item assign-staff-btn" data-center-id="' . $user->id . '" data-bs-toggle="modal" data-bs-target="#assignStaffModal">
                <i class="fas fa-user-plus me-1"></i> Assign Staff
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
        $user = center::where('id', $id)->first();

        if (!$user) {
            return response()->json(['error' => 'User  not found'], 404);
        }

        return response()->json([
            'user' => $user,
        ]);
    }





    public function update(Request $request, $id)
    {
        // Validation
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable',
            'class_code' => 'required',
            'description' => 'nullable',
            'profile_image' => 'nullable',
        ]);

        // User update
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        // Classes update or create
        $class = Classes::where('user_id', $id)->first();

        if (!$class) {
            $class = new Classes();
            $class->user_id = $id;
        }
        $class->name = $request->name;
        $class->email = $request->email;
        $class->phone_number = $request->phone_number;
        $class->class_code = $request->class_code;
        $class->description = $request->description;

        // Profile image handling
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/classes'), $filename);
            $class->profile_image = $filename;
        }

        $class->save();



        return redirect()->route('classes.index')->with('success', 'classes updated successfully.');
    }




    public function destroy($id)
    {
        $classes = classes::findOrFail($id);
        $classes->delete();

        return redirect()->route('course.index')->with('success', 'Class deleted successfully.');
    }

    public function assignStaff(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'center_staff' => 'required|array',
            'center_staff.*' => 'exists:users,id',
        ]);

        $center = Center::findOrFail($id);

        $center->staff()->sync($request->center_staff);

        return redirect()->back()->with('success', 'Staff assigned to center successfully.');
    }
}
