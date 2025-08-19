@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Quiz List</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Tables</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Quizzes</li>
                    </ol>
                </nav>
            </div>
            <div>
                @can('create_exam')
                    <button id="btnAddQuiz" class="btn btn-primary">+ Add Quiz</button>
                @endcan
            </div>
        </div>

        <div class="card custom-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="quizTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Published</th>
                                <th>Public</th>
                                <th>Courses</th>
                                <th>Questions</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- DataTables will fill this --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Quiz Modal -->
    <div class="modal fade" id="addQuizModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('quiz.store') }}" id="addQuizForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Quiz</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <div class="col-md-4">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control" required />
                        </div>
                        <div class="col-md-4">
                            <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                            <input type="text" name="slug" id="slug" class="form-control" required />
                        </div>
                        <div class="col-md-4">
                            <label>Published</label>
                            <select name="published" class="form-select">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Public</label>
                            <select name="public" class="form-select">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label>Courses</label>
                            <select name="courses[]" id="add_courses" class="form-select" multiple required>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label>Questions</label>
                            <select name="questions[]" id="add_questions" class="form-select" multiple required>
                                @foreach ($questions as $question)
                                    <option value="{{ $question->id }}">{{ Str::limit($question->text, 80) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label>Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Quiz Modal -->
    <div class="modal fade" id="editQuizModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" id="editQuizForm">
                    @csrf
                    <input type="hidden" name="quiz_id" id="edit_quiz_id">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Quiz</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <div class="col-md-4">
                            <label>Title</label>
                            <input type="text" name="title" id="edit_title" class="form-control" required />
                        </div>
                        <div class="col-md-4">
                            <label>Slug</label>
                            <input type="text" name="slug" id="edit_slug" class="form-control" required />
                        </div>
                        <div class="col-md-4">
                            <label>Published</label>
                            <select name="published" id="edit_published" class="form-select">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Public</label>
                            <select name="public" id="edit_public" class="form-select">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label>Courses</label>
                            <select name="courses[]" id="edit_courses" class="form-select" multiple required>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label>Questions</label>
                            <select name="questions[]" id="edit_questions" class="form-select" multiple required>
                                @foreach ($questions as $question)
                                    <option value="{{ $question->id }}">{{ Str::limit($question->text, 80) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label>Description</label>
                            <textarea name="description" id="edit_description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
@endpush

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {

            $('#title').on('input', function() {
                let title = $(this).val();
                let baseSlug = title
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .trim();

                // Random 4-digit number suffix
                let random = Math.floor(1000 + Math.random() * 9000);

                $('#slug').val(`${baseSlug}-${random}`);
            });

            const addModal = new bootstrap.Modal(document.getElementById('addQuizModal'));
            const editModal = new bootstrap.Modal(document.getElementById('editQuizModal'));

            $('#add_courses, #add_questions').select2({
                dropdownParent: $('#addQuizModal'),
                width: '100%',
                placeholder: 'Select options'
            });

            $('#edit_courses, #edit_questions').select2({
                dropdownParent: $('#editQuizModal'),
                width: '100%',
                placeholder: 'Select options'
            });

            $('#btnAddQuiz').on('click', function() {
                $('#addQuizForm')[0].reset();
                $('#add_courses').val(null).trigger('change');
                $('#add_questions').val(null).trigger('change');
                addModal.show();
            });

            $(document).on('click', '.btnEditQuiz', function() {
                const quizId = $(this).data('id');

                $.ajax({
                    url: `/quiz/edit/${quizId}`,
                    method: 'GET',
                    success: function(data) {
                        $('#edit_quiz_id').val(data.id);
                        $('#edit_title').val(data.title);
                        $('#edit_slug').val(data.slug);
                        $('#edit_published').val(data.published);
                        $('#edit_public').val(data.public);
                        $('#edit_description').val(data.description);

                        let courseIds = data.courses.map(c => c.id);
                        $('#edit_courses').val(courseIds).trigger('change');

                        let questionIds = data.questions.map(q => q.id);
                        $('#edit_questions').val(questionIds).trigger('change');

                        $('#editQuizForm').attr('action', `/quiz/update/${quizId}`);
                        editModal.show();
                    },
                    error: function() {
                        alert('Error loading quiz data.');
                    }
                });
            });

            $('#quizTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('quiz.quiz_data') }}",
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
                        data: 'slug',
                        name: 'slug'
                    },
                    {
                        data: 'published',
                        name: 'published'
                    },
                    {
                        data: 'public',
                        name: 'public'
                    },
                    {
                        data: 'courses',
                        name: 'courses',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'questions',
                        name: 'questions',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [1, 'desc']
                ], // Default order by title desc
                lengthMenu: [10, 25, 50],
            });

        });
    </script>
@endpush
