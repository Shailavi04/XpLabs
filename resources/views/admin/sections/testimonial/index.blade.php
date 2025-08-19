@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Testimonial Section</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Tables</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Testimonials</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <div class="d-flex justify-content-end mb-3">
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#addModal">
                        <i class="las la-plus"></i> Add Section
                    </button>
                </div>
            </div>
        </div>

        <!-- Table listing testimonial sections -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Label</th>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Background</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($testimonial_sections as $item)
                                        <tr>
                                            <td>{{ $item->label }}</td>
                                            <td>{{ $item->title }}</td>
                                            <td>{{ ucfirst($item->type) }}</td>
                                            <td>
                                                @if ($item->background_image)
                                                    <img src="{{ asset('uploads/testimonials/' . $item->background_image) }}"
                                                        width="60" alt="Background Image">
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary" type="button"
                                                        id="dropdownMenu{{ $item->id }}" data-bs-toggle="dropdown"
                                                        aria-expanded="false" style="padding: 4px 8px; border-radius: 6px;">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end"
                                                        aria-labelledby="dropdownMenu{{ $item->id }}">
                                                        <li>
                                                            <a href="javascript:void(0);" class="dropdown-item editBtn"
                                                                data-bs-toggle="modal" data-id="{{ $item->id }}">
                                                                <i class="fas fa-edit text-primary me-2"></i> Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form id="delete-form-{{ $item->id }}"
                                                                action="{{ route('web_pages.testimonial.destroy', $item->id) }}"
                                                                method="POST" class="d-none">
                                                                @csrf
                                                            </form>
                                                            <a href="javascript:void(0);" class="dropdown-item text-danger"
                                                                onclick="confirmDelete({{ $item->id }})">
                                                                <i class="fas fa-trash-alt me-2"></i> Delete
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <form action="{{ route('web_pages.testimonial.store') }}" method="POST" enctype="multipart/form-data"
                    class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Testimonial Section</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">

                            <div class="col-md-3">

                                <label class="form-label">Type <span class="text-danger">*</span></label>
                                <select name="type" class="form-select type-selector" data-target="#addModal" required>
                                    <option value="success">Success</option>
                                    <option value="trust">Trust</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Label <span class="text-danger">*</span></label>
                                <input type="text" name="label" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="col-md-3 type-success">
                                <label class="form-label">Subtitle</label>
                                <input type="text" name="subtitle" class="form-control">
                            </div>
                            <div class="col-md-3 type-trust">
                                <label class="form-label">Button Text</label>
                                <input type="text" name="button_text" class="form-control">
                            </div>
                            <div class="col-md-3  type-trust">
                                <label class="form-label">Button URL</label>
                                <input type="url" name="button_url" class="form-control">
                            </div>
                            <div class="col-md-3 type-trust">
                                <label class="form-label">Background Image</label>
                                <input type="file" name="background_image" class="form-control">
                            </div>
                        </div>

                        <hr>

                        {{-- Multiple testimonial contents --}}
                        <h5>Profiles / Contents</h5>
                        <div class="testimonial-profiles-wrapper">
                            <div class="testimonial-profile-item mb-3 border p-3 rounded">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Profile Image <span class="text-danger">*</span></label>
                                        <input type="file" name="profile_image[]" class="form-control" required>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name[]" class="form-control" required>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Designation <span class="text-danger">*</span></label>
                                        <input type="text" name="designation[]" class="form-control" required>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Rating <span class="text-danger">*</span></label>
                                        <input type="text" name="rating[]" class="form-control" required>
                                    </div>

                                    <div class="col-md-3 type-trust">
                                        <label class="form-label">Rating Text</label>
                                        <input type="text" name="rating_text[]" class="form-control">
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <label class="form-label">About <span class="text-danger">*</span></label>
                                        <textarea name="about[]" rows="3" class="form-control" required></textarea>
                                    </div>
                                </div>

                                <button type="button"
                                    class="btn btn-danger btn-sm mt-3 remove-profile-btn">Remove</button>
                            </div>
                        </div>

                        <button type="button" id="addProfileBtn" class="btn btn-primary btn-sm mt-2">Add
                            Profile</button>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <form method="POST" enctype="multipart/form-data" class="modal-content" id="editForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Testimonial Section</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">

                            <input type="hidden" name="id" id="edit_id">

                            {{-- Section fields --}}
                            <div class="col-md-3">
                                <label class="form-label">Type <span class="text-danger">*</span></label>
                                <select name="type" class="form-select type-selector" id="editTypeSelector"
                                    data-target="#editModal" required>
                                    <option value="success">Success</option>
                                    <option value="trust">Trust</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Label <span class="text-danger">*</span></label>
                                <input type="text" name="label" id="editLabel" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="editTitle" class="form-control" required>
                            </div>
                            <div class="col-md-3 type-success">
                                <label class="form-label">Subtitle</label>
                                <input type="text" name="subtitle" id="editSubtitle" class="form-control">
                            </div>
                            <div class="col-md-3 type-trust">
                                <label class="form-label">Button Text</label>
                                <input type="text" name="button_text" id="editButtonText" class="form-control">
                            </div>
                            <div class="col-md-3 type-trust">
                                <label class="form-label">Button URL</label>
                                <input type="text" name="button_url" id="editButtonUrl" class="form-control">
                            </div>
                            <div class="col-md-3 type-trust">
                                <label class="form-label">Background Image</label>
                                <input type="file" name="background_image" class="form-control">
                                <small class="text-muted">Leave blank to keep existing image.</small>
                                <div id="currentBackgroundImage" class="mt-2"></div>
                            </div>
                        </div>


                        <hr>

                        {{-- Multiple testimonial contents --}}
                        <h5>Profiles / Contents</h5>
                        <div class="testimonial-profiles-wrapper">
                            {{-- Filled dynamically by JS on edit --}}
                        </div>

                        <button type="button" id="addProfileBtn" class="btn btn-primary btn-sm mt-2">Add
                            Profile</button>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // Toggle visibility of type based fields inside profiles wrapper
            function toggleProfileFields(type, container = '') {
                $(`${container} .type-success, ${container} .type-trust`).hide();
                if (type === 'success') {
                    $(`${container} .type-success`).show();
                } else if (type === 'trust') {
                    $(`${container} .type-trust`).show();
                }
            }

            // On main type selector change (Add or Edit modal)
            $(document).on('change', '.type-selector', function() {
                const type = $(this).val();
                const container = $(this).data('target');
                toggleProfileFields(type, container + ' .testimonial-profiles-wrapper');
            });

            // Create new profile block HTML
            function createProfileBlock(data = {}) {
                return `
            <div class="testimonial-profile-item mb-3 border p-3 rounded">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Profile Image</label>
                        <input type="file" name="profile_image[]" class="form-control" >
                        ${data.profile_image ? `<div class="current-profile-image mt-2"><img src="/uploads/testimonials/testimonials_profile_image/${data.profile_image}" width="100"></div>` : ''}
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name[]" class="form-control" value="${data.name ?? ''}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Designation <span class="text-danger">*</span></label>
                        <input type="text" name="designation[]" class="form-control" value="${data.designation ?? ''}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Rating <span class="text-danger">*</span></label>
                        <input type="text" name="rating[]" class="form-control" value="${data.rating ?? ''}" required>
                    </div>

                    <div class="col-md-4 type-trust">
                        <label class="form-label">Rating Text</label>
                        <input type="text" name="rating_text[]" class="form-control" value="${data.rating_text ?? ''}">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <label class="form-label">About <span class="text-danger">*</span></label>
                        <textarea name="about[]" rows="3" class="form-control" required>${data.about ?? ''}</textarea>
                    </div>
                </div>

                <button type="button" class="btn btn-danger btn-sm mt-3 remove-profile-btn">Remove</button>
            </div>
            `;
            }

            // Add profile on Add Profile button click (works for both modals)
            $(document).on('click', '#addModal #addProfileBtn, #editModal #addProfileBtn', function() {
                const modal = $(this).closest('.modal');
                modal.find('.testimonial-profiles-wrapper').append(createProfileBlock());

                // Trigger toggle fields based on current type
                const type = modal.find('.type-selector').val();
                toggleProfileFields(type, '#' + modal.attr('id'));
            });

            // Remove profile block
            $(document).on('click', '.remove-profile-btn', function() {
                $(this).closest('.testimonial-profile-item').remove();
            });

            // Load edit data
            $(document).on('click', '.editBtn', function() {
                let id = $(this).data('id');

                $.ajax({
                    url: `/website_frontend/testimonial/edit/${id}`,
                    type: 'GET',
                    success: function(data) {
                        if (!data.status) {
                            alert(data.message);
                            return;
                        }

                        let section = data.section;
                        let contents = data.contents || [];

                        // Fill section fields
                        $('#edit_id').val(section.id);
                        $('#editTypeSelector').val(section.type);
                        $('#editLabel').val(section.label);
                        $('#editTitle').val(section.title);
                        $('#editSubtitle').val(section.subtitle);
                        $('#editButtonText').val(section.button_text);
                        $('#editButtonUrl').val(section.button_url);

                        // Background image preview
                        if (section.background_image) {
                            $('#currentBackgroundImage').html(
                                `<img src="/uploads/testimonials/${section.background_image}" width="100" alt="Background Image">`
                            );
                        } else {
                            $('#currentBackgroundImage').html('');
                        }

                        // Clear previous profiles
                        $('#editModal .testimonial-profiles-wrapper').empty();

                        // Add profile blocks for each content
                        contents.forEach(content => {
                            $('#editModal .testimonial-profiles-wrapper').append(
                                createProfileBlock(content));
                        });

                        // Apply field toggling
                        toggleProfileFields(section.type, '#editModal');

                        // Set form action
                        $('#editForm').attr('action',
                            `/website_frontend/testimonial/update/${section.id}`);

                        // Show modal
                        $('#editModal').modal('show');
                    },
                    error: function() {
                        alert('Failed to fetch testimonial data.');
                    }
                });
            });

            // Trigger toggle fields on Add modal open
            $('#addModal').on('shown.bs.modal', function() {
                const type = $('#addModal .type-selector').val();
                toggleProfileFields(type, '#addModal');
            });

        });

        // Confirm delete function
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this testimonial section?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
@endpush
