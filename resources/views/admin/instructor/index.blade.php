@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Instructor List</h1>
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
                    <a href="javascript:void(0);" class="btn btn-primary btn-wave d-flex align-items-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#addInstructorModal">
                        <i class="fas fa-plus"></i> Add Instructor
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="instructor-table" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Joining Date</th>
                                        <th>Status</th>
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

    <!-- Add Instructor Modal -->
    <div class="modal fade" id="addInstructorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form action="{{ route('student_instructors.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Instructor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">

                            <div class="col-md-4">
                                <label class="form-label">Select Center <span class="text-danger">*</span></label>
                                <select name="center_id" class="form-select" required>
                                    <option value="">-- Select Center --</option>
                                    @foreach ($centers as $center)
                                        <option value="{{ $center->id }}">{{ $center->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Select User <span class="text-danger">*</span></label>
                                <select name="instructor_id" class="form-select" required>
                                    <option value="">-- Select User --</option>
                                    @foreach ($user_teacher as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Qualification <span class="text-danger">*</span></label>
                                <select name="qualification" id="add-qualification" class="form-select" required>
                                    
                                    <option value="">-- Select Qualification --</option>
                                    <option value="1"
                                        {{ old('qualification', $instructor->qualification ?? '') == 1 ? 'selected' : '' }}>
                                        High School</option>
                                    <option value="2"
                                        {{ old('qualification', $instructor->qualification ?? '') == 2 ? 'selected' : '' }}>
                                        Diploma</option>
                                    <option value="3"
                                        {{ old('qualification', $instructor->qualification ?? '') == 3 ? 'selected' : '' }}>
                                        Bachelor's Degree</option>
                                    <option value="4"
                                        {{ old('qualification', $instructor->qualification ?? '') == 4 ? 'selected' : '' }}>
                                        Master's Degree</option>
                                    <option value="5"
                                        {{ old('qualification', $instructor->qualification ?? '') == 5 ? 'selected' : '' }}>
                                        PhD</option>
                                    <option value="6"
                                        {{ old('qualification', $instructor->qualification ?? '') == 6 ? 'selected' : '' }}>
                                        Other</option>
                                </select>
                            </div>


                            <div class="col-md-4">
                                <label class="form-label">Designation</label>
                                <input type="text" name="designation" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Experience (in years)</label>
                                <input type="number" name="experience_years" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Joining Date <span class="text-danger">*</span></label>
                                <input type="date" name="joining_date" class="form-control" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Bio</label>
                                <textarea name="bio" class="form-control" rows="3"></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Profile Image</label>
                                <input type="file" name="profile_image" class="form-control" accept="image/*">
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Instructor</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="editInstructorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form method="POST" enctype="multipart/form-data" id="editInstructorForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Instructor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit-instructor-id">
                        <div class="row g-3">

                            <div class="col-md-4">
                                <label class="form-label">Select Center <span class="text-danger">*</span></label>
                                <select name="center_id" id="edit-center_id" class="form-select" required>
                                    <option value="">-- Select Center --</option>
                                    @foreach ($centers as $center)
                                        <option value="{{ $center->id }}">{{ $center->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Select Instructor <span class="text-danger">*</span></label>
                                <select name="instructor_id" id="edit-instructor_id" class="form-select" required>
                                    <option value="">-- Select Instructor --</option>
                                    @foreach ($user_teacher as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Qualification <span class="text-danger">*</span></label>
                                <select name="qualification" id="edit-qualification" class="form-select" required>
                                    <option value="">-- Select Qualification --</option>
                                    <option value="1">High School</option>
                                    <option value="2">Diploma</option>
                                    <option value="3">Bachelor's Degree</option>
                                    <option value="4">Master's Degree</option>
                                    <option value="5">PhD</option>
                                    <option value="6">Other</option>
                                </select>
                            </div>



                            <div class="col-md-4">
                                <label class="form-label">Designation</label>
                                <input type="text" name="designation" id="edit-designation" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Experience (years)</label>
                                <input type="number" name="experience_years" id="edit-experience_years"
                                    class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Joining Date</label>
                                <input type="date" name="joining_date" id="edit-joining_date" class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Bio</label>
                                <textarea name="bio" id="edit-bio" class="form-control" rows="3"></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Profile Image</label>
                                <input type="file" name="profile_image" class="form-control" accept="image/*">
                                <div id="current-edit-image" class="mt-2"></div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Instructor</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            $('#instructor-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('student_instructors.instructor_data') }}',
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
                        data: 'joining_date',
                        name: 'joining_date'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                language: {
                    searchPlaceholder: "Search instructors...",
                    search: "",
                },
            });

            $(document).on('click', '.edit-instructor-btn', function() {
                let id = $(this).data('id');

                $.get("{{ url('student_instructors/edit') }}/" + id, function(response) {
                    if (response.instructor) {
                        const inst = response.instructor;
                        const user = response.user;

                        $('#edit-instructor-id').val(inst.id);

                        // Fill select dropdowns
                        $('#edit-center_id').val(inst.center_id);
                        $('#edit-instructor_id').val(user.id);
                        $('#edit-qualification').val(inst.qualification.toString());

                        // Fill inputs
                        $('#edit-designation').val(inst.designation ?? '');
                        $('#edit-experience_years').val(inst.experience_years ?? '');

                        // Joining date format: YYYY-MM-DD
                        if (inst.joining_date) {
                            $('#edit-joining_date').val(inst.joining_date);
                        } else {
                            $('#edit-joining_date').val('');
                        }

                        $('#edit-bio').val(inst.bio ?? '');

                        // If phone_number is in user model
                        $('#edit-phone_number').val(user.phone_number ?? '');

                        // Profile image
                        if (inst.profile_image) {
                            let imagePath = "{{ asset('uploads/instructor') }}/" + inst
                                .profile_image;
                            $('#current-edit-image').html('<img src="' + imagePath +
                                '" width="80" class="rounded">');
                        } else {
                            $('#current-edit-image').html('No image uploaded');
                        }

                        $('#editInstructorForm').attr('action',
                            "{{ url('student_instructors/update') }}/" + id);

                        if ($('#editInstructorForm input[name="_method"]').length === 0) {
                            $('#editInstructorForm').prepend(
                                '<input type="hidden" name="_method" value="POST">');
                        }

                        $('#editInstructorModal').modal('show');
                    }
                });
            });


        });
    </script>
@endpush
