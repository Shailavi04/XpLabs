<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $modules = Module::all();
        return view('admin.permission.index', compact('modules'));
    }

   public function data(Request $request)
{
    $columns = ['id', 'name', 'module_id', 'created_at'];

    $draw = $request->get('draw');
    $start = $request->get('start');
    $length = $request->get('length');
    $search = $request->get('search')['value'] ?? '';

    $totalRecords = Permission::count();

    $query = Permission::with('module');

    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhereHas('module', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                });
        });
    }

    $totalFiltered = $query->count();

    if ($request->has('order')) {
        $orderColumnIndex = $request->get('order')[0]['column'];
        $orderColumn = $columns[$orderColumnIndex] ?? 'created_at';
        $orderDir = $request->get('order')[0]['dir'] ?? 'desc';

        // Force descending order for 'id' and 'created_at' columns to show latest first
        if (in_array($orderColumn, ['id', 'created_at'])) {
            $orderDir = 'desc';
        }

        $query->orderBy($orderColumn, $orderDir);
    } else {
        // Default order: newest first
        $query->orderBy('created_at', 'desc');
    }

    $permissions = $query->offset($start)->limit($length)->get();

    $data = [];
    foreach ($permissions as $index => $permission) {
        $row = [];
        $row['DT_RowIndex'] = $start + $index + 1;
        $row['name'] = e($permission->name);
        $row['module'] = e($permission->module->name ?? 'N/A');

        $row['action'] = '
        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0.25rem 0.5rem;">
                Actions
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a href="javascript:void(0)" 
                       class="dropdown-item edit-btn" 
                       data-id="' . $permission->id . '">
                       <i class="bi bi-pencil-square"></i> Edit
                    </a>
                </li>
                <li>
                    <form id="delete-form-' . $permission->id . '" action="' . route('permission.destroy', $permission->id) . '" method="POST" style="display: none;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                    </form>
                    <a href="javascript:void(0);" class="dropdown-item text-danger" onclick="confirmDelete(' . $permission->id . ')">
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
            'name' => 'required|string',
            'module_id' => 'required|exists:modules,id',
        ]);

        Permission::create([
            'name' => $request->name,
            'module_id' => $request->module_id,
        ]);

        return redirect()->route('permission.index')->with('success', 'Permission created successfully.');
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return response()->json($permission);
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id,
            'module_id' => 'required|exists:modules,id',
        ]);

        $permission->update([
            'name' => $request->name,
            'module_id' => $request->module_id,
        ]);

        return redirect()->route('permission.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route('permission.index')->with('success', 'Permission deleted successfully.');
    }
}
