@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Why Choose Us</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Tables</a></li>
                        <li class="breadcrumb-item active">Why Choose Us</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWhyChooseUsModal">
                    Add About
                </button>
            </div>
        </div>

        <div class="card custom-card">
            <div class="card-body table-responsive">
                <table class="table table-bordered" id="whyChooseUsTable">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th> Image</th>
                            <th>Icon</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                            <tr id="row-{{ $item->id }}">

                                <td>{{ $item->title }}</td>
                                <td>{!! \Illuminate\Support\Str::limit(strip_tags($item->description), 100) !!}</td>
                                <td>
                                    @if ($item->main_image)
                                        <img src="{{ asset($item->main_image) }}" alt="Main Image" style="max-height:50px;">
                                    @endif
                                </td>
                                <td>
                                    @if ($item->icon)
                                        <img src="{{ asset($item->icon) }}" alt="Icon" style="max-height:30px;">
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
                                                <button class="dropdown-item btn-edit" data-id="{{ $item->id }}">
                                                    <i class="fas fa-edit text-primary me-2"></i> Edit
                                                </button>
                                            </li>
                                            <li>
                                                <form id="delete-form-{{ $item->id }}"
                                                    action="{{ route('web_pages.why_choose_us.destroy', $item->id) }}" method="POST"
                                                    class="d-none">
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
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No Data found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Add Modal --}}
    <div class="modal fade" id="addWhyChooseUsModal" tabindex="-1" aria-labelledby="addWhyChooseUsLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <form id="addWhyChooseUsForm" method="POST" action="{{ route('web_pages.why_choose_us.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Why Choose Us</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="add_title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" id="add_title" name="title" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="add_description" class="form-label">Description</label>
                            <textarea id="add_description" name="description" rows="3" class="form-control"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="add_main_image" class="form-label">Main Image</label>
                            <input type="file" id="add_main_image" name="main_image" class="form-control"
                                accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label for="add_icon" class="form-label">Icon Image</label>
                            <input type="file" id="add_icon" name="icon" class="form-control" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Benefits</label>
                            <div id="add_list_items_editor" style="height: 150px;"></div>
                            <input type="hidden" name="list_items" id="add_list_items">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Choose Us</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="editWhyChooseUsModal" tabindex="-1" aria-labelledby="editWhyChooseUsLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <form id="editWhyChooseUsForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Why Choose Us</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" id="edit_title" name="title" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea id="edit_description" name="description" rows="3" class="form-control"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="edit_main_image" class="form-label">Current Main Image</label>
                            <div class="mb-2">
                                <img id="edit_current_main_image" src="" alt="Main Image"
                                    style="max-height: 100px; display:none;">
                            </div>
                            <input type="file" id="edit_main_image" name="main_image" class="form-control"
                                accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label for="edit_icon" class="form-label">Current Icon Image</label>
                            <div class="mb-2">
                                <img id="edit_current_icon" src="" alt="Icon Image"
                                    style="max-height: 50px; display:none;">
                            </div>
                            <input type="file" id="edit_icon" name="icon" class="form-control" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Benefits</label>
                            <div id="edit_list_items_editor" style="height: 150px;"></div>
                            <input type="hidden" name="list_items" id="edit_list_items">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Choose Us</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

<script src="{{ asset('admin/assets/libs/quill/quill.min.js') }}"></script>

@push('script')
    <script>
        $(document).ready(function() {
            // Initialize Quill editors
            let addListQuill = new Quill('#add_list_items_editor', {
                theme: 'snow',
                placeholder: 'Enter benefits...',
                modules: {
                    toolbar: [
                        ['bold', 'italic'],
                        [{
                            'list': 'bullet'
                        }, {
                            'list': 'ordered'
                        }]
                    ]
                }
            });

            let editListQuill = new Quill('#edit_list_items_editor', {
                theme: 'snow',
                placeholder: 'Edit benefits...',
                modules: {
                    toolbar: [
                        ['bold', 'italic'],
                        [{
                            'list': 'bullet'
                        }, {
                            'list': 'ordered'
                        }]
                    ]
                }
            });

            // Submit handlers: set hidden input values from Quill HTML
            $('#addWhyChooseUsForm').on('submit', function() {
                $('#add_list_items').val(addListQuill.root.innerHTML);
            });

            $('#editWhyChooseUsForm').on('submit', function() {
                $('#edit_list_items').val(editListQuill.root.innerHTML);
            });

            // Edit button click
            $('.btn-edit').click(function() {
                let id = $(this).data('id');
                $.ajax({
                    url: "{{ url('website_frontend/why_choose_us/edit') }}/" + id,
                    method: "GET",
                    success: function(res) {
                        if (res.status) {
                            let data = res.data;
                            $('#edit_id').val(data.id);
                            $('#edit_title').val(data.title);
                            $('#edit_description').val(data.description);

                            // Show main image if exists
                            if (data.main_image) {
                                $('#edit_current_main_image')
                                    .attr('src', "{{ asset('') }}" + data.main_image)
                                    .show();
                            } else {
                                $('#edit_current_main_image').hide();
                            }

                            // Show icon image if exists
                            if (data.icon) {
                                $('#edit_current_icon')
                                    .attr('src', "{{ asset('') }}" + data.icon)
                                    .show();
                            } else {
                                $('#edit_current_icon').hide();
                            }

                            // Set Quill editor content for list_items or empty string
                            editListQuill.root.innerHTML = data.list_items || '';

                            // Set form action dynamically
                            $('#editWhyChooseUsForm').attr('action',
                                "{{ url('website_frontend/why_choose_us/update') }}/" + id);

                            // Show modal
                            $('#editWhyChooseUsModal').modal('show');
                        } else {
                            alert('Failed to fetch data');
                        }
                    },
                    error: function() {
                        alert('Error fetching data');
                    }
                });
            });

            // Delete button click
            $('.btn-delete').click(function() {
                let id = $(this).data('id');
                if (confirm('Are you sure you want to delete this entry?')) {
                    $.ajax({
                        url: "{{ url('website_frontend/why_choose_us/destroy') }}/" + id,
                        method: "POST",
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            if (res.status) {
                                $('#row-' + id).remove();
                                alert(res.message);
                            } else {
                                alert('Failed to delete');
                            }
                        },
                        error: function() {
                            alert('Error deleting entry');
                        }
                    });
                }
            });
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This record will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById(`delete-form-${id}`);
                    if (form) form.submit();
                }
            });
        }
    </script>
@endpush
