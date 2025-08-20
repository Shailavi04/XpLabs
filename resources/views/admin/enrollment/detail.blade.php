@extends('admin.layouts.app')

<style>
    .tab-content .tab-pane {
        border-radius: 0% !important;
    }
</style>

@section('content')
    <div class="container">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Student Enrollment Details</h1>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Students</a></li>
                    <li class="breadcrumb-item active">Enrollment Details</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <!-- Main Info Section -->
            <div class="col-xxl-8">
                <div class="card custom-card">
                    <div class="card-body">

                        <!-- Row 1 -->
                        <div class="d-flex mb-3">
                            <div class="w-50 text-lightest f-14">Name:</div>
                            <div class="w-50 text-muted fw-semibold">{{ $student->name }}</div>
                        </div>

                        <!-- Row 2 -->
                        <div class="d-flex mb-3">
                            <div class="w-50 text-lightest f-14">Enrollment ID:</div>
                            <div class="w-50 text-muted fw-semibold">{{ $enrollment->enrollment_id }}</div>
                        </div>

                        <!-- Row 3 -->
                        <div class="d-flex mb-3">
                            <div class="w-50 text-lightest f-14">Enrollment Date:</div>
                            <div class="w-50 text-muted fw-semibold">
                                {{ optional($enrollment->created_at)->format('d M Y') ?? 'N/A' }}
                            </div>
                        </div>

                        <!-- Row 4 -->
                        <div class="d-flex mb-3">
                            <div class="w-50 text-lightest f-14">Status:</div>
                            <div class="w-50">
                                <span class="badge bg-success rounded-pill px-3 py-1">
                                    {{ ucfirst($enrollment->status ?? 'Active') }}
                                </span>
                            </div>
                        </div>

                        <!-- Row 5 -->
                        <div class="d-flex mb-3">
                            <div class="w-50 text-lightest f-14">Course Enrolled:</div>
                            <div class="w-50 text-dark-grey fw-semibold">{{ $course->name }}</div>
                        </div>

                        <!-- Row 6 -->
                        <div class="d-flex mb-3">
                            <div class="w-50 text-lightest f-14">Total Fee:</div>
                            <div class="w-50 text-success fw-semibold">₹{{ number_format($course->total_fee ?? 0) }}</div>
                        </div>

                        <!-- Row 7 -->
                        <div class="d-flex mb-3">
                            <div class="w-50 text-lightest f-14">Total Paid:</div>
                            <div class="w-50 text-info fw-semibold">₹{{ number_format($payment->amount_paid ?? 0) }}
                            </div>
                        </div>

                        <!-- Row 8 -->
                        <div class="d-flex">
                            <div class="w-50 text-lightest f-14">Remaining Fee:</div>
                            <div class="w-50 text-warning fw-semibold">
                                ₹{{ $payment->amount_due }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Right Column: Student Contact Info -->
            <div class="col-xxl-4">
                <div class="card custom-card">
                    <div class="card-header border-bottom-0 pb-0">
                        <h6 class="card-title fw-semibold mb-1 fs-5">Student Contact Info</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="d-block text-dark fw-semibold fs-6">Email</span>
                            <span class="text-muted">{{ $student->user->email ?? 'N/A' }}</span>
                        </div>

                        <div class="mb-3">
                            <span class="d-block text-dark fw-semibold fs-6">Mobile</span>
                            <span class="text-muted">{{ $student->user->phone_number ?? 'N/A' }}</span>
                        </div>
                    </div>

                </div>
            </div>


            <!-- Tabs Section -->
            <div class="col-xxl-8">
                <div class="card custom-card">
                    <div class="card-header">
                        <ul class="nav nav-tabs tab-style-8 scaleX profile-settings-tab gap-2" id="enrollmentTabs"
                            role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active bg-primary-transparent px-4" id="transactions-tab"
                                    data-bs-toggle="tab" data-bs-target="#transactions-tab-pane" type="button"
                                    role="tab" aria-controls="transactions-tab-pane" aria-selected="true">Transaction
                                    History</button>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body tab-content">
                        <!-- Transaction History Tab -->
                        <div class="tab-pane fade show active" id="transactions-tab-pane" role="tabpanel">
                            <div class="d-flex flex-wrap p-3">

                                <!-- Dynamic Transaction History -->
                                @forelse($transactions as $txn)
                                    <div class="card file-card w-100 rounded-0 border-0 comment p-2 mb-2">
                                        <div class="card-horizontal d-flex align-items-center gap-3">

                                            <!-- Left: User Image -->
                                            <div class="flex-shrink-0">
                                                <img src="{{ asset('/uploads/students/' . $student->image) }}"
                                                    alt="User Image" class="rounded-circle"
                                                    style="width: 50px; height: 50px; object-fit: cover;">

                                            </div>

                                            <!-- Right: Transaction Info -->
                                            <div class="flex-grow-1">
                                                <!-- Student Name and Txn ID -->
                                                <p class="f-14 fw-semibold text-dark mb-1">
                                                    {{ $student->name ?? 'Student' }}
                                                    <span class="text-muted ms-2">Txn ID:
                                                        {{ $txn->transaction_id ?? 'N/A' }}</span>
                                                </p>

                                                <!-- Amount + Payment Method -->
                                                <p class="f-13 fw-semibold text-dark-grey mb-1">
                                                    Payment of ₹{{ number_format($txn->amount, 2) }} received via
                                                    <span
                                                        class="text-primary">{{ $txn->paymentMethod->name ?? 'N/A' }}</span>
                                                </p>

                                                <!-- Date/Time -->
                                                <div class="f-12 text-muted">
                                                    {{ \Carbon\Carbon::parse($txn->created_at)->format('d M Y • h:i A') }}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted">No transactions found.</p>
                                @endforelse


                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
