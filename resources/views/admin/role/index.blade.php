@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Role List</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Tables</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Tables</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="javascript:void(0);" class="btn btn-primary btn-wave d-flex align-items-center gap-2"
                    data-bs-toggle="modal" data-bs-target="#addRoleModal">
                    <i class="fas fa-plus"></i> Add Role
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="role-table" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Role Name</th>
                                        <th>Permissions</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Role Modal -->
    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ route('role.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRoleModalLabel">Add Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="role_name_add" class="form-label">Role Name</label>
                            <input type="text" name="name" id="role_name_add" class="form-control" required>
                        </div>

                        <h6>Permissions</h6>
                        <div class="permissions-list">
                            @php
                                $groupedPermissions = [];
                                foreach ($permissions as $perm) {
                                    $groupedPermissions[$perm->module->name][] = $perm;
                                }
                            @endphp

                            @foreach ($groupedPermissions as $moduleName => $perms)
                                <div class="mb-3">
                                    <strong>{{ $moduleName }}</strong><br>
                                    @foreach ($perms as $perm)
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="permissions[]" value="{{ strtolower(trim($perm->name)) }}"
                                                id="add_perm_{{ $perm->id }}" class="form-check-input">
                                            <label for="add_perm_{{ $perm->id }}"
                                                class="form-check-label">{{ $perm->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-orange">Save Role</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Role Modal -->
    <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="editRoleForm" method="POST" action="">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="role_id" id="edit_role_id">

                        <div class="mb-3">
                            <label for="role_name_edit" class="form-label">Role Name</label>
                            <input type="text" name="name" id="role_name_edit" class="form-control" required>
                        </div>

                        <h6>Permissions</h6>
                        <div class="permissions-list" id="editPermissionsList">
                            @foreach ($groupedPermissions as $moduleName => $perms)
                                <div class="mb-3">
                                    <strong>{{ $moduleName }}</strong><br>
                                    @foreach ($perms as $perm)
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="permissions[]" value="{{ strtolower(trim($perm->name)) }}"
                                                id="edit_perm_{{ $perm->id }}"
                                                class="form-check-input edit-permission-checkbox">
                                            <label for="edit_perm_{{ $perm->id }}"
                                                class="form-check-label">{{ $perm->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-orange">Update Role</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            var table = $('#role-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('role.data') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'name', name: 'name' },
                    { data: 'permissions', name: 'permissions', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            // Handle edit button click inside DataTable
            $('#role-table tbody').on('click', '.btn-edit', function() {
                var roleId = $(this).data('id');
                console.log('Editing role ID:', roleId);

                $.ajax({
                    url: '/role/edit/' + roleId,
                    type: 'GET',
                    success: function(response) {
                        var role = response.role;
                        console.log('Role permissions:', role.permissions);

                        $('#role_name_edit').val(role.name);
                        $('#edit_role_id').val(role.id);

                        // Uncheck all permissions first
                        $('#editPermissionsList input[type=checkbox]').prop('checked', false);

                        if (role.permissions && role.permissions.length > 0) {
                            role.permissions.forEach(function(perm) {
                                var permName = perm.name.trim().toLowerCase();
                                $('#editPermissionsList input[type=checkbox]').each(function() {
                                    if ($(this).val().trim().toLowerCase() === permName) {
                                        $(this).prop('checked', true);
                                    }
                                });
                            });
                        }

                        $('#editRoleForm').attr('action', '/role/update/' + role.id);

                        $('#editRoleModal').modal('show');
                    },
                    error: function() {
                        alert('Failed to fetch role data.');
                    }
                });
            });
        });
    </script>
@endpush
