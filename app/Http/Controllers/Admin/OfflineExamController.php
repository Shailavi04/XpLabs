<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Batch;
use Illuminate\Support\Facades\DB;

class OfflineExamController extends Controller
{
    public function index()
    {
        $batches = Batch::all();
        return view('admin.exam.offline', compact('batches'));
    }

    public function data(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'] ?? null;

        $query = Exam::with('batch')->where('mode', 'offline');

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('title', 'like', "%{$searchValue}%")
                    ->orWhere('duration', 'like', "%{$searchValue}%")
                    ->orWhere('exam_date', 'like', "%{$searchValue}%");
            });
        }

        $totalRecords = $query->count();
        $totalFiltered = (clone $query)->count();

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
            $row['status'] = $exam->status ?? 'Active';

            $editUrl = route('exam_offline.edit', $exam->id);
            $deleteUrl = route('exam_offline.destroy', $exam->id);

            $row['action'] = '
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item edit-offline-exam-btn" data-id="' . $exam->id . '">
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

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'exam_date' => 'required|date',
            'duration' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'batch_id' => 'required|exists:batches,id',
        ]);

        Exam::create([
            'title' => $request->title,
            'exam_date' => $request->exam_date,
            'duration' => $request->duration,
            'mode' => 'offline',
            'location' => $request->location,
            'batch_id' => $request->batch_id,
            'instructions' => $request->instructions,
        ]);

        return redirect()->back()->with('success', 'Offline Exam created successfully.');
    }

    public function edit($id)
    {
        $exam = Exam::findOrFail($id);
        return response()->json(['exam' => $exam]);
    }

    public function update(Request $request, $id)
    {
        $exam = Exam::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'exam_date' => 'required|date',
            'duration' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'batch_id' => 'required|exists:batches,id',
        ]);

        $exam->update([
            'title' => $request->title,
            'exam_date' => $request->exam_date,
            'duration' => $request->duration,
            'location' => $request->location,
            'batch_id' => $request->batch_id,
            'instructions' => $request->instructions,
        ]);

        return redirect()->back()->with('success', 'Offline Exam updated successfully.');
    }

    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);
        $exam->delete();

        return redirect()->back()->with('success', 'Offline Exam deleted successfully.');
    }
}
