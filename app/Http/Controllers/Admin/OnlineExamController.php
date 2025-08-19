<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Batch;
use Illuminate\Support\Facades\DB;

class OnlineExamController extends Controller
{
    // Display Exam List Page
    public function index()
    {
        $batches = Batch::all();
        return view('admin.exam.index', compact('batches'));
    }

    // Data for DataTable
    public function data(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'] ?? null;

        $user = auth()->user();

        $query = Exam::with('batch')->where('mode', 'online');

        // Optional: filter exams by assigned batches for non-admin users
        // if ($user->role_id != 1) {
        //     $assignedBatchIds = DB::table('batch_user')
        //         ->where('user_id', $user->id)
        //         ->pluck('batch_id')
        //         ->toArray();
        //     $query->whereIn('batch_id', $assignedBatchIds);
        // }

        // Search filter
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('title', 'like', "%{$searchValue}%")
                    ->orWhere('mode', 'like', "%{$searchValue}%")
                    ->orWhere('duration', 'like', "%{$searchValue}%")
                    ->orWhere('exam_date', 'like', "%{$searchValue}%");
            });
        }

        $totalRecords = $query->count();
        $totalFiltered = (clone $query)->count();

        // Pagination
        if (is_numeric($length) && $length > 0) {
            $query->skip($start)->take($length);
        }

        $exams = $query->orderBy('exam_date', 'desc')->get();

        $data = [];
        $i = $start + 1;

        foreach ($exams as $exam) {
            $row = [];
            $row['DT_RowIndex'] = $i++;
            $row['title'] = $exam->title;
            $row['exam_date'] = $exam->exam_date;
            $row['duration'] = $exam->duration;
            $row['mode'] = ucfirst($exam->mode);
            $row['batch'] = $exam->batch->name ?? '-';
            $row['status'] = $exam->status ?? 'Active'; // Add status if column exists

            // Actions: Edit / Delete
            $editUrl = route('exam_online.edit', $exam->id);
            $deleteUrl = route('exam_online.destroy', $exam->id);

            $row['action'] = '
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item edit-exam-btn" data-id="' . $exam->id . '">
                                <i class="fas fa-edit text-primary me-1"></i> Edit
                            </a>
                        </li>
                        <li>
                            <form action="' . $deleteUrl . '" method="POST" style="margin:0;">
                                ' . csrf_field() . '
                                <button type="submit" class="dropdown-item text-danger">
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

    // Store Exam
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'exam_date' => 'required|date',
            'duration' => 'required|integer|min:1',
            'mode' => 'required|in:online,offline',
        ]);

        $exam = Exam::create([
            'title' => $request->title,
            'exam_date' => $request->exam_date,
            'duration' => $request->duration,
            'mode' => $request->mode,
            'location' => $request->mode === 'offline' ? $request->location : null,
            'online_link' => $request->mode === 'online' ? $request->online_link : null,
            'batch_id' => $request->batch_id,
            'instructions' => $request->instructions,
        ]);

        return redirect()->back()->with('success', 'Exam created successfully.');
    }

    // Get Exam for Edit (AJAX)
    // Edit Exam
    public function edit($id)
    {
        $exam = Exam::findOrFail($id); // fetch exam by ID
        return response()->json(['exam' => $exam]);
    }

    // Update Exam
    public function update(Request $request, $id)
    {
        $exam = Exam::findOrFail($id); // fetch exam by ID

        $request->validate([
            'title' => 'required|string|max:255',
            'exam_date' => 'required|date',
            'duration' => 'required|integer|min:1',
            'mode' => 'required|in:online,offline',
        ]);

        $exam->update([
            'title' => $request->title,
            'exam_date' => $request->exam_date,
            'duration' => $request->duration,
            'mode' => $request->mode,
            'location' => $request->mode === 'offline' ? $request->location : null,
            'online_link' => $request->mode === 'online' ? $request->online_link : null,
            'batch_id' => $request->batch_id,
            'instructions' => $request->instructions,
        ]);

        return redirect()->back()->with('success', 'Exam updated successfully.');
    }

    // Delete Exam
    public function destroy($id)
    {
        $exam = Exam::findOrFail($id); // fetch exam by ID
        $exam->delete();

        return redirect()->back()->with('success', 'Exam deleted successfully.');
    }
}
