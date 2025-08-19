@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">User List</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Tables</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Tables</li>
                    </ol>
                </nav>
            </div>


            <div class="d-flex align-items-center gap-2 flex-wrap">
                <div class="d-flex gap-2">
                    <input type="hidden" id="filterRole" value="">

                    <div class="position-relative">
                        <button class="btn btn-primary btn-wave" type="button" id="dropdownMenuRoles"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            Filter By Role <i class="ri-arrow-down-s-fill ms-1"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuRoles">
                            <li><a class="dropdown-item role-filter" href="javascript:void(0);" data-role="">All Roles</a>
                            </li>
                            @foreach ($roles as $role)
                                <li>
                                    <a class="dropdown-item role-filter" href="javascript:void(0);"
                                        data-role="{{ $role->id }}">
                                        {{ $role->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <a href="javascript:void(0);" class="btn btn-primary btn-wave d-flex align-items-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#addRoleModal">
                        <i class="fas fa-plus"></i> Add Users
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="user-table" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Sr no.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
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

    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRoleModalLabel">Add User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-4">
                                <label for="name" class="form-label">Name<span style="color: red;">*</span></label>
                                <input class="form-control" type="text" name="name" id="name" required
                                    placeholder="Enter your name">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-4">
                                <label for="phone_number" class="form-label">Mobile<span
                                        style="color: red;">*</span></label>
                                <input class="form-control" type="text" name="phone_number" id="phone_number" required
                                    placeholder="Enter your mobile">
                                @error('phone_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="col-4">
                                <label for="email" class="form-label">Email<span style="color: red;">*</span></label>
                                <input class="form-control" type="email" name="email" id="email"
                                    placeholder="Enter your email">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="col-4">
                                <label for="password" class="form-label">Password<span style="color: red;">*</span></label>
                                <input class="form-control" type="password" name="password" id="password"
                                    placeholder="Enter your password">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-4">
                                <label for="role" class="form-label">Role<span style="color: red;">*</span></label>
                                <select class="form-select" name="role" id="role">
                                    <option selected disabled>--Select Role--</option>
                                    @foreach ($roles as $item)
                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="col-4">
                                <label for="profile_image" class="form-label">Profile Image</label>
                                <input class="form-control" type="file" name="profile_image" id="profile_image"
                                    accept="image/*">
                                @error('profile_image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" name="address" id="address" rows="3" placeholder="Enter address"></textarea>
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-orange">Save Role</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="editRoleForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" id="edit_user_id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editRoleModalLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">

                            <div class="col-4">
                                <label>Name <span style="color: red;">*</span></label>
                                <input type="text" name="name" id="edit_name" class="form-control" required>
                            </div>

                            <div class="col-4">
                                <label>Phone Number <span style="color: red;">*</span></label>
                                <input type="text" name="phone_number" id="edit_phone_number" class="form-control"
                                    required>
                            </div>

                            <div class="col-4">
                                <label>Email <span style="color: red;">*</span></label>
                                <input type="email" name="email" id="edit_email" class="form-control" required>
                            </div>

                            <div class="col-4">
                                <label>Role <span style="color: red;">*</span></label>
                                <select name="role" id="edit_role" class="form-select" required>
                                    @foreach ($roles as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-4">
                                <label>Status <span style="color: red;">*</span></label>
                                <select name="status" id="edit_status" class="form-select" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <div class="col-4">
                                <label>Profile Image</label>
                                <input type="file" name="profile_image" id="edit_profile_image" class="form-control"
                                    accept="image/*">
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-orange">Update User</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            $(function() {
                var table = $('#user-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('users.data') }}',
                        data: function(d) {
                            d.role_id = $('#filterRole').val(); // hidden input ka value
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
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
                            data: 'role',
                            name: 'role'
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

                $('.role-filter').on('click', function() {
                    var roleId = $(this).data('role');
                    $('#filterRole').val(roleId); // hidden input update
                    table.ajax.reload();
                });
            });



            $('#user-table').on('click', '.edit-user-btn', function() {
                var userId = $(this).data('id');


                $.ajax({
                    url: '/users/edit/' + userId,
                    type: 'GET',
                    success: function(response) {
                        var user = response.user;

                        $('#edit_user_id').val(user.id);
                        $('#edit_name').val(user.name);
                        $('#edit_email').val(user.email);
                        $('#edit_role').val(user.role_id); // must match <option value="id">
                        $('#edit_phone_number').val(user.phone_number);
                        $('#edit_status').val(user.status);

                        // Set form action
                        $('#editRoleForm').attr('action', '/users/update/' + user.id);

                        // Show modal using Bootstrap 5
                        var editModal = new bootstrap.Modal(document.getElementById(
                            'editRoleModal'));
                        editModal.show();
                    },
                    error: function() {
                        alert('Failed to fetch user data.');
                    }
                });
            });


        });
    </script>
@endpush
