@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Permission List</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Tables</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Tables</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <div class="d-flex gap-2">
                    <div class="position-relative">
                        <button class="btn btn-primary btn-wave" type="button" id="dropdownMenuClickableInside"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            Filter By <i class="ri-arrow-down-s-fill ms-1"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuClickableInside">
                            <li><a class="dropdown-item" href="javascript:void(0);">Today</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Yesterday</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Last 7 Days</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Last 30 Days</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Last 6 Months</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0);">Last Year</a></li>
                        </ul>
                    </div>
                    <a href="javascript:void(0);" class="btn btn-primary btn-wave d-flex align-items-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#addPermissionModal">
                        <i class="fas fa-plus"></i> Add Permission
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table id="permissionsTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Permission Name</th>
                                        <th>Module</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Permission Modal -->
        <div class="modal fade" id="addPermissionModal" tabindex="-1" aria-labelledby="addPermissionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('permission.store') }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPermissionModalLabel">Add Permission</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="module_id_add" class="form-label">Module</label>
                                <select name="module_id" id="module_id_add" class="form-select" required>
                                    <option selected disabled>Select Module</option>
                                    @foreach ($modules as $mod)
                                        <option value="{{ $mod->id }}">{{ $mod->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="name_add" class="form-label">Permission Name</label>
                                <input type="text" name="name" id="name_add" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add Permission</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Permission Modal -->
        <div class="modal fade" id="editPermissionModal" tabindex="-1" aria-labelledby="editPermissionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form id="editPermissionForm" method="POST" action="">
                    @csrf
                    <input type="hidden" name="id" id="edit_permission_id">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editPermissionModalLabel">Edit Permission</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="module_id_edit" class="form-label">Module</label>
                                <select name="module_id" id="module_id_edit" class="form-select" required>
                                    <option selected disabled>Select Module</option>
                                    @foreach ($modules as $mod)
                                        <option value="{{ $mod->id }}">{{ $mod->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="name_edit" class="form-label">Permission Name</label>
                                <input type="text" name="name" id="name_edit" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Update Permission</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
@push('script')
    <script>
        $(function() {
            // Initialize DataTable
            let table = $('#permissionsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('permission.data') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'module',
                        name: 'module'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Open Edit modal
            $(document).on('click', '.edit-btn', function() {
                let id = $(this).data('id'); // Role or Permission id

                $.ajax({
                    url: '/permission/edit/' + id, // Change to your edit route
                    type: 'GET',
                    success: function(response) {
                        // response = { role: {...}, modules: [...] } or { permission: {...}, modules: [...] }

                        // Example if editing a Permission:
                        let permission = response.permission || response
                        .role; // adapt accordingly
                        let modules = response.modules;

                        // Set the form inputs
                        $('#edit_permission_id').val(permission.id);
                        $('#name_edit').val(permission.name);

                        // Populate module select with options, set selected module_id
                        let moduleSelect = $('#module_id_edit');
                        moduleSelect.empty();

                        moduleSelect.append('<option disabled>Select Module</option>');

                        $.each(modules, function(index, mod) {
                            let selected = mod.id === permission.module_id ?
                                'selected' : '';
                            moduleSelect.append('<option value="' + mod.id + '" ' +
                                selected + '>' + mod.module.name + '</option>');
                        });

                        // Set the form action URL dynamically (update route)
                        $('#editPermissionForm').attr('action', '/permission/update/' +
                            permission.id);

                        // Show modal
                        $('#editPermissionModal').modal('show');
                    },
                    error: function() {
                        alert('Error fetching data.');
                    }
                });
            });;


        });
    </script>
@endpush
