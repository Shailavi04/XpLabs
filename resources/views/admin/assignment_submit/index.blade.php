@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Assignment Submissions</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">LMS</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Submissions</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="submission-table" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student</th>
                                        <th>Assignment</th>
                                        <th>Comments</th>
                                        <th>Status</th>
                                        <th>File</th>
                                        <th>Submitted At</th>

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
        $(function() {
            var userRole = {{ auth()->user()->role_id }};

            var columns = [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'student'
                },
                {
                    data: 'assignment'
                },
                {
                    data: 'comments'
                },
                {
                    data: 'status'
                },
                {
                    data: 'file',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'submitted_at'
                }
            ];


            var table = $('#submission-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('assignment.submission.data', $assignment->id) }}',
                responsive: true,
                columns: columns,
                order: [
                    [6, 'desc']
                ]
            });
        });
    </script>
@endpush
