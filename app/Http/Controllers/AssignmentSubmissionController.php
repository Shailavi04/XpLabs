<?php

namespace App\Http\Controllers;

use App\Models\assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentSubmissionController extends Controller
{
    public function submitForm($assignmentId)
    {
        $user = auth()->user();

        if ($user->role_id != 4) {
            abort(403, "Only students can submit assignments.");
        }

        $assignment = Assignment::findOrFail($assignmentId);
        return view('assignments.submit', compact('assignment'));
    }

    public function submit(Request $request, $assignmentId)
    {
        $user = auth()->user();

        if ($user->role_id != 4) {
            abort(403, "Only students can submit assignments.");
        }

        $request->validate([
            'assignment_file' => 'required|file|max:10240', // max 10MB
            'comments' => 'nullable|string',
        ]);

        $fileName = time() . '_' . $request->file('assignment_file')->getClientOriginalName();
        $request->file('assignment_file')->move(public_path('uploads/submissions'), $fileName);

        AssignmentSubmission::updateOrCreate(
            ['assignment_id' => $assignmentId, 'user_id' => $user->id],
            [
                'file_path' => $fileName,
                'comments' => $request->comments,
                'status' => 0, // 0 = submitted, can be updated by teacher later
            ]
        );

        return redirect()->back()->with('success', 'Assignment submitted successfully.');
    }

    public function index($assignmentId)
    {
        $assignment = Assignment::findOrFail($assignmentId);
        return view('admin.assignment_submit.index', compact('assignment'));
    }

    public function submissionData(Request $request, $assignmentId)
    {
        $draw = $request->get('draw');
        $start = $request->get('start', 0);
        $length = $request->get('length', 10);
        $searchValue = $request->input('search.value');

        $user = Auth::user();

        $query = AssignmentSubmission::with(['user', 'assignment'])
            ->where('assignment_id', $assignmentId);

        // Students see only their own submissions
        if ($user->role_id == 4) {
            $query->where('user_id', $user->id);
        }

        $totalRecords = $query->count();

        // Search functionality
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->whereHas('user', function ($q2) use ($searchValue) {
                    $q2->where('name', 'like', '%' . $searchValue . '%');
                })->orWhere('comments', 'like', '%' . $searchValue . '%');
            });
        }

        $totalFiltered = (clone $query)->count();

        if (is_numeric($length) && $length > 0) {
            $query->skip($start)->take($length);
        }

        $submissions = $query->orderBy('created_at', 'desc')->get();

        $data = [];
        $i = $start + 1;

        foreach ($submissions as $submission) {
            $fileLink = $submission->file_path
                ? '<a href="' . asset('uploads/submissions/' . $submission->file_path) . '" 
                  class="btn btn-sm btn-success" target="_blank">
                  <i class="fas fa-download me-1"></i> Download
               </a>'
                : 'N/A';

            $row = [];
            $row['DT_RowIndex'] = $i++;
            $row['student'] = $submission->user->name ?? '-';
            $row['assignment'] = $submission->assignment->title ?? '-';
            $row['comments'] = $submission->comments ?? '-';
            $row['status'] = $submission->status == 0 ? 'Submitted' : 'Graded';
            $row['file'] = $user->role_id == 1 || $user->role_id == 2 || $user->role_id == 3? $fileLink : 'N/A';
            $row['submitted_at'] = $submission->created_at->format('Y-m-d H:i');

            

            $data[] = $row;
        }

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data,
        ]);
    }
}
