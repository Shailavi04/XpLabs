@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <style>
            td {
                padding: 6px 7px;
                /* vertical-align: middle; */
            }

            td button {
                display: block;
                /* margin: 0 auto; */
                min-width: 38px;
                line-height: 1.2;
            }

            td>div[id^="label_"] {
                height: 20px;
                /* fixed height for label area */
                line-height: 20px;
                /* vertical center text in label area */
                text-align: center;
                /* center text horizontally */
                font-weight: 700;
                font-size: 14px;
            }
        </style>
        <!-- Page Header -->
        <div class="my-4 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Mark Attendance</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Tables</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Tables</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-3">
                <label for="month" class="mb-0 fw-semibold">Select Month:</label>
                <input type="month" id="month" class="form-control" style="width: 180px" value="{{ date('Y-m') }}">
                <label for="batch" class="mb-0 fw-semibold ms-3">Select Batch:</label>
                <select id="batch" class="form-select ms-1" style="width: 200px;">
                    <option value="">-- Select Batch --</option>
                    @foreach ($batches as $batch)
                        <option value="{{ $batch->id }}" {{ $loop->first ? 'selected' : '' }}>{{ $batch->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card custom-card">
                    <div class="card-body p-3">
                        <h5 class="mb-4">Mark Attendance</h5>

                        <form method="POST" action="{{ route('attendance.store') }}">
                            @csrf
                            <div id="attendance-section" class="mt-3">
                                <div style="overflow-x: auto; max-width: 100%;">
                                    <div style="min-width: 1000px; overflow-y: auto; max-height: 400px;">
                                        <table class="table table-bordered align-middle text-center mb-0"
                                            style="min-width: max-content;">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th scope="col"
                                                        style="min-width: 160px; position: sticky; left: 0; z-index: 10;">
                                                        Student</th>
                                                    @for ($day = 1; $day <= 31; $day++)
                                                        <th scope="col"
                                                            style="padding: 0.25rem 0.4rem; min-width: 38px;">
                                                            {{ $day }}</th>
                                                    @endfor
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($students as $student)
                                                    <tr>
                                                        <td class="text-start"
                                                            style="min-width: 160px; position: sticky; left: 0; z-index: 5;">
                                                            {{ $student->user->name }}</td>
                                                        @for ($day = 1; $day <= 31; $day++)
                                                            @php
                                                                $key = $student->id . '_' . $day;
                                                                $attendanceRecord = $attendances->has($key)
                                                                    ? $attendances[$key]->first()
                                                                    : null;

                                                                if ($attendanceRecord) {
                                                                    $status = $attendanceRecord->status;
                                                                } else {
                                                                    // If no record and date is in the past, mark as Absent (1)
                                                                    $status = \Carbon\Carbon::createFromDate(
                                                                        date('Y'),
                                                                        date('m'),
                                                                        $day,
                                                                    )->lt(\Carbon\Carbon::today())
                                                                        ? 1
                                                                        : null;
                                                                }

                                                                // Updated status labels (as per your mapping)
                                                                $statusLabelMap = [
                                                                    0 => [
                                                                        'label' => 'P',
                                                                        'class' => 'text-success',
                                                                        'icon' => '✔️',
                                                                    ], // Absent
                                                                    1 => [
                                                                        'label' => 'P',
                                                                        'class' => 'text-danger',
                                                                        'icon' => '❌',
                                                                    ], // Present
                                                                    2 => [
                                                                        'label' => 'L',
                                                                        'class' => 'text-warning',
                                                                        'icon' => '⏰',
                                                                    ], // Late
                                                                    3 => [
                                                                        'label' => 'T',
                                                                        'class' => 'text-secondary',
                                                                        'icon' => '📘',
                                                                    ], // Test
                                                                    4 => [
                                                                        'label' => 'E',
                                                                        'class' => 'text-info',
                                                                        'icon' => '📝',
                                                                    ], // Exam
                                                                ];

                                                                $label =
                                                                    $status !== null && isset($statusLabelMap[$status])
                                                                        ? $statusLabelMap[$status]['label']
                                                                        : '';
                                                                $labelClass =
                                                                    $status !== null && isset($statusLabelMap[$status])
                                                                        ? $statusLabelMap[$status]['class']
                                                                        : '';
                                                                $icon =
                                                                    $status !== null && isset($statusLabelMap[$status])
                                                                        ? $statusLabelMap[$status]['icon']
                                                                        : '';

                                                            @endphp

                                                            <td style="padding: 0.15rem 0.3rem;">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-primary px-2 py-1 mark-btn"
                                                                    data-student-id="{{ $student->id }}"
                                                                    data-student-name="{{ $student->name }}"
                                                                    data-day="{{ $day }}" data-bs-toggle="modal"
                                                                    data-bs-target="#markModal">
                                                                    {{ $day }}
                                                                </button>

                                                                <input type="hidden"
                                                                    name="attendance[{{ $student->id }}][{{ $day }}]"
                                                                    id="attendance_{{ $student->id }}_{{ $day }}"
                                                                    value="{{ $status !== null ? $status : '' }}">

                                                                <div id="label_{{ $student->id }}_{{ $day }}"
                                                                    class="mt-1 fw-bold {{ $labelClass }}"
                                                                    style="font-size:9px!important">
                                                                    {{ $icon }}</div>
                                                            </td>
                                                        @endfor
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </form>

                        <!-- Mark Modal -->
                        <div class="modal fade" id="markModal" tabindex="-1" aria-labelledby="markModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <form method="POST" action="{{ route('attendance.store') }}"
                                    class="modal-content border-0 shadow-lg">
                                    @csrf
                                    <input type="hidden" name="student_id" id="modal-student-id">
                                    <input type="hidden" name="date" id="modal-date-field">
                                    <!-- Hidden field for date -->

                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title fw-bold" id="markModalLabel">
                                            <i class="fas fa-user-check me-2"></i>Mark Attendance
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="alert alert-info mb-0">
                                                    <i class="fas fa-user-graduate me-2"></i>
                                                    <span class="fw-bold">Student:</span>
                                                    <span id="modal-student-name" class="text-primary"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="alert alert-info mb-0">
                                                    <i class="far fa-calendar-alt me-2"></i>
                                                    <span class="fw-bold">Date:</span>
                                                    <span id="modal-date-display" class="text-primary"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body p-3">
                                                <h6 class="fw-bold mb-3 text-center">Select Attendance Status</h6>
                                                <div class="d-flex justify-content-between flex-wrap gap-2">
                                                    <label class="btn btn-outline-success flex-fill btn-attendance-status">
                                                        <input type="radio" name="status" value="0"
                                                            class="d-none" checked>
                                                        <i class="fas fa-check-circle me-2"></i>Present
                                                    </label>

                                                    <label class="btn btn-outline-danger flex-fill btn-attendance-status">
                                                        <input type="radio" name="status" value="1"
                                                            class="d-none">
                                                        <i class="fas fa-times-circle me-2"></i>Absent
                                                    </label>

                                                    <label class="btn btn-outline-warning flex-fill btn-attendance-status">
                                                        <input type="radio" name="status" value="2"
                                                            class="d-none">
                                                        <i class="fas fa-procedures me-2"></i>Leave
                                                    </label>

                                                    <label
                                                        class="btn btn-outline-secondary flex-fill btn-attendance-status">
                                                        <input type="radio" name="status" value="3"
                                                            class="d-none">
                                                        <i class="fas fa-clock me-2"></i>Late
                                                    </label>

                                                    <label class="btn btn-outline-info flex-fill btn-attendance-status">
                                                        <input type="radio" name="status" value="4"
                                                            class="d-none">
                                                        <i class="fas fa-check-circle me-2"></i>Excused
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <label for="remarks" class="form-label fw-bold">Remarks (Optional)</label>
                                            <textarea name="remarks" class="form-control" rows="2" placeholder="Enter any remarks about attendance..."></textarea>
                                        </div>
                                    </div>

                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times me-1"></i> Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i> Save Attendance
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function getColorClass(status) {
            return {
                'present': 'text-success',
                'absent': 'text-danger',
                'leave': 'text-warning'
            } [status] || 'text-muted';
        }

        let currentStudentId = null;
        let currentDay = null;
        let currentMonth = null;

        function updateDays() {
            currentMonth = $('#month').val();
            const batchSelected = $('#batch').val();

            if (currentMonth && batchSelected) {
                $('#attendance-section').removeClass('d-none');

                const [year, month] = currentMonth.split('-');
                const lastDay = new Date(year, month, 0).getDate();

                // Hide all days initially
                $('thead th:not(:first-child), tbody td:not(:first-child)').hide();

                // Show only valid days
                for (let d = 1; d <= lastDay; d++) {
                    $(`thead th:nth-child(${d + 1}), tbody td:nth-child(${d + 1})`).show();
                }
            } else {
                $('#attendance-section').addClass('d-none');
            }
        }

        $(document).ready(function() {
            updateDays();

            $('#month, #batch').on('change', updateDays);

            $(document).on('click', '.mark-btn', function() {
                currentStudentId = $(this).data('student-id');
                currentDay = $(this).data('day');
                const studentName = $(this).data('student-name');
                $('#modal-student-id').val(currentStudentId);
                $('#modal-student-name').text(studentName);
                $('#modal-date-display').text(currentMonth + '-' + String(currentDay).padStart(2, '0'));
                $('#modal-date-field').val(currentMonth + '-' + String(currentDay).padStart(2,
                    '0')); // Set the date in the hidden field

                $('input[name="status"]').prop('checked', false); // Reset status

                const existingStatus = $(`#attendance_${currentStudentId}_${currentDay}`).val();
                if (existingStatus) {
                    $(`input[name="status"][value="${existingStatus}"]`).prop('checked', true);
                }
            });

            $('#save-status').on('click', function() {
                const selectedStatus = $('input[name="status"]:checked').val();
                if (!selectedStatus) {
                    alert('Please select attendance status.');
                    return;
                }

                const inputSelector = `#attendance_${currentStudentId}_${currentDay}`;
                const labelSelector = `#label_${currentStudentId}_${currentDay}`;

                $(inputSelector).val(selectedStatus);
                $(labelSelector).text(selectedStatus.charAt(0).toUpperCase());
                $(labelSelector).removeClass().addClass('mt-1 fw-bold ' + getColorClass(selectedStatus));

                $('#markModal').modal('hide');
            });
        });

        $(document).ready(function() {
            $('.btn-attendance-status').click(function() {
                // Sabhi buttons ka background-color reset karo
                $('.btn-attendance-status').css({
                    'background-color': '',
                    'color': ''
                });

                // Selected button ka background-color change karo
                $(this).css({
                    'background-color': '#0d6efd', // blue color
                    'color': '#fff'
                });
            });
        });
    </script>
@endpush
