<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\Batch;
use App\Models\center;
use Illuminate\Support\Facades\DB;

class ClassroomController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role_id == 1) {
            $batches = Batch::all();
        } elseif ($user->role_id == 2) {
            $centerIds = DB::table('center_user')
                ->where('user_id', $user->id)
                ->pluck('center_id');

            $courseIds = DB::table('center_course')
                ->whereIn('center_id', $centerIds)
                ->pluck('course_id');

            $batchIds = DB::table('batches')
                ->whereIn('course_id', $courseIds)
                ->pluck('id');

            $batches = Batch::whereIn('id', $batchIds)->get();
        } elseif ($user->role_id == 3) {
            $batchIds = DB::table('batches')
                ->where('instructor_id', $user->id)
                ->pluck('id');

            $batches = Batch::whereIn('id', $batchIds)->get();
        } else {
            $batches = collect();
        }

        return view('admin.classroom.index', compact('batches'));
    }


    public function data(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start', 0);
        $length = $request->get('length', 10);
        $searchValue = $request->input('search.value') ?? null;

        $user = auth()->user();
        $query = Classroom::with('batch');

        // ROLE BASED FILTERS
        if ($user->role_id == 2) {
            // Center Manager: classrooms in their centers
            $centerIds = DB::table('center_user')
                ->where('user_id', $user->id)
                ->pluck('center_id');

            $courseIds = DB::table('center_course')
                ->whereIn('center_id', $centerIds)
                ->pluck('course_id');

            $batchIds = DB::table('batches')
                ->whereIn('course_id', $courseIds)
                ->pluck('id');

            $query->whereIn('batch_id', $batchIds);
        } elseif ($user->role_id == 3) {
            $batchIds = DB::table('batches')
                ->where('instructor_id', $user->id)
                ->pluck('id');

            $query->whereIn('batch_id', $batchIds);
        } elseif ($user->role_id == 4) {
            $student = DB::table('students')->where('user_id', $user->id)->first();

            if (!$student) {
                return response()->json([
                    'draw' => intval($draw),
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => [],
                ]);
            }

            $batchIds = DB::table('enrollment')
                ->where('student_id', $student->id)
                ->where('status', 2) // active enrollment
                ->pluck('batch_id');

            $query->whereIn('batch_id', $batchIds);
        }

        // SEARCH FILTER
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'like', "%{$searchValue}%")
                    ->orWhere('type', 'like', "%{$searchValue}%")
                    ->orWhere('no_of_seats', 'like', "%{$searchValue}%");
            });
        }

        $totalRecords = $query->count();
        $totalFiltered = (clone $query)->count();

        // PAGINATION
        if (is_numeric($length) && $length > 0) {
            $query->skip($start)->take($length);
        }

        $classrooms = $query->orderBy('id', 'desc')->get();

        // BUILD DATATABLE DATA
        $data = [];
        $i = $start + 1;

        foreach ($classrooms as $classroom) {
            $row = [];
            $row['DT_RowIndex'] = $i++;
            $row['name'] = $classroom->name;
            $row['batch'] = $classroom->batch->name ?? '-';
            $row['type'] = ucfirst($classroom->type);
            $row['no_of_seats'] = $classroom->no_of_seats ?? '-';
            $row['meeting_link'] = strtolower($classroom->type) == 'online'
                ? ($classroom->meeting_link ?? '-')
                : '-';
            $row['status'] = $classroom->active ? 'Active' : 'Inactive';

            // ACTION BUTTONS
            $editUrl = route('classroom.edit', $classroom->id);
            $deleteUrl = route('classroom.destroy', $classroom->id);

            $action = '<div class="btn-group">
            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Actions
            </button>
            <ul class="dropdown-menu">';

            if (in_array($user->role_id, [1, 2])) {
                $action .= '
                <li>
                    <a href="javascript:void(0);" class="dropdown-item edit-classroom-btn" data-id="' . $classroom->id . '">
                        <i class="fas fa-edit text-primary me-1"></i> Edit
                    </a>
                </li>
                <li>
                    <form id="delete-form-' . $classroom->id . '" action="' . $deleteUrl . '" method="POST" style="margin:0;">
                        ' . csrf_field() . '
                        <button type="button" class="dropdown-item text-danger" onclick="confirmDelete(' . $classroom->id . ')">
                            <i class="fas fa-trash-alt me-1"></i> Delete
                        </button>
                    </form>
                </li>';
            }

            $action .= '</ul></div>';
            $row['action'] = $action;

            $data[] = $row;
        }

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ]);
    }

    // Store Classroom
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:online,offline,hybrid',
            'batch_id' => 'required|exists:batches,id',
            'no_of_seats' => 'nullable|integer|min:1',
        ]);

        Classroom::create([
            'name' => $request->name,
            'type' => $request->type,
            'batch_id' => $request->batch_id,
            'no_of_seats' => $request->no_of_seats,
            'description' => $request->description,
            'meeting_link' => $request->meeting_link,
            'meeting_password' => $request->meeting_password,
            'active' => 1,
        ]);

        return redirect()->back()->with('success', 'Classroom created successfully.');
    }

    // Get Classroom for Edit (AJAX)
    public function edit($id)
    {
        $classroom = Classroom::findOrFail($id);
        return response()->json(['classroom' => $classroom]);
    }

    // Update Classroom
    public function update(Request $request, $id)
    {
        $classroom = Classroom::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:online,offline,hybrid',
            'batch_id' => 'required|exists:batches,id',
            'no_of_seats' => 'nullable|integer|min:1',
        ]);

        $classroom->update([
            'name' => $request->name,
            'type' => $request->type,
            'batch_id' => $request->batch_id,
            'no_of_seats' => $request->no_of_seats,
            'description' => $request->description,
            'meeting_link' => $request->meeting_link,
            'meeting_password' => $request->meeting_password,
            'active' => $request->active ?? 1,
        ]);

        return redirect()->back()->with('success', 'Classroom updated successfully.');
    }

    // Delete Classroom
    public function destroy($id)
    {
        $classroom = Classroom::findOrFail($id);
        $classroom->delete();

        return redirect()->back()->with('success', 'Classroom deleted successfully.');
    }

    public function map()
    {
        $centers = center::all();
        $mapCenter = $centers->first();
        return view('admin.classroom.map', compact('centers', 'mapCenter'));
    }
}
