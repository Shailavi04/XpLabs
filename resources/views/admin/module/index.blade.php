@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">


        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Modules List</h1>
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
                        <select id="filterRole" class="form-select">
                            <option value="">All Roles</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <a href="javascript:void(0);" class="btn btn-primary btn-wave d-flex align-items-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#addModuleModal">
                        <i class="fas fa-plus"></i> Add Module
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

                            <table id="module-table" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Module Name</th>
                                        <th>Slug</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Modal --}}
    <div class="modal fade" id="addModuleModal">
        <div class="modal-dialog">
            <form id="addModuleForm" action="{{ route('modules.store') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Module</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label>Module Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="add-name" class="form-control" required>

                        <label class="mt-3">Slug</label>
                        <input type="text" name="slug" id="add-slug" class="form-control" readonly>

                        <label class="mt-3">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select">
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="editModuleModal">
        <div class="modal-dialog">
            <!-- IMPORTANT: Add method="POST" here -->
            <form id="editModuleForm" method="POST" action="">
                @csrf
                <input type="hidden" name="id" id="edit-id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Module</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label>Module Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit-name" class="form-control" required>

                        <label class="mt-3">Slug</label>
                        <input type="text" name="slug" id="edit-slug" class="form-control" readonly>

                        <label class="mt-3">Status <span class="text-danger">*</span></label>
                        <select name="status" id="edit-status" class="form-select">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            // Initialize DataTable
            let table = $('#module-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('modules.data') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'slug',
                        name: 'slug'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Slugify helper
            function slugify(text) {
                return text.toString().toLowerCase()
                    .trim()
                    .replace(/\s+/g, '-') // Replace spaces with -
                    .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                    .replace(/\-\-+/g, '-'); // Replace multiple - with single -
            }

            // Auto-update slug in Add Modal
            $('#add-name').on('input', function() {
                $('#add-slug').val(slugify($(this).val()));
            });

            // Auto-update slug in Edit Modal
            $('#edit-name').on('input', function() {
                $('#edit-slug').val(slugify($(this).val()));
            });

            // Open Edit Modal and set form action
            $(document).on('click', '.edit-btn', function() {
                let id = $(this).data('id');
                $.get('{{ url('modules/edit') }}/' + id, function(data) {
                    $('#edit-id').val(data.id);
                    $('#edit-name').val(data.name);
                    $('#edit-slug').val(data.slug);
                    $('#edit-status').val(data.status);

                    // Set form action URL dynamically
                    $('#editModuleForm').attr('action', '{{ url('modules/update') }}/' + id);

                    $('#editModuleModal').modal('show');
                });
            });



            // Delete Module
            $(document).on('click', '.delete-btn', function() {
                if (confirm('Are you sure you want to delete this module?')) {
                    let id = $(this).data('id');
                    $.ajax({
                        url: '{{ url('/modules/destroy') }}/' + id,
                        type: 'POST', // Use POST (with method spoofing in Laravel if DELETE)
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            if (res.success) {
                                table.ajax.reload();
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
