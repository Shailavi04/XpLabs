@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Classroom List</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Tables</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Classrooms</li>
                        </ol>
                    </nav>
                </div>
            </div>
            @can('create_classroom')
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="javascript:void(0);" class="btn btn-primary btn-wave d-flex align-items-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#addClassroomModal">
                        <i class="fas fa-plus"></i> Add Classroom
                    </a>
                </div>
            @endcan
        </div>

        <div class="card">
            <div class="card-body">
                <table id="classroom-table" class="table table-bordered w-100">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Batch</th>
                            <th>Type</th>
                            <th>no_of_seats</th>
                            <th>Link</th>
                            <th>Status</th>
                            @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2 || auth()->user()->role_id == 3)
                                <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Classroom Modal -->
    <div class="modal fade" id="addClassroomModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form action="{{ route('classroom.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Classroom</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label>Batch</label>
                                <select name="batch_id" class="form-select" required>
                                    <option value="">-- Select Batch --</option>
                                    @foreach ($batches as $batch)
                                        <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Type</label>
                                <select name="type" class="form-select">
                                    <option value="offline">Offline</option>
                                    <option value="online">Online</option>
                                    <option value="hybrid">Hybrid</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>No of Seats</label>
                                <input type="number" name="no_of_seats" class="form-control">
                            </div>

                            <div class="col-md-6 mode-dependent" id="onlineLinkDiv" style="display:none;">
                                <label>Online Meeting Link</label>
                                <input type="url" name="meeting_link" class="form-control">
                            </div>

                            <div class="col-md-6 mode-dependent" id="meetingPasswordDiv" style="display:none;">
                                <label>Meeting Password</label>
                                <input type="text" name="meeting_password" class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Classroom</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Classroom Modal -->
    <div class="modal fade" id="editClassroomModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form method="POST" id="editClassroomForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Classroom</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <input type="hidden" name="id" id="editClassroomId">

                            <div class="col-md-12">
                                <label>Name</label>
                                <input type="text" name="name" id="editName" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label>Batch</label>
                                <select name="batch_id" id="editBatchId" class="form-select" required>
                                    <option value="">-- Select Batch --</option>
                                    @foreach ($batches as $batch)
                                        <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Type</label>
                                <select name="type" id="editType" class="form-select">
                                    <option value="offline">Offline</option>
                                    <option value="online">Online</option>
                                    <option value="hybrid">Hybrid</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>no_of_seats</label>
                                <input type="number" name="no_of_seats" id="editno_of_seats" class="form-control">
                            </div>

                            <div class="col-md-6 mode-dependent" id="editOnlineLinkDiv" style="display:none;">
                                <label>Online Meeting Link</label>
                                <input type="url" name="meeting_link" id="editMeetingLink" class="form-control">
                            </div>

                            <div class="col-md-6 mode-dependent" id="editMeetingPasswordDiv" style="display:none;">
                                <label>Meeting Password</label>
                                <input type="text" name="meeting_password" id="editMeetingPassword"
                                    class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label>Description</label>
                                <textarea name="description" id="editDescription" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Classroom</button>
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
            // Show online fields if type is online or hybrid
            $('select[name="type"]').on('change', function() {
                const val = $(this).val();
                if (val === 'online' || val === 'hybrid') {
                    $('#onlineLinkDiv, #meetingPasswordDiv').show();
                } else {
                    $('#onlineLinkDiv, #meetingPasswordDiv').hide();
                }
            });

            $('#editType').on('change', function() {
                const val = $(this).val();
                if (val === 'online' || val === 'hybrid') {
                    $('#editOnlineLinkDiv, #editMeetingPasswordDiv').show();
                } else {
                    $('#editOnlineLinkDiv, #editMeetingPasswordDiv').hide();
                }
            });

            // Open Edit Classroom modal & populate fields
            $(document).on('click', '.edit-classroom-btn', function() {
                let id = $(this).data('id');
                $.get("{{ url('classroom/edit') }}/" + id, function(response) {
                    if (response.classroom) {
                        const c = response.classroom;

                        $('#editClassroomId').val(c.id);
                        $('#editName').val(c.name);
                        $('#editBatchId').val(c.batch_id);
                        $('#editType').val(c.type).trigger('change');
                        $('#editno_of_seats').val(c.no_of_seats);
                        $('#editMeetingLink').val(c.meeting_link);
                        $('#editMeetingPassword').val(c.meeting_password);
                        $('#editDescription').val(c.description);

                        $('#editClassroomForm').attr('action', "{{ url('classroom/update') }}/" +
                            id);
                        $('#editClassroomModal').modal('show');
                    }
                });
            });

            let columns = [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'batch',
                    name: 'batch'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'no_of_seats',
                    name: 'no_of_seats'
                },
                {
                    data: 'meeting_link',
                    name: 'meeting_link'
                },
                {
                    data: 'status',
                    name: 'status'
                }
            ];

            // Conditionally add the action column
            @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 3 || auth()->user()->role_id == 2)
                columns.push({
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                });
            @endif

            $('#classroom-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('classroom.data') }}',
                columns: columns,
                language: {
                    searchPlaceholder: "Search classrooms...",
                    search: ""
                }
            });

        });
    </script>
@endpush
