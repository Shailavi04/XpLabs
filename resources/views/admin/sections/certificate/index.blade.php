@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">certificate List</h1>
                <div>
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
                    {{-- Add Button --}}
                    <div class="d-flex justify-content-end mb-3">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCompanyModal">
                            + Add certificate
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table Listing --}}
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>About</th>
                                        <th>Description</th>
                                        <th>Image</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($certificate as $company)
                                        <tr>
                                            <td>{{ $company->title }}</td>
                                            <td>{{ Str::limit($company->about, 50) }}</td>
                                            <td>{{ Str::limit(strip_tags($company->description), 50) }}</td>
                                            <td>
                                                @if ($company->image)
                                                    <img src="{{ asset('uploads/certificate/' . $company->image) }}"
                                                        alt="Image" height="40">
                                                @else
                                                    No Image
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                        type="button" id="dropdownMenu{{ $company->id }}"
                                                        data-bs-toggle="dropdown" aria-expanded="false"
                                                        style="padding: 4px 8px; border-radius: 6px;">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end"
                                                        aria-labelledby="dropdownMenu{{ $company->id }}">
                                                        <li>
                                                            <a href="javascript:void(0);" class="dropdown-item edit-btn"
                                                                data-id="{{ $company->id }}"
                                                                data-title="{{ $company->title }}"
                                                                data-about="{{ $company->about }}"
                                                                data-description="{{ e($company->description) }}"
                                                                data-bs-toggle="modal" data-bs-target="#editCompanyModal">
                                                                <i class="fas fa-edit text-primary me-2"></i> Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="{{ route('web_pages.certificate.destroy', $company->id) }}"
                                                                method="POST" id="delete-form-{{ $company->id }}"
                                                                class="d-none">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                            <a href="javascript:void(0);" class="dropdown-item text-danger"
                                                                onclick="confirmDelete({{ $company->id }})">
                                                                <i class="fas fa-trash-alt me-2"></i> Delete
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No Data found</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addCompanyModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('web_pages.certificate.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add certificate</h5>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>About</label>
                                <textarea name="about" class="form-control" rows="5" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Description</label>
                                <div id="add_description_editor" style="height: 150px;"></div>
                                <input type="hidden" name="description" id="add_description_input" required>
                            </div>

                            <div class="mb-3">
                                <label>Image</label>
                                <input type="file" name="image" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success">Save</button>
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        {{-- Edit Modal --}}
        <div class="modal fade" id="editCompanyModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" id="editCompanyForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="edit_id">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Certificate</h5>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Title</label>
                                <input type="text" name="title" id="edit_title" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>About</label>
                                <textarea name="about" id="edit_about" class="form-control" rows="5" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Description</label>
                                <div id="edit_description_editor" style="height: 150px;"></div>
                                <input type="hidden" name="description" id="edit_description_input" required>
                            </div>

                            <div class="mb-3">
                                <label>Image</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success">Update</button>
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    @endsection

    @push('script')
        <script>
            var addQuill = new Quill('#add_description_editor', {
                theme: 'snow',
                placeholder: 'Enter description...',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        ['link', 'image']
                    ]
                }
            });

            var editQuill = new Quill('#edit_description_editor', {
                theme: 'snow',
                placeholder: 'Enter description...',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        ['link', 'image']
                    ]
                }
            });

            // On Add form submit, copy HTML content to hidden input
            $('#addCompanyModal form').on('submit', function(e) {
                var html = addQuill.root.innerHTML.trim();
                if (html === '<p><br></p>' || html === '') {
                    e.preventDefault();
                    alert('Description cannot be empty');
                    return false;
                }
                $('#add_description_input').val(html);
            });


            // On Edit form submit, copy HTML content to hidden input
            $('#editCompanyForm').on('submit', function(e) {
                var html = editQuill.root.innerHTML.trim();
                if (html === '<p><br></p>' || html === '') {
                    e.preventDefault();
                    alert('Description cannot be empty');
                    return false;
                }
                $('#edit_description_input').val(html);
            });
            $('.edit-btn').on('click', function() {
                let id = $(this).data('id');
                let title = $(this).data('title');
                let about = $(this).data('about');
                let description = $(this).data('description');

                $('#edit_id').val(id);
                $('#edit_title').val(title);
                $('#edit_about').val(about);

                // Decode HTML entities using textarea method
                const decoded = $('<textarea/>').html(description).text();
                editQuill.root.innerHTML = decoded;

                $('#editCompanyForm').attr('action', '/website_frontend/certificate/update/' + id);
            });

            function confirmDelete(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the corresponding hidden form
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            }
        </script>
    @endpush
