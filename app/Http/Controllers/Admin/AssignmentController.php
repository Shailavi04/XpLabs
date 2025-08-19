<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\assignment;
use App\Models\batch as ModelsBatch;
use App\Models\Course;
use Illuminate\Bus\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role_id == 1) {
            $courses = Course::all();
            $batches = ModelsBatch::all();
            $assignments = Assignment::with(['batch', 'creator'])->get();
        } else {
            $userCenterIds = DB::table('center_user')
                ->where('user_id', $user->id)
                ->pluck('center_id')
                ->toArray();

            $courseIds = DB::table('center_course')
                ->whereIn('center_id', $userCenterIds)
                ->pluck('course_id')
                ->toArray();

            $courses = Course::whereIn('id', $courseIds)->get();
            $batches = ModelsBatch::whereIn('course_id', $courseIds)->get();

            $assignments = Assignment::with(['batch', 'creator'])
                ->whereIn('batch_id', $batches->pluck('id')->toArray())
                ->get();
        }

        return view('admin.assignment.index', compact('courses', 'batches', 'assignments'));
    }






    public function data(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start', 0);
        $length = $request->get('length', 10);
        $searchValue = $request->input('search.value');

        $user = auth()->user();

        $query = Assignment::with(['batch', 'batch.course', 'creator']);

        $student = DB::table('students')->where('user_id', $user->id)->first();


        if ($user->role_id == 1) {
            // Admin – can see all assignments (no additional filters)
        } elseif ($user->role_id == 2) {
            $userCenterIds = DB::table('center_user')
                ->where('user_id', $user->id)
                ->pluck('center_id')
                ->toArray();

            $query->where(function ($q) use ($user, $userCenterIds) {
                $q->where('created_by', $user->id)
                    ->orWhereHas('batch.course', function ($subQ) use ($userCenterIds) {
                        $subQ->whereIn('id', function ($innerQ) use ($userCenterIds) {
                            $innerQ->select('course_id')
                                ->from('center_course')
                                ->whereIn('center_id', $userCenterIds);
                        });
                    });
            });
        } elseif ($user->role_id == 4) {
            $activeEnrollments = DB::table('enrollment')
                ->where('student_id', $student->id)
                ->where('status', 2)
                ->pluck('course_id');

            $query->whereHas('batch.course', function ($q) use ($activeEnrollments) {
                $q->whereIn('id', $activeEnrollments);
            });
        }


        $totalRecords = $query->count();

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('title', 'like', '%' . $searchValue . '%')
                    ->orWhere('status', 'like', '%' . $searchValue . '%');
            });
        }

        $totalFiltered = (clone $query)->count();

        if (is_numeric($length) && $length > 0) {
            $query->skip($start)->take($length);
        }

        $assignments = $query->orderBy('assignments.created_at', 'desc')->get();

        $data = [];
        $i = $start + 1;

        foreach ($assignments as $assignment) {
            $attachmentHtml = $assignment->attachment
                ? '<a href="' . asset('uploads/assignments/' . $assignment->attachment) . '" target="_blank">View</a>'
                : 'N/A';

            $row = [];
            $row['DT_RowIndex'] = $i++;
            $row['title'] = $assignment->title;
            $row['course'] = $assignment->batch->course->name ?? '-';
            $row['batch'] = $assignment->batch->name ?? '-';
            $row['status'] = ucfirst($assignment->status);
            $row['attachment'] = $attachmentHtml;

            // Role-based dropdown
            $actions = '<div class="btn-group">
            <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0.25rem 0.5rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 5.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 1.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3zm0 4.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3z"/>
                </svg>
            </button>
            <ul class="dropdown-menu">';

            if ($user->role_id == 1 || $user->role_id == 2) {
                $deleteUrl = route('assignment.destroy', $assignment->id);
                $actions .= '
            <li>
                <a class="dropdown-item btn-edit" href="javascript:void(0);" data-id="' . $assignment->id . '">
                    <i class="fas fa-edit me-1 text-primary"></i> Edit
                </a>
            </li>
            <li>
                <form action="' . $deleteUrl . '" method="POST" style="margin:0;">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm(\'Are you sure you want to delete this?\');">
                        <i class="fas fa-trash-alt me-1"></i> Delete
                    </button>
                </form>
            </li>
            
             <li>
              <a class="dropdown-item btn-view" href="' . route('assignment.submission.index', $assignment->id) . '">
        <i class="fas fa-eye me-1 text-info"></i> My Submission
    </a>

            </li>';
            } elseif ($user->role_id == 4) { // Student
                $actions .= '
            <li>
             <a href="javascript:void(0);" class="dropdown-item"
               data-bs-toggle="modal"
               data-bs-target="#submitAssignmentModal"
               data-assignment-id="' . $assignment->id . '">
                <i class="fas fa-upload me-1 text-success"></i> Submit
            </a>
        </li>
           ';
            }

            $actions .= '</ul></div>';
            $row['action'] = $actions;

            $data[] = $row;
        }

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'batch_id' => 'required|exists:batches,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,zip|max:2048',
            'publish_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'status' => 'required|in:draft,published,archived',
        ]);

        $fileName = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/assignments'), $fileName);
        }

        Assignment::create([
            'course_id' => $request->course_id,
            'batch_id' => $request->batch_id,
            'created_by' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'attachment' => $fileName,
            'publish_date' => $request->publish_date,
            'due_date' => $request->due_date,
            'status' => $request->status,
        ]);

        return redirect()->route('assignment.index')->with('success', 'Assignment created successfully.');
    }

    public function edit($id)
    {
        $assignment = Assignment::findOrFail($id);
        return response()->json($assignment);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'batch_id' => 'required|exists:batches,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,zip|max:2048',
            'publish_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'status' => 'required|in:draft,published,archived',
        ]);

        $assignment = Assignment::findOrFail($id);

        $assignment->course_id = $request->course_id;
        $assignment->batch_id = $request->batch_id;
        $assignment->title = $request->title;
        $assignment->description = $request->description;
        $assignment->publish_date = $request->publish_date;
        $assignment->due_date = $request->due_date;
        $assignment->status = $request->status;

        if ($request->hasFile('attachment')) {
            if ($assignment->attachment && file_exists(public_path('uploads/assignments/' . $assignment->attachment))) {
                unlink(public_path('uploads/assignments/' . $assignment->attachment));
            }
            $file = $request->file('attachment');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/assignments'), $fileName);
            $assignment->attachment = $fileName;
        }

        $assignment->save();

        return redirect()->route('assignments.index')->with('success', 'Assignment updated.');
    }

    public function destroy($id)
    {
        $assignment = assignment::findOrFail($id);

        if ($assignment->attachment && file_exists(public_path('uploads/assignments/' . $assignment->attachment))) {
            unlink(public_path('uploads/assignments/' . $assignment->attachment));
        }

        $assignment->delete();

        return redirect()->route('assignments.index')->with('success', 'Assignment deleted.');
    }
}
