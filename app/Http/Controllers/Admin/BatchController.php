<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Courses;
use App\Models\students_instructor;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BatchController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        if ($user->role_id == 1) {
            $courses = DB::table('courses')
                ->join('enrollment', 'courses.id', '=', 'enrollment.course_id')
                ->where('enrollment.status', 2)
                ->select('courses.*')
                ->distinct()
                ->get();

            $instructors = students_instructor::get();
        } else {
            $centerIds = DB::table('center_user')
                ->where('user_id', $user->id)
                ->pluck('center_id')
                ->toArray();
            $courses = DB::table('courses')
                ->join('center_course', 'courses.id', '=', 'center_course.course_id')
                ->whereIn('center_course.center_id', $centerIds)
                ->select('courses.*')
                ->distinct()
                ->get();

            $instructors = students_instructor::whereIn('center_id', $centerIds)->get();
        }

        return view('admin.batch.index', compact('courses', 'instructors'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'instructor_id' => 'nullable|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'schedule' => 'nullable|array',
            'schedule.*' => 'string',
        ]);

        $data = $request->all();

        $data['schedule'] = isset($data['schedule']) ? implode(',', $data['schedule']) : null;

        Batch::create($data);

        return redirect()->back()->with('success', 'Batch created successfully.');
    }
    public function data(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'] ?? null;

        $user = auth()->user();

        $query = Batch::with('course'); // eager load course

        if ($user->role_id != 1) {
            $centerIds = DB::table('center_user')
                ->where('user_id', $user->id)
                ->pluck('center_id')
                ->toArray();

            $query->whereHas('course', function ($q) use ($centerIds) {
                $q->whereIn('id', function ($sub) use ($centerIds) {
                    $sub->select('course_id')
                        ->from('center_course')
                        ->whereIn('center_id', $centerIds)
                        ->distinct();
                });
            });
        }

        $totalRecords = Batch::count(); // total batches (without search)
        $totalFiltered = (clone $query)->count();

        if (is_numeric($length) && $length > 0) {
            $query->skip($start)->take($length);
        }

        $batches = $query->orderBy('created_at', 'desc')->get();

        $data = [];
        $i = $start + 1;

        foreach ($batches as $batch) {
            $row = [];
            $row['DT_RowIndex'] = $i++;
            $row['name'] = $batch->name;
            $row['course'] = $batch->course ? $batch->course->name : '-';
            $row['start_date'] = $batch->start_date;
            $row['end_date'] = $batch->end_date ?? '-';

            $statusMap = [
                1 => ['label' => 'Active', 'badge' => 'badge bg-success', 'toggle_to' => 2],
                2 => ['label' => 'Inactive', 'badge' => 'badge bg-secondary', 'toggle_to' => 1],
            ];

            $statusInfo = $statusMap[$batch->status] ?? ['label' => 'Unknown', 'badge' => 'badge bg-warning', 'toggle_to' => null];

            $buttonHtml = '';
            if ($statusInfo['toggle_to']) {
                $buttonHtml = ' <button 
        class="btn btn-sm btn btn-success toggle-status-btn" 
        data-id="' . $batch->id . '" 
        data-status="' . $statusInfo['toggle_to'] . '" 
        data-label="Change status to ' . $statusMap[$statusInfo['toggle_to']]['label'] . '"
    >' . $statusInfo['label'] . '</button>';
            }

            $row['status'] =  $buttonHtml;

            $editUrl = route('batch.edit', $batch->id);
            $deleteUrl = route('batch.destroy', $batch->id);

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
                <li><a href="javascript:void(0);" 
class="dropdown-item edit-btn" 
data-id="' . $batch->id . '" 
data-bs-toggle="modal" 
data-bs-target="#editBatchModal">
               <i class="fas fa-edit me-1 text-primary"></i> Edit
</a></li>
                <li>
                    <form id="delete-form-' . $batch->id . '" action="' . $deleteUrl . '" method="POST" style="display:none;">
                        ' . csrf_field() . method_field('DELETE') . '
                    </form>
                    <a href="javascript:void(0);" class="dropdown-item text-danger" onclick="confirmDelete(' . $batch->id . ')">
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
        $batch = Batch::findOrFail($id);

        return response()->json(['batch' => $batch]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'schedule' => 'nullable|array',
            'schedule.*' => 'string',
        ]);

        $batch = Batch::findOrFail($id);

        // Only update relevant fields
        $batch->name = $request->name;
        $batch->start_date = $request->start_date;
        $batch->end_date = $request->end_date;
        $batch->schedule = $request->filled('schedule') ? implode(',', $request->schedule) : null;

        $batch->save();

        return redirect()->back()->with('success', 'Batch updated successfully.');
    }
}
