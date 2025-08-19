@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Student List</h1>
                <div>
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
                        id="btnAddStudent">
                        <i class="fas fa-plus"></i><span>{{ __('Add New Student') }}</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="students-table" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Joining Date</th>
                                        <th>Photo</th>
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

    <!-- Add Student Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="addStudentForm" method="POST" action="{{ route('student.store') }}" enctype="multipart/form-data"
                class="needs-validation" novalidate>
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addStudentModalLabel">Add Student</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">

                            <div class="col-md-4">
                                <label class="form-label">Center <span class="text-danger">*</span></label>
                                <select name="center_id" class="form-select" required>
                                    <option value="">-- Select Center --</option>
                                    @foreach ($centers as $center)
                                        <option value="{{ $center->id }}">{{ $center->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Student <span class="text-danger">*</span></label>
                                <select name="user_id" class="form-select" required>
                                    <option value="">-- Select Student --</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Gender <span class="text-danger">*</span></label>
                                <select class="form-select" name="gender" required>
                                    <option value="">-- Select --</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" name="dob">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control" name="city">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">State</label>
                                <input type="text" class="form-control" name="state">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Country</label>
                                <input type="text" class="form-control" name="country" value="India">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Postal Code</label>
                                <input type="text" class="form-control" name="postal_code">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Parent/Guardian Name</label>
                                <input type="text" class="form-control" name="parent_name">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Parent/Guardian Contact Number</label>
                                <input type="tel" class="form-control" name="parent_contact_number"
                                    placeholder="+91 9876543210">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Alternate Contact Number</label>
                                <input type="tel" class="form-control" name="alternate_contact_number"
                                    placeholder="+91 9123456789">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Nationality</label>
                                <input type="text" class="form-control" name="nationality" placeholder="Indian">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Education Level</label>
                                <select class="form-select" name="education_level">
                                    <option value="">-- Select Education Level --</option>
                                    <option value="high_school">High School</option>
                                    <option value="intermediate">Intermediate</option>
                                    <option value="graduate">Graduate</option>
                                    <option value="post_graduate">Post Graduate</option>
                                    <option value="diploma">Diploma</option>
                                    <option value="phd">PhD</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Blood Group</label>
                                <input type="text" class="form-control" name="blood_group" placeholder="e.g. B+">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" name="status" required>
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <!-- Long fields in full width -->
                            <div class="col-md-12">
                                <label class="form-label">Bio / Remarks</label>
                                <textarea class="form-control" name="bio" rows="2"></textarea>
                            </div>

                            {{-- <div class="col-md-4">
                                <label class="form-label">Photo</label>
                                <input type="file" class="form-control" name="image" accept=".jpg,.jpeg,.png">
                            </div> --}}

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btnAddSave">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="editStudentForm" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                <input type="hidden" name="student_id" id="edit_student_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">


                            {{-- <div class="col-md-4">

                                <label class="form-label">Photo</label>

                                <input type="file" class="form-control" id="edit_image" name="image"
                                    accept=".jpg,.jpeg,.png">
                                <div class="mt-2" id="current_image_preview"></div> <!-- Current image shown here -->

                            </div> --}}

                            <div class="col-md-4">
                                <label class="form-label">Center <span class="text-danger">*</span></label>
                                <select name="center_id" id="edit_center_id" class="form-select" required>
                                    <option value="">-- Select Center --</option>
                                    @foreach ($centers as $center)
                                        <option value="{{ $center->id }}">{{ $center->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Student <span class="text-danger">*</span></label>
                                <select name="user_id" id="edit_user_id" class="form-select" required>
                                    <option value="">-- Select Student --</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Gender <span class="text-danger">*</span></label>
                                <select class="form-select" id="edit_gender" name="gender" required>
                                    <option value="">-- Select --</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="edit_dob" name="dob">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control" id="edit_city" name="city">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">State</label>
                                <input type="text" class="form-control" id="edit_state" name="state">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Country</label>
                                <input type="text" class="form-control" id="edit_country" name="country">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Postal Code</label>
                                <input type="text" class="form-control" id="edit_postal_code" name="postal_code">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Parent/Guardian Name</label>
                                <input type="text" class="form-control" id="edit_parent_name" name="parent_name">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Parent/Guardian Contact Number</label>
                                <input type="tel" class="form-control" id="edit_parent_contact"
                                    name="parent_contact_number">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Alternate Contact Number</label>
                                <input type="tel" class="form-control" id="edit_alternate_contact"
                                    name="alternate_contact_number">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Nationality</label>
                                <input type="text" class="form-control" id="edit_nationality" name="nationality">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Education Level</label>
                                <select class="form-select" id="edit_education_level" name="education_level">
                                    <option value="">-- Select Education Level --</option>
                                    <option value="high_school">High School</option>
                                    <option value="intermediate">Intermediate</option>
                                    <option value="graduate">Graduate</option>
                                    <option value="post_graduate">Post Graduate</option>
                                    <option value="diploma">Diploma</option>
                                    <option value="phd">PhD</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Blood Group</label>
                                <input type="text" class="form-control" id="edit_blood_group" name="blood_group">
                            </div>

                            {{-- <div class="col-md-4">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="edit_status" name="status" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div> --}}

                            <div class="col-md-12">
                                <label class="form-label">Bio / Remarks</label>
                                <textarea class="form-control" id="edit_bio" name="bio" rows="2"></textarea>
                            </div>



                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


@push('script')
    <script>
        const editRoute = "{{ url('student/edit') }}/";
        const updateRoute = "{{ url('student/update') }}/";

        $(function() {
            let addStudentModal = new bootstrap.Modal(document.getElementById('addStudentModal'));
            let editStudentModal = new bootstrap.Modal(document.getElementById('editStudentModal'));

            // Show Add Modal
            $('#btnAddStudent').click(function() {
                $('#addStudentForm')[0].reset();
                $('#addStudentForm').removeClass('was-validated');
                addStudentModal.show();
            });

            // Initialize DataTable
            const table = $('#students-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('student.data') }}',
                dom: 'Bfrtip',
                buttons: ['copy', 'excel', 'pdf', 'print'],
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
                        data: 'mobile',
                        name: 'mobile'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },

                    {
                        data: 'photo',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return data ?
                                `<img src="${data}" width="60" height="60" class="rounded">` :
                                '<span class="text-muted">No Image</span>';
                        }
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },

                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Show Edit Modal & load student data
            $('#students-table').on('click', '.btn-edit', function() {
                const id = $(this).data('id');
                $.get(editRoute + id, function(data) {
                    $('#edit_student_id').val(data.id);
                    $('#edit_center_id').val(data.center_id);
                    $('#edit_user_id').val(data.user_id);
                    $('#edit_gender').val(data.gender);
                    $('#edit_dob').val(data.dob);
                    $('#edit_city').val(data.city);
                    $('#edit_state').val(data.state);
                    $('#edit_country').val(data.country);
                    $('#edit_postal_code').val(data.postal_code);
                    $('#edit_parent_name').val(data.parent_name);
                    $('#edit_parent_contact').val(data.parent_contact_number);
                    $('#edit_alternate_contact').val(data.alternate_contact_number);
                    $('#edit_nationality').val(data.nationality);
                    $('#edit_education_level').val(data.education_level);
                    $('#edit_blood_group').val(data.blood_group);
                    $('#edit_bio').val(data.bio);
                    $('#edit_status').val(data.status);

                    if (data.image) {
                        $('#current_image_preview').html(
                            `<img src="{{ asset('uploads/students') }}/` + data.image +
                            `" width="100" class="rounded mt-1">`)
                    } else {
                        $('#current_image_preview').html(
                            '<span class="text-muted">No Image</span>');
                    }

                    // Reset form validation
                    $('#editStudentForm').removeClass('was-validated');

                    // Set form action dynamically
                    $('#editStudentForm').attr('action', updateRoute + id);

                    editStudentModal.show();
                });

                // Delete confirmation handled elsewhere (if needed)
            });
        });

        $(document).on('click', '.student-delete-btn', function(e) {
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

        $('#students-table').on('click', '.badge', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            window.location.href = url; // Sirf URL call, backend hi toggle aur redirect handle kare
        });
    </script>
@endpush
