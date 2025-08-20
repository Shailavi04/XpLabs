@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Study Material List</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Tables</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Study Material</li>
                        </ol>
                    </nav>
                </div>
            </div>
            @can('create_study_material')
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="javascript:void(0);" class="btn btn-primary btn-wave d-flex align-items-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#addStudyMaterialModal">
                        <i class="fas fa-plus"></i> Add Study Material
                    </a>
                </div>
            @endcan
        </div>

        <div class="card">
            <div class="card-body">
                <table id="study-material-table" class="table table-bordered w-100">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Course</th>
                            <th>Batch</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Link/File</th>
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

    <!-- Add Study Material Modal -->
    <!-- Add Study Material Modal -->
    <div class="modal fade" id="addStudyMaterialModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form id="addMaterialForm" action="{{ route('study_material.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Study Material</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label>Course</label>
                                <select name="course_id" class="form-select course-select" data-target="#batch-select"
                                    required>
                                    <option value="">-- Select Course --</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Batch</label>
                                <select name="batch_id" id="batch-select" class="form-select" required>
                                    <option value="">-- Select Batch --</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Type</label>
                                <select name="type" class="form-select type-select" required>
                                    <option value="pdf">PDF</option>
                                    <option value="video">Video</option>
                                    <option value="link">Link</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="col-md-6 type-input">
                                <label>File / Link</label>
                                <input type="file" name="value" class="form-control file-input"
                                    accept=".pdf,.mp4,.mov,.jpg,.jpeg,.png">
                                <input type="text" name="value" class="form-control link-input d-none"
                                    placeholder="Enter URL">
                            </div>

                            <div class="col-md-12">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="4"></textarea>
                            </div>

                            <div class="col-md-6">
                                <label>Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Material</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Study Material Modal -->
    <div class="modal fade" id="editStudyMaterialModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form id="editMaterialForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="material_id" id="editMaterialId">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Study Material</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label>Title</label>
                                <input type="text" name="title" id="editTitle" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label>Course</label>
                                <select name="course_id" id="editCourseId" class="form-select course-select"
                                    data-target="#editBatchSelect" required>
                                    <option value="">-- Select Course --</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Batch</label>
                                <select name="batch_id" id="editBatchSelect" class="form-select" required>
                                    <option value="">-- Select Batch --</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Type</label>
                                <select name="type" id="editType" class="form-select type-select" required>
                                    <option value="pdf">PDF</option>
                                    <option value="video">Video</option>
                                    <option value="link">Link</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="col-md-6 type-input">
                                <label>File / Link</label>
                                <input type="file" name="value" id="editFileInput" class="form-control file-input">
                                <input type="text" name="value" id="editLinkInput"
                                    class="form-control link-input d-none" placeholder="Enter URL">
                            </div>

                            <div class="col-md-12">
                                <label>Description</label>
                                <textarea name="description" id="editDescription" class="form-control" rows="4"></textarea>
                            </div>

                            <div class="col-md-6">
                                <label>Status</label>
                                <select name="status" id="editStatus" class="form-select" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Material</button>
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
            let userRole = parseInt("{{ auth()->user()->role_id }}");

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
                    data: 'course',
                    name: 'course'
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
                    data: 'description',
                    name: 'description'
                },

                {
                    data: 'resource',
                    name: 'resource',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        if (row.type === 'link') {
                            return `<a href="${row.resource}" target="_blank">Open Link</a>`;
                        } else if (row.type === 'pdf' || row.type === 'video' || row.type === 'other') {
                            return `<a href="${row.resource}" target="_blank">Download</a>`;
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    data: 'status',
                    name: 'status'
                },

            ];

            if (userRole === 1 || userRole === 2 || userRole === 3) {
                columns.push({
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                });
            }

            // Initialize DataTable
            let table = $('#study-material-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('study_material.data') }}',
                columns: columns,
                language: {
                    searchPlaceholder: "Search study materials...",
                    search: ""
                }
            });

            // Load batches on course select
            $(document).on('change', '.course-select', function() {
                let courseId = $(this).val();
                let targetBatch = $(this).data('target'); // "#batch-select" or "#editBatchSelect"

                if (courseId) {
                    $.get("{{ route('study_material.getBatchesRoute') }}", {
                        course_id: courseId
                    }, function(res) {
                        let options = '<option value="">-- Select Batch --</option>';
                        if (res.batches && res.batches.length) {
                            res.batches.forEach(batch => {
                                options +=
                                    `<option value="${batch.id}">${batch.name}</option>`;
                            });
                        }
                        $(targetBatch).html(options);
                    });
                } else {
                    $(targetBatch).html('<option value="">-- Select Batch --</option>');
                }
            });

            // Edit modal click
            $(document).on('click', '.edit-material-btn', function() {
                const id = $(this).data('id');

                $.get('{{ url('study_material/edit') }}/' + id, function(res) {
                    const mat = res.material;

                    // Set input values
                    $('#editMaterialId').val(mat.id);
                    $('#editTitle').val(mat.title);
                    $('#editType').val(mat.type).trigger('change');
                    $('#editDescription').val(mat.description);
                    $('#editStatus').val(mat.status);

                    // Set course and load batch
                    $('#editCourseId').val(mat.course_id).trigger('change');

                    // Wait for batch AJAX to finish before setting batch
                    $(document).one('ajaxComplete', function() {
                        $('#editBatchSelect').val(mat.batch_id);
                    });

                    // File / Link toggle
                    if (mat.type === 'link') {
                        $('#editLinkInput').val(mat.value).removeClass('d-none');
                        $('#editFileInput').addClass('d-none').val('');
                    } else {
                        $('#editLinkInput').addClass('d-none').val('');
                        $('#editFileInput').removeClass('d-none');
                    }

                    // Set form action
                    $('#editMaterialForm').attr('action', '{{ url('study_material/update') }}/' +
                        id);

                    // Show modal
                    $('#editStudyMaterialModal').modal('show');
                });
            });

            // Delete confirmation
            $(document).on('submit', '.delete-material-form', function(e) {
                if (!confirm('Are you sure to delete this material?')) {
                    e.preventDefault();
                }
            });

            // Type change toggle for add modal
            $(document).on('change', '#addMaterialForm .type-select', function() {
                const type = $(this).val();
                const container = $(this).closest('.row').find('.type-input');
                if (type === 'link') {
                    container.find('.file-input').addClass('d-none');
                    container.find('.link-input').removeClass('d-none');
                } else {
                    container.find('.file-input').removeClass('d-none');
                    container.find('.link-input').addClass('d-none');
                }
            });

            // Reset add modal on open
            $('#addStudyMaterialModal').on('show.bs.modal', function() {
                const typeSelect = $(this).find('.type-select');
                typeSelect.val('pdf').trigger('change');
                $(this).find('.file-input').val('');
                $(this).find('.link-input').val('');
            });

            // Type change toggle for edit modal
            $(document).on('change', '#editMaterialForm .type-select', function() {
                const type = $(this).val();
                const container = $(this).closest('.row').find('.type-input');
                if (type === 'link') {
                    container.find('.file-input').addClass('d-none');
                    container.find('.link-input').removeClass('d-none');
                } else {
                    container.find('.file-input').removeClass('d-none');
                    container.find('.link-input').addClass('d-none');
                }
            });

        });
    </script>
@endpush
