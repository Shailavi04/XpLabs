@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Payment List</h1>
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
                        data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                        <i class="fas fa-plus"></i> Add Payment
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
                            <table id="payment-table" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Enrollment ID</th>
                                        <th>Student Name</th>
                                        <th>Course Name</th>
                                        <th>Total Fee</th>
                                        <th>Amount Paid</th>
                                        <th>Transaction ID</th>
                                        <th>Payment Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Payment Modal -->
    <div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="add-payment-form" method="POST" action="{{ route('payment.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="enrollment_id" class="form-label">Enrollment ID</label>
                            <input type="text" name="enrollment_id" id="enrollment_id" class="form-control" required>
                        </div>

                        <!-- Hidden section: student + course + fee -->
                        <div id="enrollment-details" class="d-none">
                            <div class="mb-3">
                                <label>Student Name</label>
                                <input type="text" class="form-control" id="student_name_display" disabled>
                                <input type="hidden" name="student_name" id="student_name">
                            </div>

                            <div class="mb-3">
                                <label>Course</label>
                                <input type="text" class="form-control" id="course_name_display" disabled>
                                <input type="hidden" name="course_name" id="course_name">
                            </div>

                            <div class="mb-3">
                                <label>Total Fee</label>
                                <input type="text" class="form-control" id="total_fee_display" disabled>
                                <input type="hidden" name="total_fee" id="total_fee">
                            </div>
                            <div class="mb-3">
                                <label>Total Paid</label>
                                <input type="text" class="form-control" id="amount_due_display" disabled>
                                <input type="hidden" name="amount_due" id="amount_due">
                            </div>

                            <div class="mb-3">
                                <label>Amount to Pay</label>
                                <input type="number" name="amount" class="form-control" required min="1">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Make Payment</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            var table = $('#payment-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                scrollX: true,
                ajax: '{{ route('payment.data') }}', // Use correct route here
                dom: 'lBfrtip',
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
                        data: 'enrollment_id',
                        name: 'enrollment_id'
                    },
                    {
                        data: 'student_name',
                        name: 'student_name'
                    },
                    {
                        data: 'course_name',
                        name: 'course_name'
                    },
                    {
                        data: 'total_fee',
                        name: 'total_fee'
                    },
                    {
                        data: 'amount_paid',
                        name: 'amount_paid'
                    },
                    {
                        data: 'transaction_id',
                        name: 'transaction_id'
                    },
                    {
                        data: 'payment_date',
                        name: 'payment_date'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },

                ],
                language: {
                    searchPlaceholder: "Search payments...",
                    search: "",
                },
            });

            // Add Bootstrap classes to search input and length select for styling
            $('#payment-table_filter input').addClass('form-control form-control-sm');
            $('#payment-table_length select').addClass('form-select form-select-sm');

            // Add spacing for controls
            $('.dataTables_wrapper .dataTables_filter').addClass('mb-3');
            $('.dataTables_wrapper .dataTables_length').addClass('mb-3');

            // Edit button click event (using delegated event)
            $('#payment-table').on('click', '.btn-edit', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                // Ajax to get payment data by id (adjust URL accordingly)
                $.ajax({
                    url: '{{ url('payment/edit') }}/' + id,
                    method: 'GET',
                    success: function(response) {
                        // Populate modal fields here
                        // Example:
                        // $('#edit-payment-id').val(response.id);
                        // $('#edit-amount-paid').val(response.amount_paid);
                        // Show modal
                        $('#editPaymentModal').modal('show');
                    },
                    error: function(xhr) {
                        alert('Failed to fetch data.');
                    }
                });
            });

            // Delete confirmation
            $(document).on('click', '.payment-delete-btn', function(e) {
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

            // When Enrollment ID changes, fetch details
            $('#enrollment_id').on('change', function() {
                let id = $(this).val().trim();
                if (!id) {
                    $('#enrollment-details').addClass('d-none');
                    return;
                }

                $.ajax({
                    url: '{{ route('payment.fetchEnrollment') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        enrollment_id: id
                    },
                    success: function(res) {
                        if (res.success) {
                            $('#student_name_display').val(res.data.student_name);
                            $('#student_name').val(res.data.student_name);

                            $('#course_name_display').val(res.data.course_name);
                            $('#course_name').val(res.data.course_name);

                            $('#amount_due_display').val(res.data.amount_paid);
                            $('#total_fee_display').val(res.data.total_fee);
                            $('#total_fee').val(res.data.total_fee);
                            $('#amount_due').val(res.data.amount_paid);

                            $('#enrollment-details').removeClass('d-none');
                        } else {
                            alert(res.message);
                            $('#enrollment-details').addClass('d-none');
                        }
                    },
                    error: function() {
                        alert('Error fetching enrollment.');
                        $('#enrollment-details').addClass('d-none');
                    }
                });
            });




        });
    </script>
@endpush
