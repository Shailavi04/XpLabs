@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="mt-2 mb-3 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Banner List</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Tables</a></li>
                        <li class="breadcrumb-item active">Banners</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card custom-card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Home Banner</h5>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#addBannerModal">
                            + Add Home Banner
                        </button>
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Heading</th>
                                    <th>Subheading</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $hasData = false; @endphp
                                @foreach ($banners as $banner)
                                    @php $hasData = true; @endphp

                                    <tr>
                                        <td>{{ $banner->id }}</td>
                                        <td>{{ ucfirst($banner->type) }}</td>
                                        <td>{{ $banner->heading }}</td>
                                        <td>{{ $banner->subheading }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary" type="button"
                                                    id="dropdownMenu{{ $banner->id }}" data-bs-toggle="dropdown"
                                                    aria-expanded="false" style="padding: 4px 8px; border-radius: 6px;">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end"
                                                    aria-labelledby="dropdownMenu{{ $banner->id }}">
                                                    <li>
                                                        <a href="javascript:void(0);" class="dropdown-item editBannerModal"
                                                            data-id="{{ $banner->id }}">
                                                            <i class="fas fa-edit text-primary me-2"></i> Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form id="delete-form-{{ $banner->id }}"
                                                            action="{{ route('web_pages.banner.destroy', $banner->id) }}"
                                                            method="POST" class="d-none">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <a href="javascript:void(0);" class="dropdown-item text-danger"
                                                            onclick="if(confirm('Are you sure you want to delete this banner?')) document.getElementById('delete-form-{{ $banner->id }}').submit();">
                                                            <i class="fas fa-trash-alt me-2"></i> Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @unless ($hasData)
                                    <tr>
                                        <td colspan="5" class="text-center">No Data found</td>
                                    </tr>
                                @endunless
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addBannerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('web_pages.banner.store') }}" enctype="multipart/form-data"
                    id="addBannerForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Banner</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">

                            <div class="col-md-4">
                                <label for="type_add" class="form-label">Type <span class="text-danger">*</span></label>
                                <select name="type" id="type_add" class="form-select" required>
                                    <option value="">Select</option>
                                    <option value="1">Home</option>
                                    <option value="2">Success</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="heading_add" class="form-label">Heading <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="heading" id="heading_add" class="form-control"
                                    placeholder="Enter heading" required>
                            </div>

                            <div class="col-md-4">
                                <label for="subheading_add" class="form-label">Subheading <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="subheading" id="subheading_add" class="form-control"
                                    placeholder="Enter subheading" required>
                            </div>

                            <div class="col-md-4">
                                <label for="review_title_add" class="form-label">Review Title <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="review_title" id="review_title_add" class="form-control"
                                    placeholder="Enter review title" required>
                            </div>

                            <div class="col-md-4">
                                <label for="rating_add" class="form-label">Rating <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="rating" id="rating_add" class="form-control"
                                    placeholder="Enter rating" required>
                            </div>

                            <div class="col-md-4">
                                <label for="review_text_add" class="form-label">Review Text <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="review_text" id="review_text_add" class="form-control"
                                    placeholder="Enter review text" required>
                            </div>

                            <div class="col-md-4" id="button_text_wrapper_add">
                                <label for="button_text_add" class="form-label">Button Text</label>
                                <input type="text" name="button_text" id="button_text_add" class="form-control"
                                    placeholder="Enter button text">
                            </div>

                            <div class="col-md-4" id="button_url_wrapper_add">
                                <label for="button_url_add" class="form-label">Button URL</label>
                                <input type="url" name="button_url" id="button_url_add" class="form-control"
                                    placeholder="Enter button URL">
                            </div>

                            <div class="row" id="addImageContainer"></div>

                            <div class="col-12 mt-2">
                                <button type="button" class="btn btn-outline-primary btn-sm" id="addMoreAddImages">
                                    + Add Image
                                </button>
                            </div>

                            <div class="col-12">
                                <label for="description_add" class="form-label mt-2">Description <span
                                        class="text-danger">*</span></label>
                                <textarea name="description" id="description_add" class="form-control" rows="3"
                                    placeholder="Enter description" required></textarea>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editBannerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" enctype="multipart/form-data" id="editBannerForm">
                    @csrf
                    <input type="hidden" name="id" id="edit_banner_id">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Banner</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">

                            <div class="col-md-4">
                                <label for="edit_type" class="form-label">Type <span class="text-danger">*</span></label>
                                <select name="type" id="edit_type" class="form-select" required>
                                    <option value="">Select</option>
                                    <option value="1">Home</option>
                                    <option value="2">Success</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="edit_heading" class="form-label">Heading <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="heading" id="edit_heading" class="form-control"
                                    placeholder="Enter heading" required>
                            </div>

                            <div class="col-md-4">
                                <label for="edit_subheading" class="form-label">Subheading <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="subheading" id="edit_subheading" class="form-control"
                                    placeholder="Enter subheading" required>
                            </div>

                            <div class="col-md-4">
                                <label for="edit_review_title" class="form-label">Review Title <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="review_title" id="edit_review_title" class="form-control"
                                    placeholder="Enter review title" required>
                            </div>

                            <div class="col-md-4">
                                <label for="edit_rating" class="form-label">Rating <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="rating" id="edit_rating" class="form-control"
                                    placeholder="Enter rating" required>
                            </div>

                            <div class="col-md-4">
                                <label for="edit_review_text" class="form-label">Review Text <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="review_text" id="edit_review_text" class="form-control"
                                    placeholder="Enter review text" required>
                            </div>

                            <div class="col-md-4 d-none" id="edit_button_text_wrapper">
                                <label for="edit_button_text" class="form-label">Button Text</label>
                                <input type="text" name="button_text" id="edit_button_text" class="form-control"
                                    placeholder="Enter button text">
                            </div>

                            <div class="col-md-4 d-none" id="edit_button_url_wrapper">
                                <label for="edit_button_url" class="form-label">Button URL</label>
                                <input type="url" name="button_url" id="edit_button_url" class="form-control"
                                    placeholder="Enter button URL">
                            </div>

                            <div class="row" id="editImageContainer"></div>
                            <div class="col-12 mt-2">
                                <button type="button" class="btn btn-outline-primary btn-sm" id="addMoreEditImages">
                                    + Add Image
                                </button>
                            </div>

                            <div class="col-12 mt-3">
                                <label for="edit_description" class="form-label">Description <span
                                        class="text-danger">*</span></label>
                                <textarea name="description" id="edit_description" class="form-control" rows="3"
                                    placeholder="Enter description" required></textarea>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {

            // --- IMAGE INDEX TRACKING ---
            let addImageIndex = 0;
            let editImageIndex = 0;

            function toggleButtonFields(type, form = 'add') {
                type = type.toString();

                if (form === 'add') {
                    if (type === '2') {
                        $('#button_text_add').val('');
                        $('#button_url_add').val('');
                        $('#button_text_wrapper_add').addClass('d-none');
                        $('#button_url_wrapper_add').addClass('d-none');
                    } else {
                        $('#button_text_wrapper_add').removeClass('d-none');
                        $('#button_url_wrapper_add').removeClass('d-none');
                    }
                } else if (form === 'edit') {
                    if (type === '2') {
                        $('#edit_button_text').val('');
                        $('#edit_button_url').val('');
                        $('#edit_button_text_wrapper').addClass('d-none');
                        $('#edit_button_url_wrapper').addClass('d-none');
                    } else {
                        $('#edit_button_text_wrapper').removeClass('d-none');
                        $('#edit_button_url_wrapper').removeClass('d-none');
                    }
                }
            }


            // --- INITIAL STATE ON PAGE LOAD ---
            toggleButtonFields($('#type_add').val());

            // --- TYPE CHANGE EVENTS ---
            $('#type_add').on('change', function() {
                let val = $(this).val();
                console.log('Add type changed:', val);
                toggleButtonFields(val, 'add');
            });

            $('#edit_type').on('change', function() {
                let val = $(this).val();
                console.log('Edit type changed:', val);
                toggleButtonFields(val, 'edit');

                if (val === '2') {
                    $('#editImageContainer').html(`
                <div class="col-md-4 mb-3">
                    <label class="form-label">Image 1</label>
                    <input type="file" name="images[0]" class="form-control">
                </div>
            `);
                    editImageIndex = 1;
                }
            });

            // --- ADD IMAGE FIELDS ---
            $('#addMoreAddImages').on('click', function() {
                $('#addImageContainer').append(`
            <div class="col-md-4 mb-3">
                <label class="form-label">Image ${addImageIndex + 1}</label>
                <input type="file" name="images[${addImageIndex}]" class="form-control">
            </div>
        `);
                addImageIndex++;
            });

            $('#addMoreEditImages').on('click', function() {
                $('#editImageContainer').append(`
            <div class="col-md-4 mb-3">
                <label class="form-label">Image ${editImageIndex + 1}</label>
                <input type="file" name="images[${editImageIndex}]" class="form-control">
            </div>
        `);
                editImageIndex++;
            });

            // --- OPEN EDIT MODAL AND POPULATE DATA ---
            $(document).on('click', '.editBannerModal', function() {
                const id = $(this).data('id');

                $.ajax({
                    url: '/website_frontend/banner/edit/' + id,
                    type: 'GET',
                    success: function(response) {
                        // Fill form fields
                        $('#edit_banner_id').val(response.id);
                        $('#edit_heading').val(response.heading);
                        $('#edit_subheading').val(response.subheading);
                        $('#edit_description').val(response.description);
                        $('#edit_review_title').val(response.review_title);
                        $('#edit_rating').val(response.rating);
                        $('#edit_review_text').val(response.review_text);

                        // Set type first and toggle button fields
                        $('#edit_type').val(response.type);
                        toggleButtonFields(response.type, 'edit');

                        if (response.type !== '2') {
                            $('#edit_button_text').val(response.button_text);
                            $('#edit_button_url').val(response.button_url);
                        }

                        // Reset image container
                        $('#editImageContainer').empty();
                        editImageIndex = 0;

                        let images = response.images;
                        if (typeof images === 'string' && images.length > 0) {
                            images = [images];
                        } else if (!Array.isArray(images)) {
                            images = [];
                        }

                        if (response.type === '2') {
                            const imgPath = images.length > 0 ? images[0] : null;
                            $('#editImageContainer').append(`
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Image 1</label>
                            <input type="file" name="images[0]" class="form-control">
                            ${imgPath ? `<div class="mt-2"><img src="/${imgPath}" class="img-thumbnail" style="max-height: 100px;"></div>` : ''}
                        </div>
                    `);
                            editImageIndex = 1;
                        } else {
                            if (images.length > 0) {
                                images.forEach((imgPath, index) => {
                                    $('#editImageContainer').append(`
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Image ${index + 1}</label>
                                    <input type="file" name="images[${index}]" class="form-control">
                                    <div class="mt-2">
                                        <img src="/${imgPath}" class="img-thumbnail" style="max-height: 100px;">
                                    </div>
                                </div>
                            `);
                                    editImageIndex++;
                                });
                            } else {
                                $('#editImageContainer').append(`
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Image 1</label>
                                <input type="file" name="images[0]" class="form-control">
                            </div>
                        `);
                                editImageIndex = 1;
                            }
                        }

                        $('#editBannerForm').attr('action', '/website_frontend/banner/update/' +
                            id);


                        $('#editBannerModal').modal('show');
                    },
                    error: function() {
                        alert('Failed to fetch banner data.');
                    }
                });
            });

        });
    </script>
@endpush
