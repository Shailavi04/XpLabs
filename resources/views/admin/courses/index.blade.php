@extends('admin.layouts.app')

@section('content')
    <style>
        .custom-dropzone {
            border: 2px dashed deeppink;
            border-radius: 10px;
            background-color: #fff;
            padding: 40px;
            cursor: pointer;
            position: relative;
        }

        .custom-dropzone:hover {
            background-color: #fdf4f8;
        }

        .text-pink {
            color: deeppink;
        }

        .dz-message {
            pointer-events: none;
        }

        .custom-dropzone img.preview {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            border-radius: 6px;
            pointer-events: none;
        }
    </style>


    <div class="container-fluid">

        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Course List</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Tables</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Tables</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <div class="d-flex gap-2">
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


                    <a href="javascript:void(0);" class="btn btn-primary btn-wave d-flex align-items-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#addSymptomModal">
                        <i class="fas fa-plus"></i><span>{{ __('Add New Course') }}</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="courses-table" class="table table-bordered text-nowrap w-100">

                                <thead class="">
                                    <tr>
                                        <th>#</th>
                                        <th>Course Name</th>
                                        <th>Course Code</th>
                                        <th>Duration</th>
                                        <th>Category</th>
                                        <th>Student</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="addSymptomModal" tabindex="-1" aria-labelledby="addSymptomModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <form action="{{ route('course.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('Add New Course') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row">


                                @if (auth()->user()->role_id == 2)
                                    <div class="row g-3">

                                        <div class="col-md-12">
                                            <label class="form-label">Center</label>
                                            <select name="center_id" class="form-select" required>
                                                <option value="">-- Select Center --</option>
                                                @foreach ($centers as $id => $name)
                                                    <option value="{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label">Course</label>
                                            <select name="course_id" class="form-select" required>
                                                @forelse($courses as $course)
                                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                                @empty
                                                    <option value="">No course available yet</option>
                                                @endforelse
                                            </select>
                                        </div>

                                    </div>
                                @endif

                                @if (auth()->user()->role_id == 1)
                                    <div class="col-md-4">



                                        <!-- Left side: Profile / Image upload -->
                                        <!-- Dropzone preview container -->
                                        <div id="courseImageDropzone" class="custom-dropzone text-center">
                                            <div class="dz-message">

                                                <p class="mb-1 fw-semibold text-dark">Drag & drop to upload</p>
                                                <small class="text-pink">or <span
                                                        class="text-decoration-underline">browse</span></small>
                                            </div>
                                            <div id="imagePreviewWrapper" class="mt-3"></div>
                                        </div>

                                        <input type="file" name="image" id="realImageInput" hidden>



                                    </div>

                                    <!-- Hidden input to store uploaded image path -->

                                    <!-- Right side: Form fields -->
                                    <div class="col-md-8">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="category_id" class="form-label">Category <span
                                                        class="text-danger">*</span></label>
                                                <select name="category_id" id="category_id" class="form-control" required>
                                                    <option value="">-- Select Category --</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="name" class="form-label">Course Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control" id="name"
                                                    required>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="code" class="form-label">Course Code <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="code" class="form-control" id="code"
                                                    required>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="duration" class="form-label">Duration <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="duration" class="form-control"
                                                    id="duration" placeholder="e.g. 6 Months">
                                            </div>

                                            <div class="col-md-6">
                                                <label for="total_fee" class="form-label">Total Fee <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" step="0.01" min="0" name="total_fee"
                                                    id="total_fee" class="form-control" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="seats_available" class="form-label">Seats Available <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" min="0" name="seats_available"
                                                    id="seats_available" class="form-control" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="token_amount" class="form-label">Token Amount</label>
                                                <input type="number" step="0.01" min="0" name="token_amount"
                                                    id="token_amount" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Separate row for description and curriculum -->
                                    <div class="col-md-12">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea name="description" id="description" class="form-control" rows="5"
                                            placeholder="Enter description..."></textarea>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label for="curriculumEditor" class="form-label">Course Curriculum</label>
                                        <div id="curriculumEditor" style="min-height: 100px; background: white;"></div>
                                        <input type="hidden" name="curriculum" id="curriculumInput">
                                    </div>
                                @endif
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Course</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>



        <!-- Edit Modal -->
        <div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <form id="editCourseForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Course</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row g-4">
                                {{-- Role 2 (Center staff) --}}
                                @if (auth()->user()->role_id == 2)
                                    <div class="col-md-12">
                                        <select id="edit_center_id" name="center_id" class="form-select"
                                            required></select>

                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label">Course</label>
                                        <select id="edit_course_id" name="course_id" class="form-select"
                                            required></select>
                                    </div>
                                @endif
                            </div>

                            {{-- Role 1 (Admin) --}}
                            @if (auth()->user()->role_id == 1)
                                <div class="row g-4 mt-4">
                                    <div class="col-md-4">
                                        <label class="form-label">Course Image</label>
                                        <div id="editCourseImageDropzone" class="custom-dropzone text-center">
                                            <div class="dz-message">
                                                <p class="mb-1 fw-semibold text-dark">Drag & drop to upload</p>
                                                <small class="text-pink">or <span
                                                        class="text-decoration-underline">browse</span></small>
                                            </div>
                                            <div id="editImagePreviewWrapper" class="mt-3">
                                                <img id="editPreviewImg" src="" alt="Preview"
                                                    class="preview d-none">
                                            </div>
                                        </div>
                                        <input type="file" name="image" id="editRealImageInput" accept="image/*"
                                            hidden>
                                        <input type="hidden" name="uploaded_image" id="editUploadedImage">
                                    </div>

                                    <div class="col-md-8">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="edit_category_id" class="form-label">Category <span
                                                        class="text-danger">*</span></label>
                                                <select name="category_id" id="edit_category_id" class="form-control"
                                                    required>
                                                    <option value="">-- Select Category --</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="edit_center_id" class="form-label">Centers</label>
                                                <select id="edit_center_id" name="center_id[]" class="form-select"
                                                    multiple>
                                                    <!-- Options will be populated by JS -->
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="edit_name" class="form-label">Course Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="name" id="edit_name" class="form-control"
                                                    required>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="edit_code" class="form-label">Course Code <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="code" id="edit_code" class="form-control"
                                                    required>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="edit_duration" class="form-label">Duration <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="duration" id="edit_duration"
                                                    class="form-control" placeholder="e.g. 6 Months" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="edit_total_fee" class="form-label">Total Fee <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" step="0.01" min="0" name="total_fee"
                                                    id="edit_total_fee" class="form-control" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="edit_token_amount" class="form-label">Token Amount</label>
                                                <input type="number" step="0.01" min="0" name="token_amount"
                                                    id="edit_token_amount" class="form-control">
                                            </div>

                                            <div class="col-md-6">
                                                <label for="edit_seats_available" class="form-label">Seats Available <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" min="0" name="seats_available"
                                                    id="edit_seats_available" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Description + Curriculum --}}
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <label for="edit_description" class="form-label">Description</label>
                                            <textarea name="description" id="edit_description" class="form-control" rows="5"
                                                placeholder="Enter description..."></textarea>
                                        </div>

                                        <div class="col-md-12">
                                            <label for="edit_curriculumEditor" class="form-label">Course
                                                Curriculum</label>
                                            <div id="edit_curriculumEditor" class="bg-white p-2 border rounded"
                                                style="min-height: 100px;"></div>
                                            <input type="hidden" name="curriculum" id="edit_curriculumInput">
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update Course</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@push('script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

    <script>
        $(function() {
            const fullToolbarOptions = [
                [{
                    'font': []
                }, {
                    'size': []
                }],
                ['bold', 'italic', 'underline', 'strike'],
                [{
                    'color': []
                }, {
                    'background': []
                }],
                [{
                    'script': 'sub'
                }, {
                    'script': 'super'
                }],
                [{
                    'header': [1, 2, false]
                }],
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                [{
                    'indent': '-1'
                }, {
                    'indent': '+1'
                }],
                [{
                    'direction': 'rtl'
                }],
                [{
                    'align': []
                }],
                ['blockquote', 'code-block'],
                ['link', 'image', 'video'],
                ['clean'] // remove formatting button
            ];

            let curriculumQuill;
            let editCurriculumQuill;

            // Initialize DataTable
            let table = $('#courses-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('course.data') }}',
                    data: function(d) {
                        d.student_id = $('#filterStudentId')
                            .val(); // pass selected student ID as filter param
                    }
                },
                columns: [{
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
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'duration',
                        name: 'duration'
                    },
                    {
                        data: 'category_name',
                        name: 'category.name'
                    },
                    {
                        data: 'student_name',
                        name: 'student_name',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return `<img src="${data}" width="60" height="60" style="object-fit:cover;" />`;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                language: {
                    searchPlaceholder: "Search courses...",
                    search: "",
                },
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Show All"]
                ],
            });

            // Initialize Quill for Add Modal
            const initQuill = () => {
                if (!curriculumQuill) {
                    curriculumQuill = new Quill('#curriculumEditor', {
                        theme: 'snow',
                        modules: {
                            toolbar: fullToolbarOptions
                        }
                    });
                    autoGrow(curriculumQuill);
                }
            };

            // Initialize Quill for Edit Modal
            const initEditQuill = () => {
                if (!editCurriculumQuill) {
                    editCurriculumQuill = new Quill('#edit_curriculumEditor', {
                        theme: 'snow',
                        modules: {
                            toolbar: fullToolbarOptions
                        }
                    });
                    autoGrow(editCurriculumQuill);
                }
            };

            // Auto-grow functionality for Quill editor
            const autoGrow = (editor) => {
                const root = editor.root;
                const container = root.parentElement;

                const resize = () => {
                    container.style.height = 'auto';
                    container.style.height = root.scrollHeight + 'px';
                };

                editor.on('text-change', resize);
                resize();
            };

            // Event listener for Add Modal
            document.getElementById('addSymptomModal').addEventListener('shown.bs.modal', initQuill);

            // Event listener for Edit Modal
            $(document).on('shown.bs.modal', '#editCourseModal', function() {
                const userRole = {{ auth()->user()->role_id }};
                if (userRole === 1) {
                    initEditQuill();
                    const curriculumContent = $(this).data('curriculum') || '';
                    editCurriculumQuill.root.innerHTML = curriculumContent; // Set the curriculum content
                }
            });

            // Submit handler for Add form
            document.querySelector('#addSymptomModal form').addEventListener('submit', function(e) {
                if (curriculumQuill) {
                    document.getElementById('curriculumInput').value = curriculumQuill.root.innerHTML;
                }
            });

            // Submit handler for Edit form
            $('#editCourseForm').on('submit', function(e) {
                if (editCurriculumQuill) {
                    $('#edit_curriculumInput').val(editCurriculumQuill.root.innerHTML);
                }
            });

            // Fetch course data for editing
            $(document).on('click', '.edit-course-btn', function() {
                let courseId = $(this).data('id');
                $('#editCourseForm').attr('action', `/course/update/${courseId}`);

                fetch(`/course/edit/${courseId}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Failed to fetch course data');
                        return response.json();
                    })
                    .then(data => {
                        if (!data.success) throw new Error(data.error || 'Failed to fetch course data');

                        const course = data.course;
                        const userRole = {{ auth()->user()->role_id }};

                        // Clear dropdowns
                        $('#edit_center_id').empty();
                        $('#edit_course_id').empty();

                        // Populate course dropdown
                        $('#edit_course_id').append($('<option>', {
                            value: course.id,
                            text: course.name
                        })).val(course.id);

                        if (userRole === 2) { // Center staff
                            // Populate centers for the course
                            data.user_centers.forEach(center => {
                                $('#edit_center_id').append($('<option>', {
                                    value: center.id,
                                    text: center.name,
                                    selected: true // Mark as selected if it's associated with the course
                                }));
                            });
                        } else if (userRole === 1) { // Admin
                            // Populate centers for Admin
                            data.all_centers.forEach(center => {
                                $('#edit_center_id').append($('<option>', {
                                    value: center.id,
                                    text: center.name,
                                    selected: course.centers.some(c => c.id ===
                                        center.id) // Set selected centers
                                }));
                            });
                        }

                        // Populate other form fields for admin
                        if (userRole === 1) {
                            $('#edit_category_id').val(course.category_id);
                            $('#edit_name').val(course.name);
                            $('#edit_code').val(course.code);
                            $('#edit_duration').val(course.duration);
                            $('#edit_total_fee').val(course.total_fee);
                            $('#edit_seats_available').val(course.seats_available);
                            $('#edit_token_amount').val(course.token_amount);
                            $('#edit_description').val(course.description || '');

                            const previewImg = document.getElementById("editPreviewImg");
                            if (course.image) {
                                previewImg.src = `/uploads/courses/${course.image}`;
                                previewImg.classList.remove("d-none");
                            } else {
                                previewImg.classList.add("d-none");
                            }

                            if (editCurriculumQuill) {
                                editCurriculumQuill.root.innerHTML = course.curriculum || '';
                            } else {
                                $('#editCourseModal').data('curriculum', course.curriculum || '');
                            }
                        }

                        $('#editCourseModal').modal('show');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert(error.message);
                    });
            });



            // Dropzone for course image upload
            Dropzone.autoDiscover = false;

            const courseImageDropzone = new Dropzone("#courseImageDropzone", {
                url: "#",
                autoProcessQueue: false,
                maxFiles: 1,
                acceptedFiles: 'image/*',
                previewsContainer: false,
                clickable: "#courseImageDropzone",
                createImageThumbnails: false,
                init: function() {
                    this.on("addedfile", function(file) {
                        if (this.files.length > 1) {
                            this.removeFile(this.files[0]);
                        }
                        const imagePreviewWrapper = document.getElementById(
                            'imagePreviewWrapper');
                        imagePreviewWrapper.innerHTML = "";

                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.classList.add('preview');
                            imagePreviewWrapper.appendChild(img);
                        };
                        reader.readAsDataURL(file);

                        const dt = new DataTransfer();
                        dt.items.add(file);
                        document.getElementById('realImageInput').files = dt.files;
                    });
                }
            });

            const editDropzone = new Dropzone("#editCourseImageDropzone", {
                url: "#",
                autoProcessQueue: false,
                maxFiles: 1,
                acceptedFiles: "image/*",
                previewsContainer: false,
                clickable: "#editCourseImageDropzone",
                createImageThumbnails: false,
                init: function() {
                    this.on("addedfile", function(file) {
                        if (this.files.length > 1) this.removeFile(this.files[0]);

                        const previewImg = document.getElementById("editPreviewImg");
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            previewImg.src = e.target.result;
                            previewImg.classList.remove("d-none");
                        };
                        reader.readAsDataURL(file);

                        const dt = new DataTransfer();
                        dt.items.add(file);
                        document.getElementById("editRealImageInput").files = dt.files;
                    });
                }
            });

            // Delete course confirmation
            $(document).on('click', '.course-delete-btn', function(e) {
                e.preventDefault();
                const form = $(this).closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745', // green
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
