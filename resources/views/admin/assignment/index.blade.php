@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Assignments</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">LMS</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Assignments</li>
                        </ol>
                    </nav>
                </div>
            </div>
            @can('create_assignment')
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="javascript:void(0);" class="btn btn-primary btn-wave d-flex align-items-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#addAssignment">
                        <i class="fas fa-plus"></i> Add Assignment
                    </a>
                </div>
            @endcan

        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="assignment-table" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Course</th>
                                        <th>Batch</th>
                                        <th>Status</th>
                                        <th>Attachment</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addAssignment" tabindex="-1" aria-labelledby="addAssignmentLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <form action="{{ route('assignment.store') }}" method="POST" enctype="multipart/form-data"
                    id="addAssignmentForm">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('Add New Assignment') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="title" class="form-label">Title <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="course_id" class="form-label">Course <span
                                            class="text-danger">*</span></label>
                                    <select name="course_id" id="course_id" class="form-select" required>
                                        <option value="">-- Select Course --</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="batch_id" class="form-label">Batch <span
                                            class="text-danger">*</span></label>
                                    <select name="batch_id" id="batch_id" class="form-select" required>
                                        <option value="">-- Select Batch --</option>
                                        @foreach ($batches as $batch)
                                            <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <label for="status" class="form-label">Status <span
                                            class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="draft">Draft</option>
                                        <option value="published">Published</option>
                                        <option value="archived">Archived</option>
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <label for="attachment" class="form-label">Attachment</label>
                                    <input type="file" name="attachment" id="attachment" class="form-control"
                                        accept=".pdf,.doc,.docx,.jpg,.png">
                                </div>

                                <div class="col-md-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Assignment</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="editAssignment" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <form method="POST" enctype="multipart/form-data" id="editAssignmentForm">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Assignment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="id" id="edit-assignment-id">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="edit-title" class="form-label">Title <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="title" id="edit-title" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="edit-course_id" class="form-label">Course <span
                                            class="text-danger">*</span></label>
                                    <select name="course_id" id="edit-course_id" class="form-select" required>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="edit-batch_id" class="form-label">Batch <span
                                            class="text-danger">*</span></label>
                                    <select name="batch_id" id="edit-batch_id" class="form-select" required>
                                        @foreach ($batches as $batch)
                                            <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <label for="edit-status" class="form-label">Status <span
                                            class="text-danger">*</span></label>
                                    <select name="status" id="edit-status" class="form-select" required>
                                        <option value="draft">Draft</option>
                                        <option value="published">Published</option>
                                        <option value="archived">Archived</option>
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <label for="edit-attachment" class="form-label">Attachment</label>
                                    <input type="file" name="attachment" id="edit-attachment" class="form-control">
                                    <div id="current-attachment" class="mt-2"></div>
                                </div>

                                <div class="col-md-12">
                                    <label for="edit-description" class="form-label">Description</label>
                                    <textarea name="description" id="edit-description" class="form-control" rows="4"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Assignment</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal fade" id="submitAssignmentModal" tabindex="-1" aria-labelledby="submitAssignmentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="submitAssignmentModalLabel">Submit Assignment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="submitAssignmentForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="assignmentFile" class="form-label">Upload Your Assignment</label>
                                <input type="file" class="form-control" id="assignmentFile" name="assignment_file"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="comments" class="form-label">Comments (optional)</label>
                                <textarea class="form-control" id="comments" name="comments" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            var table = $('#assignment-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('assignment.data') }}',
                responsive: true,
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: 'course'
                    },
                    {
                        data: 'batch'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'attachment',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#assignment-table').on('click', '.btn-edit', function() {
                var id = $(this).data('id');
                $.get('{{ url('assignment/edit') }}/' + id, function(res) {
                    $('#edit-assignment-id').val(res.id);
                    $('#edit-title').val(res.title);
                    $('#edit-course_id').val(res.course_id);
                    $('#edit-batch_id').val(res.batch_id);
                    $('#edit-status').val(res.status);
                    $('#edit-description').val(res.description);
                    if (res.attachment) {
                        $('#current-attachment').html(
                            `<a href="{{ asset('uploads/assignments') }}/${res.attachment}" target="_blank">View Attachment</a>`
                        );
                    } else {
                        $('#current-attachment').html('No file uploaded');
                    }
                    $('#editAssignmentForm').attr('action', '{{ url('assignment/update') }}/' +
                        id);
                    $('#editAssignment').modal('show');
                });
            });

            $(document).on('click', '.assignment-delete-btn', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                Swal.fire({
                    title: 'Are you sure?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    confirmButtonText: 'Yes, delete it!'
                }).then(result => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

        var submitModal = document.getElementById('submitAssignmentModal');
        submitModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; // Button that triggered the modal
            var assignmentId = button.getAttribute('data-assignment-id');
            var form = document.getElementById('submitAssignmentForm');

            // Dynamically set the correct route
            form.action = '/assignment/submit/' + assignmentId;
        });
    </script>
@endpush
