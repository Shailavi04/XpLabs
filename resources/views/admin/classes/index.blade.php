@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Center List</h1>
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
                        <i class="fas fa-plus"></i> Add Center
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
                            <table id="classes-table" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Status</th>
                                        <th>Created at</th>
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
    {{-- Add Center Modal --}}
    <div class="modal fade" id="addcategory" tabindex="-1" aria-labelledby="addcategoryLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form action="{{ route('classes.store') }}" method="POST" enctype="multipart/form-data" id="addCategoryForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Add New Center') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">



                            <div class="col-md-6">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name') }}" required />
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email') }}" required />
                            </div>

                            <div class="col-md-6">
                                <label for="phone_number" class="form-label">Phone Number <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="phone_number" id="phone_number" class="form-control"
                                    value="{{ old('phone_number') }}" required />
                            </div>

                            <div class="col-md-6">
                                <label for="code" class="form-label">Center Code <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="code" id="code" class="form-control"
                                    value="{{ old('code') }}" required />
                            </div>

                            <div class="col-md-6">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" name="country" id="country" class="form-control"
                                    value="{{ old('country') }}" />
                            </div>

                            <div class="col-md-6">
                                <label for="state" class="form-label">State</label>
                                <input type="text" name="state" id="state" class="form-control"
                                    value="{{ old('state') }}" />
                            </div>

                            <div class="col-md-6">
                                <label for="city" class="form-label">City</label>
                                <input type="text" name="city" id="city" class="form-control"
                                    value="{{ old('city') }}" />
                            </div>

                            <div class="col-md-6">
                                <label for="postal_code" class="form-label">Postal Code</label>
                                <input type="text" name="postal_code" id="postal_code" class="form-control"
                                    value="{{ old('postal_code') }}" />
                            </div>

                            <div class="col-md-12">
                                <label for="address" class="form-label">Address</label>
                                <textarea name="address" id="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                            </div>

                            <div class="col-md-6">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="text" name="longitude" id="longitude" class="form-control"
                                    value="{{ old('longitude') }}" />
                            </div>

                            <div class="col-md-6">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" name="latitude" id="latitude" class="form-control"
                                    value="{{ old('latitude') }}" />
                            </div>

                            <div class="col-md-12">
                                <label for="website" class="form-label">Website</label>
                                <input type="url" name="website" id="website" class="form-control"
                                    value="{{ old('website') }}" />
                            </div>

                            <div class="col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <label for="profile_image" class="form-label">Profile Image</label>
                                <input type="file" name="profile_image" id="profile_image" class="form-control"
                                    accept="image/*" />
                            </div>

                            <div class="col-md-12">
                                <label for="active" class="form-label">Status</label>
                                <select name="active" id="active" class="form-select">
                                    <option value="1"{{ old('active') == '1' ? ' selected' : '' }}>Active</option>
                                    <option value="0"{{ old('active') == '0' ? ' selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Center</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <!-- Edit Class Modal -->
    <div class="modal fade" id="editClassModal" tabindex="-1" aria-labelledby="editClassModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form method="POST" action="#" id="editClassForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editClassModalLabel">Edit Center</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit-class-id" />

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="edit-name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="edit-name" class="form-control" required />
                            </div>

                            <div class="col-md-6">
                                <label for="edit-email" class="form-label">Email <span
                                        class="text-danger">*</span></label>
                                <input type="email" name="email" id="edit-email" class="form-control" required />
                            </div>

                            <div class="col-md-6">
                                <label for="edit-phone" class="form-label">Phone Number <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="phone_number" id="edit-phone" class="form-control"
                                    required />
                            </div>

                            <div class="col-md-6">
                                <label for="edit-code" class="form-label">Center Code <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="code" id="edit-code" class="form-control" required />
                            </div>

                            <div class="col-md-6">
                                <label for="edit-country" class="form-label">Country</label>
                                <input type="text" name="country" id="edit-country" class="form-control" />
                            </div>

                            <div class="col-md-6">
                                <label for="edit-state" class="form-label">State</label>
                                <input type="text" name="state" id="edit-state" class="form-control" />
                            </div>

                            <div class="col-md-6">
                                <label for="edit-city" class="form-label">City</label>
                                <input type="text" name="city" id="edit-city" class="form-control" />
                            </div>

                            <div class="col-md-6">
                                <label for="edit-postal_code" class="form-label">Postal Code</label>
                                <input type="text" name="postal_code" id="edit-postal_code" class="form-control" />
                            </div>

                            <div class="col-md-12">
                                <label for="edit-address" class="form-label">Address</label>
                                <textarea name="address" id="edit-address" class="form-control" rows="2"></textarea>
                            </div>

                            <div class="col-md-6">
                                <label for="edit-longitude" class="form-label">Longitude</label>
                                <input type="text" name="longitude" id="edit-longitude" class="form-control" />
                            </div>

                            <div class="col-md-6">
                                <label for="edit-latitude" class="form-label">Latitude</label>
                                <input type="text" name="latitude" id="edit-latitude" class="form-control" />
                            </div>

                            <div class="col-md-12">
                                <label for="edit-website" class="form-label">Website</label>
                                <input type="url" name="website" id="edit-website" class="form-control" />
                            </div>

                            <div class="col-md-12">
                                <label for="edit-description" class="form-label">Description</label>
                                <textarea name="description" id="edit-description" class="form-control" rows="3"></textarea>
                            </div>

                            <div class="col-md-12">
                                <label for="edit-profile-image" class="form-label">Profile Image</label>
                                <input type="file" name="profile_image" id="edit-profile-image" class="form-control"
                                    accept="image/*" />
                                <div id="current-edit-image" class="mt-2"></div>
                            </div>

                            <div class="col-md-12">
                                <label for="edit-active" class="form-label">Status</label>
                                <select name="active" id="edit-active" class="form-select">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Center</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="assignStaffModal" tabindex="-1" aria-labelledby="assignStaffModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="assignStaffForm" method="POST" action="">
                @csrf
                <input type="hidden" name="center_id" id="modal_center_id" value="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignStaffModalLabel">Assign Staff to Center</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <select name="center_staff[]" id="center_staff" class="form-select" multiple required>
                                <option value="" disabled>-- Select Staff --</option>
                                @foreach ($user_center_staff as $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                @endforeach
                            </select>

                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Assign Staff</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            var table = $('#classes-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('classes.data') }}',
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
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone_number',
                        name: 'phone_number'
                    },

                    {
                        data: 'status',
                        name: 'status'
                    },

                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    // {
                    //     data: 'image',
                    //     name: 'image',
                    //     orderable: false,
                    //     searchable: false
                    // },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    searchPlaceholder: "Search classes...",
                    search: "",
                },
            });

            $('#classes-table').on('click', '.edit-class-btn', function(e) {
                e.preventDefault();
                var id = $(this).data('id');

                $.ajax({
                    url: '{{ url('classes/edit') }}/' + id,
                    method: 'GET',
                    success: function(response) {
                        let user = response.user || {};

                        $('#edit-class-id').val(user.id || '');
                        $('#edit-name').val(user.name || '');
                        $('#edit-email').val(user.email || '');
                        $('#edit-phone').val(user.phone_number || '');
                        $('#edit-code').val(user.code || '');

                        $('#edit-country').val(user.country || '');
                        $('#edit-state').val(user.state || '');
                        $('#edit-city').val(user.city || '');
                        $('#edit-postal_code').val(user.postal_code || '');
                        $('#edit-address').val(user.address || '');
                        $('#edit-longitude').val(user.longitude || '');
                        $('#edit-latitude').val(user.latitude || '');
                        $('#edit-website').val(user.website || '');
                        $('#edit-description').val(user.description || '');

                        $('#edit-active').val(user.active ? '1' : '0');

                        let imagePath = user.profile_image ? "/uploads/classes/" + user
                            .profile_image : null;
                        if (imagePath) {
                            $('#current-edit-image').html('<img src="' + imagePath +
                                '" width="80" class="rounded">');
                        } else {
                            $('#current-edit-image').html('No image uploaded');
                        }

                        $('#editClassForm').attr('action', '{{ url('classes/update') }}/' +
                            user
                            .id);
                        $('#editClassModal').modal('show');
                    },
                    error: function(xhr) {
                        alert('Failed to fetch center data');
                    }
                });
            });


            // Add Bootstrap classes to search input and length select for styling

        });

        $(document).ready(function() {
            // When Assign Staff button clicked in action dropdown
            $(document).on('click', '.assign-staff-btn', function() {
                var centerId = $(this).data('center-id');
                $('#modal_center_id').val(centerId);

                // Clear previous selections (optional)
                $('#center_staff').val(null).trigger('change');
            });

            // Handle assign staff form submit
            $('#assignStaffForm').submit(function(e) {
                e.preventDefault();

                var centerId = $('#modal_center_id').val();
                // Get all selected staff IDs as array
                var staffIds = $('#center_staff').val(); // This is an array for multi-select
                var token = $('input[name=_token]').val();

                if (!staffIds || staffIds.length === 0) {
                    alert('Please select at least one staff member.');
                    return;
                }

                $.ajax({
                    url: '/classes/assign/' + centerId,
                    method: 'POST',
                    data: {
                        'center_staff': staffIds, // pass array as 'center_staff' to match Laravel validation
                        _token: token
                    },
                    success: function(response) {
                        alert(response.message || 'Staff assigned successfully');
                        $('#assignStaffModal').modal('hide');
                        // Optionally reload data or table here
                    },
                    error: function(xhr) {
                        alert('Failed to assign staff');
                    }
                });
            });
        });
    </script>
@endpush
