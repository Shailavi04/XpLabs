<div class="card shadow-sm rounded-4 p-4 h-100">

    <h5 class="fw-bold mb-4">Enrollments Pending Payment</h5>

    @if ($student->enrollments->count() > 0)
        <table class="table table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Course</th>
                    <th>Status</th>
                    <th>Token Amount</th>
                    <th>Payment Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($student->enrollments as $index => $enrollment)
                    @php
                        $transaction = $student->transactions->firstWhere('enrollment_id', $enrollment->id);
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $enrollment->course->name ?? 'N/A' }}</td>
                        <td>
                            @php
                                $statusLabels = [
                                    0 => 'Pending',
                                    2 => 'Enrolled',
                                    3 => 'Completed',
                                    4 => 'Cancelled',
                                ];
                            @endphp
                            <span class="badge bg-info">{{ $statusLabels[$enrollment->status] ?? 'Unknown' }}</span>
                        </td>
                        <td>₹{{ number_format($enrollment->token_amount, 2) }}</td>
                        <td>
                            @if ($transaction && $transaction->status == 1)
                                <span class="badge bg-success">Paid</span>
                            @elseif ($transaction && $transaction->status == 0)
                                <span class="badge bg-warning text-dark">Pending</span>
                            @else
                                <span class="badge bg-secondary">Not Paid</span>
                            @endif
                        </td>

                        <td>
                            @if ($transaction && $transaction->status == 1)
                                <button class="btn btn-sm btn-secondary" disabled>Paid</button>
                            @else
                                <button class="btn btn-sm btn-primary payNowBtn"
                                    data-enrollment-id="{{ $enrollment->id }}">Pay Now</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No enrollments found.</p>
    @endif

    <!-- Pay Now Modal -->
    <div class="modal fade" id="payNowModal" tabindex="-1" aria-labelledby="payNowModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('transaction.store') }}" id="payNowForm">
                @csrf
                <input type="text" name="enrollment_id" id="modalEnrollmentIds" class="form-control" readonly>

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="payNowModalLabel">Make Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Course</label>
                            <input type="text" id="modalCourseName" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Student</label>
                            <input type="text" id="modalStudentName" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="form-select" required>
                                <option value="">Select Payment Method</option>
                                <option value="credit_card">Razor pay</option>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="transaction_reference" class="form-label">Transaction Reference / Notes</label>
                            <input type="text" name="transaction_reference" id="transaction_reference"
                                class="form-control" placeholder="Optional">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Pay Now</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>


@push('script')
    <script>
        $(document).ready(function() {
            $('.payNowBtn').on('click', function() {
                let enrollmentId = $(this).data('enrollment-id');
                console.log(enrollmentId);

                // Clear previous values
                $('#modalEnrollmentIds').val(enrollmentId);
                $('#payment_method').val('');
                $('#transaction_reference').val('');
                $('#modalCourseName').val('');
                $('#modalStudentName').val('');

                $.ajax({
                    url: `/transaction/${enrollmentId}`,
                    method: 'GET',
                    success: function(response) {
                        if (response.enrollment) {
                            $('#modalCourseName').val(response.enrollment.course.name || '');
                            $('#modalStudentName').val(response.enrollment.student.name || '');
                        }
                        if (response.transaction) {
                            $('#payment_method').val(response.transaction.payment_mode || '');
                            $('#transaction_reference').val(response.transaction
                                .transaction_reference || '');
                        }
                        var payNowModal = new bootstrap.Modal(document.getElementById(
                            'payNowModal'));
                        payNowModal.show();
                    },
                    error: function() {
                        alert('Failed to load payment details.');
                        var payNowModal = new bootstrap.Modal(document.getElementById(
                            'payNowModal'));
                        payNowModal.show();
                    }
                });
            });
        });
    </script>
@endpush
