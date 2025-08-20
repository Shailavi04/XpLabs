@extends('admin.layouts.app')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h1 class="page-title fw-medium fs-18 mb-2">Enrollment Stages List</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Tables</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Tables</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
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
        </div>
    </div>

    <!-- Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="lifecycleTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student</th>
                                    <th>Course</th>
                                    <th>Token Amount</th>
                                    <th>Start Date</th>
                                    <th>Completion Date</th>
                                    <th>Dropped Date</th>
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
@endsection

@push('script')
<script>
    $(document).ready(function () {
        let csrfToken = '{{ csrf_token() }}';

        let table = $('#lifecycleTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('enrollment.lifecycle.data') }}",
                type: "POST",
                data: {
                    _token: csrfToken
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'student', name: 'student' },
                { data: 'course', name: 'course' },
                { data: 'amount', name: 'amount' },
                { data: 'start_date', name: 'start_date' },
                { data: 'completion_date', name: 'completion_date' },
                { data: 'dropped_date', name: 'dropped_date' },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        let formHtml = '<div class="dropdown">' +
                            `<button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">${data}</button>` +
                            '<ul class="dropdown-menu">';

                        const statusOptions = [
                            { value: 1, text: 'Pending' },
                            { value: 2, text: 'Enrolled' },
                            { value: 3, text: 'Completed' },
                            { value: 4, text: 'Dropped' },
                        ];

                        statusOptions.forEach(option => {
                            let activeClass = (row.status_code == option.value) ? 'active bg-primary text-white' : '';
                            formHtml += `<li>
                                <form method="POST" action="{{ route('enrollment.update_status') }}" style="margin:0;">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="id" value="${row.id}">
                                    <input type="hidden" name="status" value="${option.value}">
                                    <button type="submit" class="dropdown-item ${activeClass}">${option.text}</button>
                                </form>
                            </li>`;
                        });

                        formHtml += '</ul></div>';
                        return formHtml;
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            order: [[4, 'desc']],
        });
    });
</script>
@endpush