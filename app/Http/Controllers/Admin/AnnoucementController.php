<?php

namespace App\Http\Controllers\Admin;

use App\Events\AnnouncementCreated;
use App\Http\Controllers\Controller;
use App\Models\annoucement;
use App\Models\batch;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Http\Request;

class AnnoucementController extends Controller
{
    // Show list page
    public function index()
    {
        $classrooms = Classroom::all(); // optional classroom selection
        return view('admin.announcement.index', compact('classrooms'));
    }

    // Data for DataTable
    public function data(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'] ?? null;

        $query = annoucement::with('classroom');

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('title', 'like', "%{$searchValue}%")
                    ->orWhere('message', 'like', "%{$searchValue}%");
            });
        }

        $totalRecords = $query->count();
        $totalFiltered = (clone $query)->count();

        if (is_numeric($length) && $length > 0) {
            $query->skip($start)->take($length);
        }

        $announcements = $query->orderBy('id', 'desc')->get();

        $data = [];
        $i = $start + 1;

        foreach ($announcements as $announcement) {
            $row = [];
            $row['DT_RowIndex'] = $i++;
            $row['title'] = $announcement->title;
            $row['message'] = $announcement->message;
            $row['classroom'] = $announcement->classroom->name ?? 'Global';

            // Display recipients from bit flags
            $recipients = [];
            if ($announcement->recipient & 1) $recipients[] = 'Students';
            if ($announcement->recipient & 2) $recipients[] = 'Teachers';
            if ($announcement->recipient & 4) $recipients[] = 'Staff';
            $row['recipients'] = implode(', ', $recipients) ?: '-';

            $row['status'] = 'Active'; // You can add an active column if needed

            $editUrl = route('annoucement.edit', $announcement->id);
            $deleteUrl = route('annoucement.destroy', $announcement->id);

            $row['action'] = '
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item edit-announcement-btn" data-id="' . $announcement->id . '">
                                <i class="fas fa-edit text-primary me-1"></i> Edit
                            </a>
                        </li>
                        <li>
                            <form id="delete-form-' . $announcement->id . '" action="' . $deleteUrl . '" method="POST" style="margin:0;">
                                ' . csrf_field() . '
                                <button type="button" class="dropdown-item text-danger" onclick="confirmDelete(' . $announcement->id . ')">
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

    // Store new announcement
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'message' => 'required|string',
        'classroom_id' => 'nullable|exists:classrooms,id',
        'recipient' => 'required|array',
    ]);

    $user = auth()->user();
    $allRecipientUsers = collect();

    foreach ($request->recipient as $recipient) {
        // Create announcement for this recipient
        $announcement = annoucement::create([
            'classroom_id' => $request->classroom_id,
            'created_by' => $user->id,
            'title' => $request->title,
            'message' => $request->message,
            'recipient' => $recipient,
        ]);

        // Get users based on recipient type
        $users = User::where('role_id', $recipient)
            ->where(function ($q) use ($request, $recipient) {
                if ($recipient == 3) { // Instructor
                    $instructorId = Batch::find($request->classroom_id)?->instructor_id;
                    if ($instructorId) $q->where('id', $instructorId);
                } elseif ($recipient == 4) { // Students
                    $q->whereHas('batches', function ($q2) use ($request) {
                        $q2->where('batch_id', $request->classroom_id);
                    });
                }
            })->get();

        $allRecipientUsers = $allRecipientUsers->merge($users);

    }

    return redirect()->back()->with('success', 'Announcement created successfully.');
}


    // Get for edit (AJAX)
    public function edit($id)
    {
        $announcement = annoucement::findOrFail($id);

        $recipients = [];
        if ($announcement->recipient & 1) $recipients[] = '1';
        if ($announcement->recipient & 2) $recipients[] = '2';
        if ($announcement->recipient & 4) $recipients[] = '4';
        $announcement->recipient_array = $recipients;

        return response()->json(['announcement' => $announcement]);
    }

    // Update announcement
    public function update(Request $request, $id)
    {
        $annoucement = annoucement::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'classroom_id' => 'nullable|exists:classrooms,id',
            'recipient' => 'required|array',
        ]);

        $recipientBit = 0;
        foreach ($request->recipient as $r) {
            $recipientBit |= (int)$r;
        }

        $annoucement->update([
            'classroom_id' => $request->classroom_id,
            'title' => $request->title,
            'message' => $request->message,
            'recipient' => $recipientBit,
        ]);

        return redirect()->back()->with('success', 'annoucement updated successfully.');
    }

    // Delete annoucement
    public function destroy($id)
    {
        $annoucement = annoucement::findOrFail($id);
        $annoucement->delete();

        return redirect()->back()->with('success', 'annoucement deleted successfully.');
    }
}
