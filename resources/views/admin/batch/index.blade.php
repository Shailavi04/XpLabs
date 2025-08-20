@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Batch List</h1>
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
                        data-bs-toggle="modal" data-bs-target="#addBatch">
                        <i class="fas fa-plus"></i> Add Batch
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
                            <table id="batch-table" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Course</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
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


    <div class="modal fade" id="addBatch" tabindex="-1" aria-labelledby="addBatchLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form action="{{ route('batch.store') }}" method="POST" enctype="multipart/form-data" id="addBatchForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Add New Batch') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- Batch Name -->
                            <div class="col-md-4">
                                <label for="name" class="form-label">Batch Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name') }}" required>
                            </div>

                            <!-- Course Select -->
                            <div class="col-md-4">
                                <label for="course_id" class="form-label">Course <span class="text-danger">*</span></label>
                                <select name="course_id" id="course_id" class="form-select" required>
                                    <option value="">Select Course</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}"
                                            {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                            {{ $course->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Instructor Select -->
                            <div class="col-md-4">
                                <label for="instructor_id" class="form-label">Instructor</label>
                                <select name="instructor_id" id="instructor_id" class="form-select">
                                    <option value="">Select Instructor (Optional)</option>
                                    @foreach ($instructors as $instructor)
                                        <option value="{{ $instructor->user->id }}"
                                            {{ old('instructor_id') == $instructor->user->id ? 'selected' : '' }}>
                                            {{ $instructor->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Start Date -->
                            <div class="col-md-4">
                                <label for="start_date" class="form-label">Start Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    value="{{ old('start_date') }}" required>
                            </div>

                            <!-- End Date -->
                            <div class="col-md-4">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control"
                                    value="{{ old('end_date') }}">
                            </div>

                            <!-- Schedule (e.g. checkbox multiple days) -->
                            <div class="col-md-12">
                                <label class="form-label">Schedule (Select Days)</label><br>
                                @php

                                    $days = [
                                        'Monday',
                                        'Tuesday',
                                        'Wednesday',
                                        'Thursday',
                                        'Friday',
                                        'Saturday',
                                        'Sunday',
                                    ];
                                    $oldSchedule = old('schedule');

                                    if (is_array($oldSchedule)) {
                                        $selectedDays = $oldSchedule;
                                    } elseif (is_string($oldSchedule)) {
                                        $selectedDays = explode(',', $oldSchedule);
                                    } else {
                                        $selectedDays = [];
                                    }
                                @endphp
                                @endphp
                                @foreach ($days as $day)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="schedule[]"
                                            value="{{ $day }}" id="day_{{ $day }}"
                                            {{ in_array($day, $selectedDays) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="day_{{ $day }}">{{ $day }}</label>
                                    </div>
                                @endforeach
                            </div>


                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Batch</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Batch Modal -->
    <div class="modal fade" id="editBatchModal" tabindex="-1" aria-labelledby="editBatchModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form method="POST" id="editBatchForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editBatchModalLabel">Edit Batch</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_batch_id" name="id">

                        <div class="mb-3">
                            <label for="edit_batch_name" class="form-label">Batch Name</label>
                            <input type="text" class="form-control" name="name" id="edit_batch_name" required>
                        </div>

                        {{-- <div class="mb-3">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="edit_description" rows="4"></textarea>
                        </div> --}}

                        <div class="mb-3">
                            <label for="edit_start_date" class="form-label">Start Date</label>
                            <input type="date" name="start_date" class="form-control" id="edit_start_date" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit_end_date" class="form-label">End Date</label>
                            <input type="date" name="end_date" class="form-control" id="edit_end_date">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Schedule (Select Days)</label><br>
                            @php
                                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                            @endphp
                            @foreach ($days as $day)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input edit_schedule_day" type="checkbox" name="schedule[]"
                                        value="{{ $day }}" id="edit_day_{{ $day }}">
                                    <label class="form-check-label"
                                        for="edit_day_{{ $day }}">{{ $day }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Batch</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
            var table = $('#batch-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('batch.data') }}',
                dom: 'lBfrtip',
                responsive: true,
                buttons: [{
                        extend: 'copy',
                        className: 'ms-2 btn btn-sm btn-info'
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-sm btn-info'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-sm btn-info'
                    },
                    {
                        extend: 'print',
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
                        data: 'course',
                        name: 'course.name'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
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
                    searchPlaceholder: "Search batches...",
                    search: "",
                },
            });

            // Add Bootstrap classes for nicer UI
            $('#batch-table_filter input').addClass('form-control form-control-sm');
            $('#batch-table_length select').addClass('form-select form-select-sm');
            $('.dataTables_wrapper .dataTables_filter').addClass('mb-3');
            $('.dataTables_wrapper .dataTables_length').addClass('mb-3');
        });

        $(document).on('click', '.toggle-status-btn', function() {
            const batchId = $(this).data('id');
            const newStatus = $(this).data('status');
            const actionLabel = $(this).data('label');

            swalConfirmAjax(
                `Are you sure you want to ${actionLabel.toLowerCase()} this batch?`,
                `/batch/${batchId}/toggle-status`, {
                    status: newStatus,
                    _token: '{{ csrf_token() }}'
                },
                function(response) {
                    if (response.success) {
                        Swal.fire('Success', response.message, 'success');
                        $('#batch-table').DataTable().ajax.reload(null, false);
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                }
            );
        });



        $(document).on('click', '.edit-btn', function() {
            var id = $(this).data('id');
            var url = "/batch/edit/" + id;

            $.get(url, function(response) {
                var batch = response.batch;

                // Fill input fields
                $('#edit_batch_id').val(batch.id);
                $('#edit_batch_name').val(batch.name);
                $('#edit_description').val(batch.description || '');
                $('#edit_start_date').val(batch.start_date);
                $('#edit_end_date').val(batch.end_date || '');

                // Uncheck all schedule checkboxes first
                $('.edit_schedule_day').prop('checked', false);

                // Check the days that are in the schedule array
                if (batch.schedule) {
                    // If batch.schedule is a string, split it into an array
                    var scheduleArray = typeof batch.schedule === 'string' ? batch.schedule.split(',') :
                        batch.schedule;

                    scheduleArray.forEach(function(day) {
                        $('#edit_day_' + day.trim()).prop('checked', true);
                    });
                }

                // Set form action dynamically (adjust route as per your routes)
                $('#editBatchForm').attr('action', "/batch/update/" + batch.id);

                // Show the modal (Bootstrap 5)
                var editModal = new bootstrap.Modal(document.getElementById('editBatchModal'));
                editModal.show();
            });
        });

        // Ensure modal backdrop is removed after closing
        $('#editBatchModal').on('hidden.bs.modal', function() {
            $('.modal-backdrop').remove();
        });
    </script>
@endpush
