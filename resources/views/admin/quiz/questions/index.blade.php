@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Question List</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Tables</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Tables</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('quiz.questions.create') }}" class="btn btn-success">+ Add Questions</a>
            </div>
        </div>

        <div class="card custom-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="questionTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Question</th>
                                <th>Type</th>
                                <th>Options</th>
                                <th>Correct Answer</th>
                                <th>Explanation</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            let table = $('#questionTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('quiz.questions.data') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'question',
                        name: 'question'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'options',
                        name: 'options',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'correct',
                        name: 'correct',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'explanation',
                        name: 'explanation'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [1, 'asc']
                ],
                drawCallback: function() {
                    // Attach delete confirmation handler
                    $('.sweet-delete-btn').off('click').on('click', function(e) {
                        e.preventDefault();
                        if (confirm('Are you sure you want to delete this question?')) {
                            $(this).closest('form').submit();
                        }
                    });

                    // Edit button handler example
                    $('.editQuestionBtn').off('click').on('click', function() {
                        let id = $(this).data('id');
                        alert('Open edit modal or navigate to edit page for question ID: ' +
                        id);
                        // You can implement your modal or redirect here
                    });
                }
            });
        });
    </script>
@endpush
