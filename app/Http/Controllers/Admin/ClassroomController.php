<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\Batch;
use App\Models\center;

class ClassroomController extends Controller
{
    public function index()
    {
        $batches = Batch::all();
        return view('admin.classroom.index', compact('batches'));
    }

    public function data(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'] ?? null;

        $query = Classroom::with('batch');

        // Search filter
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'like', "%{$searchValue}%")
                    ->orWhere('type', 'like', "%{$searchValue}%")
                    ->orWhere('no_of_seats', 'like', "%{$searchValue}%");
            });
        }

        $totalRecords = $query->count();
        $totalFiltered = (clone $query)->count();

        // Pagination
        if (is_numeric($length) && $length > 0) {
            $query->skip($start)->take($length);
        }

        $classrooms = $query->orderBy('id', 'desc')->get();

        $data = [];
        $i = $start + 1;

        foreach ($classrooms as $classroom) {
            $row = [];
            $row['DT_RowIndex'] = $i++;
            $row['name'] = $classroom->name;
            $row['batch'] = $classroom->batch->name ?? '-';
            $row['type'] = ucfirst($classroom->type);
            $row['no_of_seats'] = $classroom->no_of_seats ?? '-';
            $row['status'] = $classroom->active ? 'Active' : 'Inactive';

            $editUrl = route('classroom.edit', $classroom->id);
            $deleteUrl = route('classroom.destroy', $classroom->id);

            $row['action'] = '
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>
                    <ul class="dropdown-menu">
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
