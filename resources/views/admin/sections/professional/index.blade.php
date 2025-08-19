@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Professional List</h1>
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
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProfessionalModal">
                            + Add Professional
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
                                        <th>Description</th>
                                        <th>Button Text</th>
                                        <th>Button URL</th>
                                        <th width="150">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($professionals as $data)
                                        <tr data-id="{{ $data->id }}" data-name="{{ e($data['title'] ?? '') }}"
                                            data-description="{{ e($data['description'] ?? '') }}"
                                            data-button_text="{{ e($data['button'] ?? '') }}"
                                            data-button_url="{{ e($data['button_url'] ?? '') }}">
                                            <td>{{ $data['title'] ?? '-' }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit(strip_tags($data['description'] ?? '-'), 60) }}
                                            </td>
                                            <td>{{ $data['button'] ?? '-' }}</td>
                                            <td>{{ $data['button_url'] ?? '-' }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary" type="button"
                                                        id="dropdownMenu{{ $data->id }}" data-bs-toggle="dropdown"
                                                        aria-expanded="false" style="padding: 4px 8px; border-radius: 6px;">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end"
                                                        aria-labelledby="dropdownMenu{{ $data->id }}">
                                                        <li>
                                                            <a href="javascript:void(0);" class="dropdown-item edit-btn"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editProfessionalModal"
                                                                data-id="{{ $data->id }}">
                                                                <i class="fas fa-edit text-primary me-2"></i> Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form id="delete-form-{{ $data->id }}"
                                                                action="{{ route('web_pages.professional.destroy', $data->id) }}"
                                                                method="POST" class="d-none">
                                                                @csrf
                                                            </form>
                                                            <a href="javascript:void(0);" class="dropdown-item text-danger"
                                                                onclick="confirmDelete({{ $data->id }})">
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

        {{-- Modal for Add Professional --}}
        <div class="modal fade" id="addProfessionalModal" tabindex="-1" aria-labelledby="addProfessionalModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('web_pages.professional.store') }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Professional</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="mb-3">
                                <label>Title <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Description <span class="text-danger">*</span></label>
                                <textarea name="description" class="form-control" rows="4" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label>Button Text</label>
                                <input type="text" name="button_text" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label>Button URL</label>
                                <input type="url" name="button_url" class="form-control"
                                    placeholder="https://example.com">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal for Edit Professional --}}
        <div class="modal fade" id="editProfessionalModal" tabindex="-1" aria-labelledby="editProfessionalModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" id="editProfessionalForm">
                    @csrf
                    <input type="hidden" name="id" id="edit_id" />
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Professional</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="mb-3">
                                <label>Title <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="edit_name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Description <span class="text-danger">*</span></label>
                                <textarea name="description" id="edit_description" class="form-control" rows="4" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label>Button Text</label>
                                <input type="text" name="button_text" id="edit_button_text" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label>Button URL</label>
                                <input type="url" name="button_url" id="edit_button_url" class="form-control"
                                    placeholder="https://example.com">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Update</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Attach click event for Edit buttons
            const editButtons = document.querySelectorAll('.edit-btn');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const tr = this.closest('tr');
                    document.getElementById('edit_id').value = this.getAttribute('data-id');
                    document.getElementById('edit_name').value = tr.getAttribute('data-title');
                    document.getElementById('edit_description').value = tr.getAttribute(
                        'data-description');
                    document.getElementById('edit_button_text').value = tr.getAttribute(
                        'data-button');
                    document.getElementById('edit_button_url').value = tr.getAttribute(
                        'data-button_url');
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.edit-btn');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const tr = this.closest('tr');
                    const id = this.getAttribute('data-id');

                    // Set form fields
                    document.getElementById('edit_id').value = id;
                    document.getElementById('edit_name').value = tr.getAttribute('data-name') || '';
                    document.getElementById('edit_description').value = tr.getAttribute(
                        'data-description') || '';
                    document.getElementById('edit_button_text').value = tr.getAttribute(
                        'data-button_text') || '';
                    document.getElementById('edit_button_url').value = tr.getAttribute(
                        'data-button_url') || '';

                    // Dynamically set form action
                    document.getElementById('editProfessionalForm').setAttribute('action',
                        `/website_frontend/professional/update/${id}`);
                });
            });
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to undo this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endpush
