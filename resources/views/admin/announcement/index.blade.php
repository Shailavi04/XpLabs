@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Announcements List</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Tables</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Announcements</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="javascript:void(0);" class="btn btn-primary btn-wave d-flex align-items-center gap-2"
                    data-bs-toggle="modal" data-bs-target="#addAnnouncementModal">
                    <i class="fas fa-plus"></i> Add Announcement
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table id="announcement-table" class="table table-bordered w-100">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Message</th>
                            <th>Classroom</th>
                            <th>Recipients</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Announcement Modal -->
    <!-- Add Announcement Modal -->
    <div class="modal fade" id="addAnnouncementModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form action="{{ route('annoucement.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Announcement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">

                            {{-- Classroom --}}
                            <div class="col-md-12">
                                <label for="classroom_id" class="form-label">Classroom (Optional)</label>
                                <select name="classroom_id" id="classroom_id" class="form-select">
                                    <option value="">-- Select Classroom --</option>
                                    @foreach ($classrooms as $classroom)
                                        <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Title --}}
                            <div class="col-md-12">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control" required>
                            </div>

                            {{-- Message --}}
                            <div class="col-md-12">
                                <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                                <textarea name="message" id="message" class="form-control" rows="4" required></textarea>
                            </div>

                            {{-- Recipients --}}
                            <div class="col-md-12">
                                <label for="recipientSelectAdd" class="form-label">Recipients <span
                                        class="text-danger">*</span></label>
                                <select name="recipient[]" id="recipientSelectAdd" class="form-select select2" multiple
                                    required>
                                    @php
                                        $role = auth()->user()->role_id; // 1 = Admin, 2 = Teacher, 3 = Staff
                                    @endphp

                                    @if ($role == 1)
                                        <option value="1">Students</option>
                                        <option value="2">Teachers</option>
                                        <option value="4">Staff</option>
                                    @elseif ($role == 2)
                                        <option value="1">Students</option>
                                        <option value="2">Teachers</option>
                                    @elseif ($role == 3)
                                        <option value="1">Students</option>
                                    @endif
                                </select>
                                <small class="text-muted">You can select one or more recipients</small>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i> Send Announcement
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Announcement Modal -->
    <div class="modal fade" id="editAnnouncementModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form method="POST" id="editAnnouncementForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Announcement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">
                            <input type="hidden" name="id" id="editAnnouncementId">

                            {{-- Classroom --}}
                            <div class="col-md-12">
                                <label for="editClassroomId" class="form-label">Classroom (Optional)</label>
                                <select name="classroom_id" id="editClassroomId" class="form-select">
                                    <option value="">-- Select Classroom --</option>
                                    @foreach ($classrooms as $classroom)
                                        <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Title --}}
                            <div class="col-md-12">
                                <label for="editTitle" class="form-label">Title <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="title" id="editTitle" class="form-control" required>
                            </div>

                            {{-- Message --}}
                            <div class="col-md-12">
                                <label for="editMessage" class="form-label">Message <span
                                        class="text-danger">*</span></label>
                                <textarea name="message" id="editMessage" class="form-control" rows="4" required></textarea>
                            </div>

                            {{-- Recipients --}}
                            <div class="col-md-12">
                                <label for="recipientSelectEdit" class="form-label">Recipients <span
                                        class="text-danger">*</span></label>
                                <select name="recipient[]" id="recipientSelectEdit" class="form-select select2" multiple
                                    required>
                                    @if ($role == 1)
                                        <option value="1">Students</option>
                                        <option value="2">Teachers</option>
                                        <option value="4">Staff</option>
                                    @elseif ($role == 2)
                                        <option value="1">Students</option>
                                        <option value="2">Teachers</option>
                                    @elseif ($role == 3)
                                        <option value="1">Students</option>
                                    @endif
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Announcement
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    {{-- Select2 CSS --}}

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Make Select2 match Bootstrap height */
        .select2-container .select2-selection--multiple {
            min-height: calc(1.5em + 0.75rem + 2px);
            padding: 0.375rem 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
        }
    </style>
@endpush

@push('script')
    <script>
        $(function() {
            // Open Edit Announcement modal & populate fields
            $(document).on('click', '.edit-announcement-btn', function() {
                let id = $(this).data('id');
                $.get("{{ url('annoucement/edit') }}/" + id, function(response) {
                    if (response.announcement) {
                        const a = response.announcement;

                        $('#editAnnouncementId').val(a.id);
                        $('#editClassroomId').val(a.classroom_id);
                        $('#editTitle').val(a.title);
                        $('#editMessage').val(a.message);

                        // Preselect recipients for Select2
                        let selectedRecipients = [];
                        if (a.recipient & 1) selectedRecipients.push('1'); // Students
                        if (a.recipient & 2) selectedRecipients.push('2'); // Teachers
                        if (a.recipient & 4) selectedRecipients.push('4'); // Staff

                        $('#recipientSelectEdit').val(selectedRecipients).trigger('change');

                        $('#editAnnouncementForm').attr('action',
                            "{{ url('annoucement/update') }}/" + id);
                        $('#editAnnouncementModal').modal('show');
                    }
                });
            });


            $('#announcement-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('annoucement.data') }}',
                columns: [{
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
                        data: 'message',
                        name: 'message'
                    },
                    {
                        data: 'classroom',
                        name: 'classroom'
                    },
                    {
                        data: 'recipients',
                        name: 'recipients'
                    },
                  
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    searchPlaceholder: "Search annoucement...",
                    search: ""
                }
            });
        });

        $(document).ready(function() {
            // Initialize Select2 for both Add & Edit
            $('.select2').select2({
                placeholder: "Choose recipients",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endpush
