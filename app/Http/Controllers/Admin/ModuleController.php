<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Role;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        $roles = Role::get();

        return view('admin.module.index', compact('roles'));
    }

    public function data(Request $request)
    {
        $columns = ['id', 'name', 'status', 'created_at']; // add columns you want for ordering/searching

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->get('search')['value'];

        // Total records count
        $totalRecords = Module::count();

        // Base query
        $query = Module::query();

        // Apply search filter if any
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Total filtered records count after search
        $totalFiltered = $query->count();

        // Apply ordering
        if ($request->has('order')) {
            $orderColumnIndex = $request->get('order')[0]['column'];
            $orderColumn = $columns[$orderColumnIndex] ?? 'created_at';
            $orderDir = $request->get('order')[0]['dir'] ?? 'desc';
            $query->orderBy($orderColumn, $orderDir);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Apply pagination limit and offset
        $modules = $query->offset($start)->limit($length)->get();

        $data = [];
        foreach ($modules as $index => $module) {
            $row = [];
            $row['DT_RowIndex'] = $start + $index + 1;
            $row['name'] = e($module->name);
            $row['slug'] = $module->slug;
            $row['status'] = $module->status == 1
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-danger">Inactive</span>';
            $row['action'] = '
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0.25rem 0.5rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 5.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 1.5a1.5 1.5 0 1 1 0 3
                            1.5 1.5 0 0 1 0-3zm0 4.5a1.5 1.5 0 1 1 0 3
                            1.5 1.5 0 0 1 0-3z" />
                    </svg>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item edit-btn" href="javascript:void(0);" data-id="' . $module->id . '">
                            <i class="fas fa-edit text-primary me-1"></i> Edit
                        </a>
                    </li>
                    <li>
                        <form id="delete-form-' . $module->id . '" action="' . route('modules.destroy', $module->id) . '" method="POST" style="display: none;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                        </form>
                        <a href="javascript:void(0);" class="dropdown-item text-danger" onclick="if(confirm(\'Are you sure?\')) { document.getElementById(\'delete-form-' . $module->id . '\').submit(); }">
                            <i class="fas fa-trash-alt me-1"></i> Delete
                        </a>
                    </li>
                </ul>
            </div>';
            $data[] = $row;
        }

        return response()->json([
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalFiltered,
            "data" => $data,
        ]);
    }



    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255|unique:modules,name',
            'status' => 'required|in:0,1'
        ]);


        Module::create([
            'name'   => $request->name,
            'status' => $request->status,
            'slug' => $request->slug
        ]);

        return redirect()->route('modules.index')->with('success', 'Module Added Successfully!');
    }

    public function edit($id)
    {
        $module = Module::findOrFail($id);
        return response()->json($module);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'status' => 'required|in:0,1'
        ]);

        $module = Module::findOrFail($id);
        $module->update([
            'name'   => $request->name,
            'status' => $request->status
        ]);

        return redirect()->route('modules.index')->with('success', 'Module updated successfully.');
    }

    public function destroy($id)
    {
        Module::destroy($id);
        return response()->json(['success' => true, 'message' => 'Module deleted successfully.']);
    }
}
