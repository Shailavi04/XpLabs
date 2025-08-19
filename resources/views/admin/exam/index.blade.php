@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">


        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Online Exam List</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Tables</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Tables</li>
                        </ol>
                    </nav>
                </div>
            </div>
            @can('create_exam')
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <div class="d-flex gap-2">
                        <a href="javascript:void(0);" class="btn btn-primary btn-wave d-flex align-items-center gap-2"
                            data-bs-toggle="modal" data-bs-target="#addExamModal">
                            <i class="fas fa-plus"></i> Add Exam
                        </a>

                    </div>
                </div>
            @endcan

        </div>

        <div class="card">
            <div class="card-body">
                <table id="exam-table" class="table table-bordered w-100">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Duration</th>
                            <th>Mode</th>
                            <th>Batch</th>
                            <th>Status</th>
                            @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                                <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Exam Modal -->
    <div class="modal fade" id="addExamModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form action="{{ route('exam_online.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Exam</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label>Exam Date</label>
                                <input type="date" name="exam_date" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label>Duration (minutes)</label>
                                <input type="number" name="duration" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label>Mode</label>
                                <select name="mode" class="form-select" id="examMode" required>
                                    <option value="">-- Select Mode --</option>
                                    <option value="online">Online</option>
                                    <option value="offline">Offline</option>
                                </select>
                            </div>

                            <div class="col-md-6 mode-dependent" id="onlineLinkDiv" style="display:none;">
                                <label>Online Link</label>
                                <input type="url" name="online_link" class="form-control">
                            </div>

                            <div class="col-md-6 mode-dependent" id="locationDiv" style="display:none;">
                                <label>Location</label>
                                <input type="text" name="location" class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label>Batch</label>
                                <select name="batch_id" class="form-select">
                                    <option value="">-- Select Batch --</option>
                                    @foreach ($batches as $batch)
                                        <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label>Description / Instructions</label>
                                <textarea name="instructions" class="form-control" rows="4"></textarea>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Exam</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Exam Modal -->
    <div class="modal fade" id="editExamModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form method="POST" id="editExamForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Exam</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <input type="hidden" name="id" id="editExamId">

                            <div class="col-md-12">
                                <label>Title</label>
                                <input type="text" name="title" id="editTitle" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label>Exam Date</label>
                                <input type="date" name="exam_date" id="editExamDate" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label>Duration (minutes)</label>
                                <input type="number" name="duration" id="editDuration" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label>Mode</label>
                                <select name="mode" id="editExamMode" class="form-select" required>
                                    <option value="">-- Select Mode --</option>
                                    <option value="online">Online</option>
                                    <option value="offline">Offline</option>
                                </select>
                            </div>

                            <div class="col-md-6 mode-dependent" id="editOnlineLinkDiv" style="display:none;">
                                <label>Online Link</label>
                                <input type="url" name="online_link" id="editOnlineLink" class="form-control">
                            </div>

                            <div class="col-md-6 mode-dependent" id="editLocationDiv" style="display:none;">
                                <label>Location</label>
                                <input type="text" name="location" id="editLocation" class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label>Batch</label>
                                <select name="batch_id" id="editBatchId" class="form-select">
                                    <option value="">-- Select Batch --</option>
                                    @foreach ($batches as $batch)
                                        <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label>Description / Instructions</label>
                                <textarea name="instructions" id="editInstructions" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Exam</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            // Toggle fields based on Add Exam mode
            $('#addExamMode').on('change', function() {
                const mode = $(this).val();
                if (mode === 'online') {
                    $('#addOnlineLinkDiv').show();
                    $('#addLocationDiv').hide();
                } else if (mode === 'offline') {
                    $('#addLocationDiv').show();
                    $('#addOnlineLinkDiv').hide();
                } else {
                    $('.mode-dependent').hide();
                }
            });

            // Toggle fields based on Edit Exam mode
            $('#editExamMode').on('change', function() {
                const mode = $(this).val();
                if (mode === 'online') {
                    $('#editOnlineLinkDiv').show();
                    $('#editLocationDiv').hide();
                } else if (mode === 'offline') {
                    $('#editLocationDiv').show();
                    $('#editOnlineLinkDiv').hide();
                } else {
                    $('.mode-dependent').hide();
                }
            });

            // Open Edit Exam modal & fill fields
            $(document).on('click', '.edit-exam-btn', function() {
                let id = $(this).data('id');
                $.get("{{ url('exam_online/edit') }}/" + id, function(response) {
                    if (response.exam) {
                        const exam = response.exam;

                        $('#editExamId').val(exam.id);
                        $('#editTitle').val(exam.title);
                        $('#editExamDate').val(exam.exam_date);
                        $('#editDuration').val(exam.duration);
                        $('#editExamMode').val(exam.mode).trigger('change');
                        $('#editOnlineLink').val(exam.online_link);
                        $('#editLocation').val(exam.location);
                        $('#editBatchId').val(exam.batch_id);
                        $('#editInstructions').val(exam.instructions);

                        // Update form action URL
                        $('#editExamForm').attr('action', "{{ url('exam_online/update') }}/" + id);

                        $('#editExamModal').modal('show');
                    }
                });
            });



            $(document).ready(function() {
                // Define columns
                let columns = [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'exam_date',
                        name: 'exam_date'
                    },
                    {
                        data: 'duration',
                        name: 'duration'
                    },
                    {
                        data: 'mode',
                        name: 'mode'
                    },
                    {
                        data: 'batch',
                        name: 'batch'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                ];

                // Add action column only for role 1 or 2
                @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                    columns.push({
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    });
                @endif

                // Initialize DataTable
                $('#exam-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('exam_online.data') }}',
                    columns: columns,
                    language: {
                        searchPlaceholder: "Search exams...",
                        search: "",
                    },
                });
            });
        });
    </script>
@endpush
