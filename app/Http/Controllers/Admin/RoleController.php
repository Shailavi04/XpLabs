<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {

        $permissions = Permission::get();

        return view('admin.role.index', compact('permissions'));
    }

    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            // 'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);


        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        if (!$role) {
            return redirect()->route('role.index')->with('error', 'Failed to create role.');
        }

        Log::info('Permissions received:', ['permissions' => $request->permissions]);



        if ($request->filled('permissions')) {
            $role->syncPermissions($request->permissions);

            $syncedPermissions = $role->permissions()->pluck('name')->toArray();
            Log::info('Permissions after sync:', ['synced_permissions' => $syncedPermissions]);

            if (empty($syncedPermissions)) {
                return redirect()->route('role.index')->with('error', 'Failed to sync permissions.');
            }
        } else {
            Log::warning('No permissions provided for syncing.');
        }

        return redirect()->route('role.index')->with('success', 'Role created and permissions synced successfully.');
    }


    public function data(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start', 0);
        $length = $request->get('length', 10);
        $searchValue = $request->input('search.value');

        $query = Role::query();

        // Total records before filtering
        $totalRecords = $query->count();

        // Filtering
        if (!empty($searchValue)) {
            $query->where('name', 'like', '%' . $searchValue . '%');
        }

        // Total filtered records
        $totalFiltered = (clone $query)->count();

        // Pagination
        if (is_numeric($length) && $length > 0) {
            $query->skip($start)->take($length);
        }

        // Fetch roles ordered by creation date
        $roles = $query->orderBy('created_at', 'desc')->get();

        $data = [];
        $index = $start + 1;

        foreach ($roles as $role) {
            // Get permissions badges array
            $permBadges = $role->permissions->map(function ($perm) {
                return '<span class="badge bg-primary me-1 mb-1">' . e($perm->name) . '</span>';
            })->toArray();

            // Group badges into chunks of 6 (or 8)
            $chunked = array_chunk($permBadges, 6);

            // Implode each chunk into a line and then join with <br>
            $permissions = implode('<br>', array_map(function ($chunk) {
                return implode(' ', $chunk);
            }, $chunked));

            if (empty($permissions)) {
                $permissions = '<em>No permissions</em>';
            }

            $editUrl = route('role.edit', $role->id);
            $deleteUrl = route('role.destroy', $role->id);

            // Actions HTML (Edit + Delete buttons)
            $actions = '
<div class="btn-group">
    <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0.25rem 0.5rem;">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 5.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 1.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3zm0 4.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3z"/>
        </svg>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a class="dropdown-item btn-edit" href="javascript:void(0);" data-id="' . $role->id . '" data-name="' . e($role->name) . '">
                <i class="fas fa-edit me-1 text-primary"></i> Edit
            </a>
        </li>
        <li>
            <form action="' . route('role.destroy', $role->id) . '" method="POST" class="delete-role-form" style="margin:0;">
                ' . csrf_field() . method_field('DELETE') . '
                <button type="submit" class="dropdown-item text-danger role-delete-btn" onclick="return confirm(\'Are you sure you want to delete this role?\');">
                    <i class="fas fa-trash-alt me-1"></i> Delete
                </button>
            </form>
        </li>
    </ul>
</div>';



            $data[] = [
                'DT_RowIndex' => $index++,
                'name' => $role->name,
                'permissions' => $permissions ?: '<em>No permissions</em>',
                'action' => $actions,
            ];
        }

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data,
        ]);
    }


    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);

        $modules = Permission::with('module')->get();

        return response()->json(['role' => $role, 'modules' => $modules]);
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'permissions' => 'array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $role = Role::findOrFail($id);

        $role->update([
            'name' => $request->name,
        ]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        // Redirect back to the role index with a success message
        return redirect()->route('role.index')->with('success', 'Role updated successfully.');
    }
}
