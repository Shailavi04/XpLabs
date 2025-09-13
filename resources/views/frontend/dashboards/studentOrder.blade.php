@extends('frontend.web_layout.master')

@section('content')

<!-- Breadcrumb -->
<div class="breadcrumb-bar text-center" style="padding: 100px 0; margin-top: 80px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title mb-2">Order History</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('frontend.layout.index') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Order History</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->

<div class="content">
    <div class="container">
        <!-- profile box -->
        @include('frontend.dashboards.profileBox')

        <!-- profile box -->
        <div class="row">
            <!-- sidebar -->

            @include('frontend.dashboards.sidebar')
            <!-- sidebar -->
            <div class="col-lg-9">
                <div class="page-title d-flex align-items-center justify-content-between">
                    <h5>Order History</h5>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="dropdown mb-3">
                            <a href="javascript:void(0);" class="dropdown-toggle btn rounded border d-inline-flex align-items-center" id="statusDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Status
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end p-3" aria-labelledby="statusDropdown">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1 filter-status" data-status="">All</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1 filter-status" data-status="paid">Completed</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1 filter-status" data-status="created">Pending</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <i class="isax isax-search-normal-14"></i>
                            </span>
                            <input type="email" class="form-control form-control-md" placeholder="Search">
                        </div>
                    </div>
                </div>
                <div class="table-responsive custom-table">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="payments-table-body">@forelse($payments as $payment)
                            <tr>
                                <td>
                                    <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#view_invoice">
                                        {{ $payment->order_id }}
                                    </a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y') }}</td>
                                <td>${{ number_format($payment->token_amount / 100, 2) }}</td>
                                <td>
                                    @if($payment->status == 'paid')
                                    <span class="badge bg-success d-inline-flex align-items-center me-1">
                                        <i class="fa-solid fa-circle fs-5 me-1"></i>Completed
                                    </span>
                                    @elseif($payment->status == 'created')
                                    <span class="badge bg-info d-inline-flex align-items-center me-1">
                                        <i class="fa-solid fa-circle fs-5 me-1"></i>Pending
                                    </span>
                                    @else
                                    <span class="badge bg-warning d-inline-flex align-items-center me-1">
                                        <i class="fa-solid fa-circle fs-5 me-1"></i>{{ ucfirst($payment->status) }}
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                     
                                        @if(!empty($payment->payment_id))
                                        <a href="{{ route('payments.receipt', ['payment_id' => $payment->payment_id]) }}" target="_blank" class="d-inline-flex fs-14 action-icon">
                                            <i class="isax isax-document-download"></i>
                                        </a>
                                        @else
                                        <span class="text-muted small ms-2">No receipt</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No orders found.</td>
                            </tr>
                            @endforelse

                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Define base URL for receipt download -->
<script>
    const receiptBaseUrl = "{{ url('payments/receipt') }}";
</script>

<script>
    $(document).ready(function() {
        $('.filter-status').click(function(e) {
            e.preventDefault();

            let status = $(this).data('status');

            $.ajax({
                url: "{{ route('student.orders.ajax') }}",
                type: "GET",
                data: {
                    status: status
                },
                success: function(response) {
                    let tbody = $('#payments-table-body');
                    tbody.empty();

                    if (response.payments.length === 0) {
                        tbody.append('<tr><td colspan="5" class="text-center">No orders found.</td></tr>');
                        return;
                    }

                    response.payments.forEach(function(payment) {
                        // Status Badge
                        let statusBadge = '';
                        if (payment.status === 'paid') {
                            statusBadge = '<span class="badge bg-success d-inline-flex align-items-center me-1"><i class="fa-solid fa-circle fs-5 me-1"></i>Completed</span>';
                        } else if (payment.status === 'created') {
                            statusBadge = '<span class="badge bg-info d-inline-flex align-items-center me-1"><i class="fa-solid fa-circle fs-5 me-1"></i>Pending</span>';
                        } else {
                            statusBadge = '<span class="badge bg-warning d-inline-flex align-items-center me-1"><i class="fa-solid fa-circle fs-5 me-1"></i>' + payment.status.charAt(0).toUpperCase() + payment.status.slice(1) + '</span>';
                        }

                        // Download link for receipt
                        let downloadLink = '';
                        if (payment.payment_id) {
                            downloadLink = `
                            <a href="${receiptBaseUrl}/${payment.payment_id}" target="_blank" class="d-inline-flex fs-14 action-icon">
                                <i class="isax isax-document-download"></i>
                            </a>`;
                        } else {
                            downloadLink = `<span class="text-muted small ms-2">No receipt</span>`;
                        }

                        // Table row
                        let row = `
                        <tr>
                            <td><a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#view_invoice">${payment.order_id}</a></td>
                            <td>${new Date(payment.created_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })}</td>
                            <td>$${(payment.token_amount / 100).toFixed(2)}</td>
                            <td>${statusBadge}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="#" class="d-inline-flex fs-14 me-1 action-icon" data-bs-toggle="modal" data-bs-target="#view_invoice">
                                        <i class="isax isax-eye"></i>
                                    </a>
                                    ${downloadLink}
                                </div>
                            </td>
                        </tr>
                        `;
                        tbody.append(row);
                    });
                },
                error: function() {
                    alert('Something went wrong.');
                }
            });
        });
    });
</script>
@endpush