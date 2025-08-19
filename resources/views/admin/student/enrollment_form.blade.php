    <div class="container-fluid">

        <!-- Title and Add Enrollment Button -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Enrollment Details for {{ $student->name }}</h5>
            <button id="showEnrollmentFormBtn" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#enrollmentModal">
                Add Enrollment
            </button>
        </div>

        <!-- Enrollment Table -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Course Name</th>
                    <th>Token Amount</th>
                    <th>Status</th>
                    <th>Enrolled At</th>
                    <th>Action</th> <!-- Edit button -->
                </tr>
            </thead>
            <tbody>
                @forelse ($student->enrollments as $enrollment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $enrollment->course->name ?? 'N/A' }}</td>
                        <td>{{ number_format($enrollment->token_amount, 2) }}</td>
                        <td>
                            @switch($enrollment->status)
                                @case(1)
                                    Pending
                                @break

                                @case(2)
                                    Enrolled
                                @break

                                @case(3)
                                    Completed
                                @break

                                @case(4)
                                    Dropped
                                @break

                                @default
                                    Unknown
                            @endswitch
                        </td>
                        <td>{{ $enrollment->created_at->format('d M Y') }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-warning change-status-btn"
                                data-id="{{ $enrollment->id }}" data-current-status="{{ $enrollment->status }}"
                                data-token-amount="{{ $enrollment->token_amount }}"
                                data-course-id="{{ $enrollment->course_id }}" data-bs-toggle="modal"
                                data-bs-target="#changeStatusModal" title="Edit Enrollment">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No enrollments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Modal: Add Enrollment -->
            <div class="modal fade" id="enrollmentModal" tabindex="-1" aria-labelledby="enrollmentModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('enrollment.store') }}">
                            @csrf
                            <input type="hidden" name="student_id" value="{{ $student->id }}">

                            <div class="modal-header">
                                <h5 class="modal-title" id="enrollmentModalLabel">Add Enrollment</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="course_ids_modal" class="form-label">Select Courses</label>
                                    <select name="course_ids[]" id="course_ids_modal" class="form-select" multiple required>
                                        @php
                                            $enrolledCourseIds = $student->enrollments->pluck('course_id')->toArray();
                                        @endphp
                                        @foreach ($courses as $course)
                                            @if (!in_array($course->id, $enrolledCourseIds))
                                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Token input fields generated dynamically by JS -->
                                <div id="tokenAmountFields"></div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Subscribe</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @isset($enrollment)

                <!-- Modal: Edit Enrollment -->
                <div class="modal fade" id="changeStatusModal" tabindex="-1" aria-labelledby="changeStatusModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('enrollment.update', $enrollment->id) }}">
                            @csrf
                            <input type="hidden" name="enrollment_id" id="modalEnrollmentId" value="">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="changeStatusModalLabel">Edit Enrollment Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="edit_course_id" class="form-label">Select Course</label>
                                        <select name="course_id" id="edit_course_id" class="form-select" required>
                                            @foreach ($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="enrollmentStatus" class="form-label">Status</label>
                                        <select class="form-select" name="status" id="enrollmentStatus" required>
                                            <option value="1">Pending</option>
                                            <option value="2">Enrolled</option>
                                            <option value="3">Completed</option>
                                            <option value="4">Dropped</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tokenAmount" class="form-label">Token Amount</label>
                                        <input type="number" step="0.01" min="0" name="token_amount" id="tokenAmount"
                                            class="form-control" required>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Update Enrollment</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        @endisset
        <!-- Include Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        @push('script')
            <!-- jQuery -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <!-- Bootstrap Bundle -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <!-- Select2 JS -->
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

            <script>
                $(document).ready(function() {
                    // Map of course ID => token amount from backend
                    const courseTokenMap = @json($courses->pluck('token_amount', 'id'));

                    // Initialize Select2 on Add Enrollment modal's course select
                    $('#course_ids_modal').select2({
                        placeholder: "Select courses",
                        width: '100%',
                        dropdownParent: $('#enrollmentModal')
                    });

                    $('#course_ids_modal').on('change', function() {
                        const selectedCourses = $(this).val();
                        let tokenFieldsHtml = '';

                        if (selectedCourses && selectedCourses.length > 0) {
                            selectedCourses.forEach(courseId => {
                                const rawToken = courseTokenMap[courseId];
                                const token = (rawToken === null || rawToken === undefined) ? 0 : rawToken;
                                const courseName = $('#course_ids_modal option[value="' + courseId + '"]')
                                    .text();
                                tokenFieldsHtml += `
                    <div class="mb-2">
                        <label class="form-label">Token for ${courseName}</label>
                        <input type="number" name="token_amounts[${courseId}]" class="form-control" value="${token}" min="0" step="0.01" required>
                    </div>
                `;
                            });
                        }

                        $('#tokenAmountFields').html(tokenFieldsHtml);
                    });

                    $('#enrollmentModal').on('shown.bs.modal', function() {
                        $('#course_ids_modal').trigger('change');
                    });

                    // Initialize Select2 on Edit Enrollment modal course select
                    $('#edit_course_id').select2({
                        dropdownParent: $('#changeStatusModal'),
                        width: '100%'
                    });

                    // When course changes in edit modal, update token amount input accordingly
                    $('#edit_course_id').on('change', function() {
                        const selectedCourseId = $(this).val();
                        const token = courseTokenMap[selectedCourseId] ?? 0;
                        $('#tokenAmount').val(token);
                    });

                    // When clicking edit button, populate modal with correct data
                    $('.change-status-btn').on('click', function() {
                        const enrollmentId = $(this).data('id');

                        // AJAX GET Request
                        $.get("{{ url('enrollment/edit') }}/" + enrollmentId, function(response) {
                            const enrollment = response.enrollment;

                            $('#modalEnrollmentId').val(enrollment.id);
                            $('#enrollmentStatus').val(enrollment.status);

                            // Set course dropdown selected
                            $('#edit_course_id').val(enrollment.course_id).trigger('change');

                            // Set token amount manually
                            $('#tokenAmount').val(enrollment.token_amount);

                            // Open modal
                            $('#changeStatusModal').modal('show');
                        });
                    });

                });
            </script>
        @endpush
