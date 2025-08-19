@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Category List</h1>
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
                        data-bs-toggle="modal" data-bs-target="#addcategory">
                        <i class="fas fa-plus"></i> Add Category
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
                            <table id="category-table" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Image</th>
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


    {{-- Add Category Modal --}}
    <div class="modal fade" id="addcategory" tabindex="-1" aria-labelledby="addcategoryLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data"
                id="addCategoryForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Add New Category') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="name" class="form-label">
                                    Category Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name') }}" required>
                            </div>



                            <div class="col-md-12">
                                <label for="active" class="form-label">Status<span class="text-danger">*</span></label>
                                <select name="active" id="active" class="form-select" required>
                                    <option value="1" {{ old('active', 1) == 1 ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="0" {{ old('active') == '0' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label for="image" class="form-label">Category Image</label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Category</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Category Modal --}}
    <div class="modal fade" id="editcategory" tabindex="-1" aria-labelledby="editcategoryLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form method="POST" enctype="multipart/form-data" id="editCategoryForm">
                @csrf
                {{-- We'll add method spoofing dynamically --}}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit-category-id" />
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="edit-name" class="form-label">Category Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="edit-name" class="form-control" required>
                            </div>

                            <div class="col-md-12">
                                <label for="edit-active" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="active" id="edit-active" class="form-select" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label for="edit-image" class="form-label">Category Image</label>
                                <input type="file" name="image" id="edit-image" class="form-control"
                                    accept="image/*">
                                <div id="current-image" class="mt-2"></div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Category</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            var table = $('#category-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('categories.data') }}',
                dom: 'lBfrtip',
                responsive: true,
                buttons: [{
                        extend: 'copy',
                        text: 'Copy',
                        className: 'ms-2 btn btn-sm btn-info'
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        className: 'btn btn-sm btn-info'
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        className: 'btn btn-sm btn-info'
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        className: 'btn btn-sm btn-info'
                    }
                ],
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Show All"]
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    searchPlaceholder: "Search categories...",
                    search: "",
                },
            });

            // Add Bootstrap classes to search input and length select for styling
            $('#category-table_filter input').addClass('form-control form-control-sm');
            $('#category-table_length select').addClass('form-select form-select-sm');

            // Add spacing for controls
            $('.dataTables_wrapper .dataTables_filter').addClass('mb-3');
            $('.dataTables_wrapper .dataTables_length').addClass('mb-3');

            // Edit button click event (using delegated event)
            $('#category-table').on('click', '.btn-edit', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                // Ajax to get category data by id
                $.ajax({
                    url: '{{ url('categories/edit') }}/' + id,
                    method: 'GET',
                    success: function(response) {
                        // Populate modal fields
                        $('#edit-category-id').val(response.id);
                        $('#edit-name').val(response.name);
                        $('#edit-active').val(response.active);

                        // Show current image if exists
                        if (response.photo) {
                            $('#current-image').html(
                                '<img src="{{ asset('uploads/category') }}/' + response
                                .photo +
                                '" alt="Current Image" width="80" style="border-radius: 4px;">'
                            );
                        } else {
                            $('#current-image').html('No image uploaded');
                        }

                        // Set form action and method
                        $('#editCategoryForm').attr('action',
                            '{{ url('categories/update') }}/' + id);
                        $('#editCategoryForm').prepend(
                            '<input type="hidden" name="_method" value="POST">'
                        ); // since you use POST for update

                        // Show modal
                        $('#editcategory').modal('show');
                    },
                    error: function(xhr) {
                        alert('Failed to fetch data.');
                    }
                });
            });

            // Optionally, handle edit form submit via AJAX to update and refresh table without reload
            // Or just let the form submit normally to the update route

        });


        $(document).on('click', '.category-delete-btn', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745', // green
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endpush
