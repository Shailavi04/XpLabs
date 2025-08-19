@extends('admin.layouts.app')

@section('content')
    <style>
        #filter_date_range {
            height: calc(2.41rem + 2px);
            /* match .form-select-sm height */
            font-size: .875rem;
            padding: 0.25rem 0.5rem;
        }
    </style>

    <!-- Filters Section -->

    <div class="container">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Student Enrolled List</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Tables</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Tables</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <!-- Filter By Dropdown -->
                <div class="position-relative">
                    <button class="btn btn-primary btn-wave" type="button" id="dropdownMenuClickableInside"
                        data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                        Filter By <i class="ri-arrow-down-s-fill ms-1"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuClickableInside">
                        <li><a class="dropdown-item filter-by" href="#" data-filter="today">Today</a></li>
                        <li><a class="dropdown-item filter-by" href="#" data-filter="yesterday">Yesterday</a></li>
                        <li><a class="dropdown-item filter-by" href="#" data-filter="last_7_days">Last 7 Days</a></li>
                        <li><a class="dropdown-item filter-by" href="#" data-filter="last_30_days">Last 30 Days</a>
                        </li>
                        <li><a class="dropdown-item filter-by" href="#" data-filter="last_6_months">Last 6 Months</a>
                        </li>
                        <li><a class="dropdown-item filter-by" href="#" data-filter="last_year">Last Year</a></li>
                    </ul>
                </div>

                <!-- Student Filter -->
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Student
                    </button>
                    <div class="dropdown-menu p-3" style="min-width: 250px;">
                        <label class="form-label small mb-1">Select Student</label>
                        <select id="filter_student_id" class="form-select form-select-sm">
                            <option value="">All Students</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Course Filter Dropdown -->
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Course
                    </button>
                    <div class="dropdown-menu p-3" style="min-width: 250px;">
                        <label class="form-label small mb-1">Select Course</label>
                        <select id="filter_course_id" class="form-select form-select-sm">
                            <option value="">All Courses</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Date Range Filter Dropdown -->
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Date Range
                    </button>
                    <div class="dropdown-menu p-3" style="min-width: 250px;">
                        <label class="form-label small mb-1">Select Date Range</label>
                        <input type="text" id="filter_date_range" class="form-control form-control-sm" autocomplete="off"
                            placeholder="Select date range" />
                    </div>
                </div>

                <!-- Enroll Student Button -->
                <div class="col-auto">
                    <a href="javascript:void(0);" class="btn btn-primary btn-wave d-flex align-items-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#addEnrollmentModal">
                        <i class="fas fa-plus"></i> Enroll Student
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
                            <table id="enrollments-table" class="display table table-bordered" style="width:100%">
                                <thead class="">
                                    <tr>
                                        <th>#</th>
                                        <th>Student Name</th>
                                        <th>Course Name</th>
                                        <th>Token Amount</th>
                                        <th>Status</th>
                                        <th>Created at</th>
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


    <!-- Add Enrollment Modal -->
    <div class="modal fade" id="addEnrollmentModal" tabindex="-1" aria-labelledby="addEnrollmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form action="{{ route('enrollment.store') }}" method="POST" id="addEnrollmentForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addEnrollmentModalLabel">Add New Enrollment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        {{-- Center Dropdown --}}
                        <div class="mb-3">
                            <label for="center_id" class="form-label">Select Center <span
                                    class="text-danger">*</span></label>

                            @if (auth()->user()->role_id == 1)
                                {{-- Admin: can select any center --}}
                                <select name="center_id" id="center_id" class="form-select" required>
                                    <option value="">-- Select Center --</option>
                                    @foreach ($centers as $center)
                                        <option value="{{ $center->id }}">{{ $center->name }}</option>
                                    @endforeach
                                </select>
                            @else
                                {{-- Non-admin: show only their assigned centers, select first by default --}}
                                <select name="center_id" id="center_id" class="form-select" required>
                                    @foreach (auth()->user()->centers as $key => $userCenter)
                                        <option value="{{ $userCenter->id }}" {{ $key === 0 ? 'selected' : '' }}>
                                            {{ $userCenter->name }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        {{-- Courses Dropdown (based on center) --}}
                        <div class="mb-3">
                            <label for="course_ids" class="form-label">Select Courses <span
                                    class="text-danger">*</span></label>
                            <select name="course_ids[]" id="course_ids" class="form-select" multiple required>
                                @foreach ($courses as $course)
                                    @if (auth()->user()->role_id == 1)
                                        <option value="{{ $course->id }}" data-token="{{ $course->token_amount }}">
                                            {{ $course->name }} ({{ $course->duration ?? '' }})</option>
                                    @else
                                        @if (auth()->user()->centers->pluck('id')->contains($course->center_id))
                                            <option value="{{ $course->id }}"
                                                data-token="{{ $course->token_amount }}">{{ $course->name }}
                                                ({{ $course->duration ?? '' }})
                                            </option>
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        {{-- Student Dropdown --}}
                        <div class="mb-3">
                            <label for="student_id" class="form-label">Select Student <span
                                    class="text-danger">*</span></label>
                            <select name="student_id" id="student_id" class="form-select" required>
                                <option value="">-- Select Student --</option>
                                @foreach ($students as $student)
                                    @if (auth()->user()->role_id == 1 || auth()->user()->centers->pluck('id')->contains($student->center_id))
                                        <option value="{{ $student->id }}">{{ $student->user->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        {{-- Token Amount Inputs Generated Here --}}
                        <div id="tokenAmountFields"></div>
                    </div>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Enrollment</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Enrollment Modal -->
    <!-- Edit Enrollment Modal -->
    <div class="modal fade" id="editEnrollmentModal" tabindex="-1" aria-labelledby="editEnrollmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form method="POST" id="editEnrollmentForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editEnrollmentModalLabel">Edit Enrollment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        {{-- Center Dropdown --}}
                        <div class="mb-3">
                            <label for="edit_center_id" class="form-label">Select Center <span
                                    class="text-danger">*</span></label>
                            <select name="center_id" id="edit_center_id" class="form-select" required>
                                <option value="">-- Select Center --</option>
                                @if (auth()->user()->role_id == 1)
                                    @foreach ($centers as $center)
                                        <option value="{{ $center->id }}">{{ $center->name }}</option>
                                    @endforeach
                                @else
                                    @foreach (auth()->user()->centers as $userCenter)
                                        <option value="{{ $userCenter->id }}">{{ $userCenter->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        {{-- Courses Dropdown --}}
                        <div class="mb-3">
                            <label for="edit_course_ids" class="form-label">Select Courses <span
                                    class="text-danger">*</span></label>
                            <select name="course_ids[]" id="edit_course_ids" class="form-select" multiple
                                required></select>
                        </div>

                        <div class="mb-3">
                            <label for="edit_student_id" class="form-label">Select Student <span
                                    class="text-danger">*</span></label>
                            <select name="student_id" id="edit_student_id" class="form-select" required>
                                <option value="">-- Select Student --</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->user->name ?? 'N/A' }}</option>
                                @endforeach
                            </select>
                        </div>


                        {{-- Token Amounts --}}
                        <div id="editTokenAmountFields" class="readonly"></div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Enrollment</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>




    <script>
        // Pass all existing enrollments grouped by student ID to JS
        const enrollmentsByStudent = @json($enrollmentsByStudent);
        const coursesData = @json($courses->mapWithKeys(fn($c) => [$c->id => $c->token_amount]));
    </script>
@endsection

@push('script')
    <!-- Include CSS for Select2 and daterangepicker -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- Include JS: jQuery, Select2, daterangepicker, moment.js, DataTables -->
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            const coursesData = @json($courses->mapWithKeys(fn($c) => [$c->id => $c->token_amount]));

            $('#course_ids').select2({
                placeholder: "Select courses",
                width: '100%',
                dropdownParent: $('#addEnrollmentModal')
            });

            $('#course_ids').on('change', function() {
                const selectedCourseIds = $(this).val() || [];
                let html = '';

                selectedCourseIds.forEach(courseId => {
                    const tokenAmount = coursesData[courseId] ?? 0;
                    const courseName = $(this).find(`option[value="${courseId}"]`).text();

                    html += `
<div class="mb-3">
    <label class="form-label">Token Amount for ${courseName}</label>
    <input type="number" step="0.01" min="0" class="form-control" 
        name="token_amounts[${courseId}]" value="${tokenAmount}" required readonly>
</div>`;

                });

                $('#tokenAmountFields').html(html);
            });

            $('#edit_student_id, #edit_course_ids').select2({
                placeholder: "Select an option",
                width: '100%',
                dropdownParent: $('#editEnrollmentModal')
            });

            $('#edit_course_ids').on('change', function() {
                const selectedCourseIds = $(this).val() || [];
                let html = '';

                selectedCourseIds.forEach(courseId => {
                    const tokenAmount = coursesData[courseId] ?? 0;
                    const courseName = $(this).find(`option[value="${courseId}"]`).text();
                    html += `
<div class="mb-3">
    <label class="form-label">Token Amount for ${courseName}</label>
    <input type="number" step="0.01" min="0" class="form-control" 
        name="token_amounts[${courseId}]" value="${tokenAmount}" required readonly>
</div>`;

                });

                $('#editTokenAmountFields').html(html);
            });

            // Initialize filters Select2
            $('#filter_student_id, #filter_course_id').select2({
                placeholder: "Select an option",
                allowClear: true,
                width: '100%'
            });

            // Initialize daterangepicker on filter input
            $('#filter_date_range').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear',
                    format: 'YYYY-MM-DD'
                }
            });

            $('#filter_date_range').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format(
                    'YYYY-MM-DD'));
                enrollmentsTable.draw();
            });

            $('#filter_date_range').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                enrollmentsTable.draw();
            });

            $('#student_id').on('change', function() {
                const studentId = $(this).val();
                const enrolledCourses = enrollmentsByStudent[studentId] || [];

                // Build new options excluding enrolled courses
                let optionsHtml = '';
                @foreach ($courses as $course)
                    if (!enrolledCourses.includes({{ $course->id }})) {
                        optionsHtml += `<option value="{{ $course->id }}" data-token="{{ $course->token_amount }}">
                {{ $course->name }} ({{ $course->duration ?? '' }})
            </option>`;
                    }
                @endforeach

                $('#course_ids').select2('destroy');

                $('#course_ids').html(optionsHtml);

                $('#course_ids').select2({
                    placeholder: "Select courses",
                    width: '100%',
                    dropdownParent: $('#addEnrollmentModal')
                });

                // Clear any previous selection
                $('#course_ids').val(null).trigger('change');

                // Clear token amount fields
                $('#tokenAmountFields').html('');
            });


            // Initialize DataTable
            var enrollmentsTable = $('#enrollments-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('enrollment.data') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";

                        d.student_id = $('#filter_student_id').val();
                        d.course_id = $('#filter_course_id').val();
                        d.date_range = $('#filter_date_range').val();
                    }
                },
                dom: 'Bfrtip',
                buttons: ['copy', 'excel', 'pdf', 'print'],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'student_name',
                        name: 'student.name'
                    },
                    {
                        data: 'course_code',
                        name: 'course.code'
                    },
                    {
                        data: 'token_amount',
                        name: 'token_amount'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [1, 'desc']
                ],
                pageLength: 10,
            });

            // Redraw table on filter change
            $('#filter_student_id, #filter_course_id').on('change', function() {
                enrollmentsTable.draw();
            });


            $(document).ready(function() {
                const coursesData = @json($courses->mapWithKeys(fn($c) => [$c->id => $c->token_amount]));

                // Initialize Select2
                $('#edit_center_id, #edit_course_ids, #edit_student_id').select2({
                    width: '100%',
                    dropdownParent: $('#editEnrollmentModal')
                });

                // When editing enrollment
                $(document).on('click', '.editEnrollmentBtn', function() {
                    const id = $(this).data('id');
                    $('#editEnrollmentModal').modal('show');
                    $('#editEnrollmentForm')[0].reset();
                    $('#editTokenAmountFields').html('');

                    $.ajax({
                        url: `/enrollment/edit/${id}`,
                        method: 'GET',
                        success: function(res) {
                            const enrollment = res.enrollment;
                            $('#editEnrollmentForm').attr('action',
                                `/enrollment/updates/${id}`);

                            // --- CENTER ---
                            $('#edit_center_id').val(enrollment.center_id).trigger(
                                'change');

                            // Load courses for selected center
                            $.get("{{ route('enrollment.center.by.course') }}", {
                                center_id: enrollment.center_id
                            }, function(courseRes) {
                                $('#edit_course_ids').html('');
                                courseRes.courses.forEach(course => {
                                    $('#edit_course_ids').append(
                                        `<option value="${course.id}" data-token="${course.token_amount}">${course.name} (${course.duration || ''})</option>`
                                    );
                                });

                                // Select the enrolled course
                                $('#edit_course_ids').val([enrollment
                                    .course_id
                                ]).trigger('change');

                                // Token Amount field
                                const tokenAmount = enrollment.token_amount;
                                const courseName = $(
                                        '#edit_course_ids option:selected')
                                    .text();
                                $('#editTokenAmountFields').html(`
                        <div class="mb-3">
                            <label class="form-label">Token Amount for ${courseName}</label>
                            <input type="number" step="0.01" min="0" class="form-control" 
                                name="token_amounts[${enrollment.course_id}]" value="${tokenAmount}" required readonly>
                        </div>
                    `);
                            });

                            // --- STUDENT ---
                            $('#edit_student_id').val(enrollment.student_id).trigger(
                                'change');
                        },
                        error: function() {
                            alert('Failed to load enrollment data.');
                            $('#editEnrollmentModal').modal('hide');
                        }
                    });
                });

                // When center changes in modal, update courses dynamically
                $('#edit_center_id').on('change', function() {
                    const centerId = $(this).val();
                    $('#edit_course_ids').html('<option>Loading...</option>');
                    $('#editTokenAmountFields').html('');

                    if (centerId) {
                        $.get("{{ route('enrollment.center.by.course') }}", {
                            center_id: centerId
                        }, function(res) {
                            $('#edit_course_ids').html('');
                            res.courses.forEach(course => {
                                $('#edit_course_ids').append(
                                    `<option value="${course.id}" data-token="${course.token_amount}">${course.name} (${course.duration || ''})</option>`
                                );
                            });
                            $('#edit_course_ids').val(null).trigger('change');
                        });
                    } else {
                        $('#edit_course_ids').html(
                            '<option value="">-- Select Courses --</option>');
                    }
                });

                // When course changes, update token field
                $('#edit_course_ids').on('change', function() {
                    const selectedCourseIds = $(this).val() || [];
                    let html = '';
                    selectedCourseIds.forEach(courseId => {
                        const tokenAmount = coursesData[courseId] ?? 0;
                        const courseName = $(this).find(`option[value="${courseId}"]`)
                            .text();
                        html += `<div class="mb-3">
                        <label class="form-label">Token Amount for ${courseName}</label>
                        <input type="number" step="0.01" min="0" class="form-control" 
                            name="token_amounts[${courseId}]" value="${tokenAmount}" required readonly>
                    </div>`;
                    });
                    $('#editTokenAmountFields').html(html);
                });
            });



        });



        $(document).on('click', '.sweet-delete-btn', function(e) {
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

        $('#center_id').on('change', function() {
            var centerId = $(this).val();
            $('#course_ids').html('<option>Loading...</option>');

            if (centerId) {
                $.get("{{ route('enrollment.center.by.course') }}", {
                    center_id: centerId
                }, function(res) {
                    $('#course_ids').empty().append('<option value="">-- Select Courses --</option>');

                    if (res.courses.length > 0) {
                        $.each(res.courses, function(i, course) {
                            $('#course_ids').append('<option value="' + course.id +
                                '" data-token="' + course.token_amount + '">' + course.name +
                                ' (' + (course.duration || '') + ')</option>');
                        });
                    } else {
                        $('#course_ids').append('<option value="">No courses available</option>');
                    }

                    // Clear token fields
                    $('#tokenAmountFields').html('');
                });
            } else {
                $('#course_ids').html('<option value="">-- Select Courses --</option>');
                $('#tokenAmountFields').html('');
            }
        });
    </script>
@endpush
