<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudyMaterial;
use App\Models\Batch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class Studymaterialcontroller extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $userId = $user->id;

        if ($user->role_id == 1) {
            $courses = DB::table('courses')->get();
            $batches = Batch::all();
        } else {
            $userCenterIds = DB::table('center_user')
                ->where('user_id', $userId)
                ->pluck('center_id')
                ->toArray();

            $courseIds = DB::table('center_course')
                ->whereIn('center_id', $userCenterIds)
                ->pluck('course_id')
                ->toArray();

            $courses = DB::table('courses')
                ->whereIn('id', $courseIds)
                ->get();

            $batches = Batch::whereIn('course_id', $courseIds)->get();
        }

        return view('admin.study_material.index', compact('courses', 'batches'));
    }


    public function data(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'] ?? null;

        $query = StudyMaterial::with('batch', 'course');

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('title', 'like', "%{$searchValue}%")
                    ->orWhere('description', 'like', "%{$searchValue}%")
                    ->orWhere('type', 'like', "%{$searchValue}%");
            });
        }

        $totalRecords = $query->count();
        $totalFiltered = (clone $query)->count();

        if (is_numeric($length) && $length > 0) {
            $query->skip($start)->take($length);
        }

        $materials = $query->latest()->get();
        $data = [];
        $i = $start + 1;

        foreach ($materials as $material) {
            $row = [];
            $row['DT_RowIndex'] = $i++;
            $row['title'] = $material->title;
            $row['course'] = $material->course->name ?? '-';
            $row['batch'] = $material->batch->name ?? '-';
            $row['type'] = ucfirst($material->type);
            $row['description'] = Str::limit($material->description, 50);
            Log::info('Material Type: ' . $material->type);

            if ($material->type === 'link') {
                dd($material->type);
                $row['resource'] = '<a href="' . $material->value . '" target="_blank">Open Link</a>';
            } elseif (in_array($material->type, ['pdf', 'video', 'other']) && $material->value) {
                $row['resource'] = '<a href="' . asset($material->value) . '" target="_blank">Download</a>';
            } 

            $row['status'] = $material->status ? 'Active' : 'Inactive';


            $editUrl = route('study_material.edit', $material->id);
            $deleteUrl = route('study_material.destroy', $material->id);

            $row['action'] = '
<div class="btn-group">
    <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0.25rem 0.5rem;">
        <i class="fas fa-ellipsis-v"></i>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a class="dropdown-item edit-material-btn" href="javascript:void(0);" data-id="' . $material->id . '" data-bs-toggle="modal" data-bs-target="#editStudyMaterialModal">
                <i class="fas fa-edit me-1 text-primary"></i> Edit
            </a>
           

        </li>
        <li>
            <form action="' . $deleteUrl . '" method="POST" class="delete-material-form" style="margin:0;">
                ' . csrf_field() . method_field('DELETE') . '
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
            'course_id' => 'nullable|exists:courses,id',
            'batch_id' => 'required|exists:batches,id',
            'type' => 'required|in:pdf,video,link,other',
            'value' => $request->type === 'link' ? 'required|url' : 'nullable|file|mimes:pdf,mp4,mov,jpg,jpeg,png',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $value = null;

        if ($request->type === 'link') {
            $value = $request->value; // store link directly
        } else if ($request->hasFile('value')) {
            $file = $request->file('value');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/study_materials'), $filename); // move to public/uploads/study_materials
            $value = 'uploads/study_materials/' . $filename; // store relative path
        }

        StudyMaterial::create([
            'title' => $request->title,
            'course_id' => $request->course_id,
            'batch_id' => $request->batch_id,
            'type' => $request->type,
            'value' => $value,
            'description' => $request->description,
            'status' => $request->status,
            'created_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Study Material added successfully.');
    }

    public function edit($id)
    {
        $material = StudyMaterial::with(['course', 'batch'])->findOrFail($id);

        return response()->json(['material' => $material]);
    }

    public function update(Request $request, $id)
    {
        $material = StudyMaterial::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'nullable|exists:courses,id',
            'batch_id' => 'required|exists:batches,id',
            'type' => 'required|in:pdf,video,link,other',
            'value' => $request->type !== 'link' ? 'nullable|file|mimes:pdf,mp4,mov,jpg,jpeg,png' : 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        // Handle file or link
        if ($request->type === 'link') {
            $value = $request->value; // URL
        } elseif ($request->hasFile('value')) {
            $file = $request->file('value');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/study_materials'), $filename);
            $value = 'uploads/study_materials/' . $filename;
        } else {
            $value = $material->value;
        }

        $material->update([
            'title' => $request->title,
            'course_id' => $request->course_id,
            'batch_id' => $request->batch_id,
            'type' => $request->type,
            'value' => $value,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Study Material updated successfully.');
    }


    public function destroy($id)
    {
        $material = StudyMaterial::findOrFail($id);
        $material->delete();

        return redirect()->back()->with('success', 'Study Material deleted successfully.');
    }

    public function getBatchesByCourse(Request $request)
    {
        $courseId = $request->course_id;

        $batches = Batch::where('course_id', $courseId)
            ->select('id', 'name')
            ->get();

        return response()->json(['batches' => $batches]);
    }
}
