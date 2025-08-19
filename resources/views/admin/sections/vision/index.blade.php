@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Vision List</h1>
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

                    <div class="d-flex justify-content-end mb-3">
                        <button type="button" id="btnAddVision" class="btn btn-primary">+ Add Vision</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Icon</th>
                                        <th>Heading</th>
                                        <th>Description</th>
                                        <th style="width: 130px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $hasData = false; @endphp
                                    @foreach ($visions as $vision)
                                        @if (!empty($vision->heading) || !empty($vision->description) || !empty($vision->icon))
                                            @php $hasData = true; @endphp
                                            <tr data-id="{{ $vision->id }}">
                                                <td>
                                                    @if (!empty($vision->icon))
                                                        <img src="{{ asset($vision->icon) }}" alt="Icon"
                                                            style="height: 50px;">
                                                    @endif
                                                </td>
                                                <td>{{ $vision->heading }}</td>
                                                <td>{{ \Illuminate\Support\Str::limit(strip_tags($vision->description), 50) }}
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false"
                                                            style="padding: 0.25rem 0.5rem;">
                                                            <!-- SVG icon -->
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="javascript:void(0);"
                                                                    class="dropdown-item btnEditVision"
                                                                    data-id="{{ $vision->id }}"
                                                                    data-icon="{{ $vision->icon }}"
                                                                    data-heading="{{ $vision->heading }}"
                                                                    data-description="{{ $vision->description }}">
                                                                    <i class="fas fa-edit text-primary me-1"></i> Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <form
                                                                    action="{{ route('web_pages.vision.destroy', $vision->id) }}"
                                                                    method="POST" style="margin:0;">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="dropdown-item text-danger btnDeleteVision">
                                                                        <i class="fas fa-trash-alt me-1"></i> Delete
                                                                    </button>

                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach

                                    @unless ($hasData)
                                        <tr>
                                            <td colspan="4" class="text-center">No Data found</td>
                                        </tr>
                                    @endunless
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Vision Modal -->
        <div class="modal fade" id="addVisionModal" tabindex="-1" aria-labelledby="addVisionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('web_pages.vision.store') }}" method="POST" enctype="multipart/form-data"
                    id="addVisionForm">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addVisionModalLabel">Add Vision</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="add_icon" class="form-label">Icon Image<span
                                            class="text-danger">*</span></label>
                                <input type="file" id="add_icon" name="icon" class="form-control" accept="image/*" required>
                            </div>

                            <div class="mb-3">
                                <label for="add_heading" class="form-label">Heading <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="add_heading" name="heading" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="add_description" class="form-label">Description<span
                                            class="text-danger">*</span></label>
                                <textarea id="add_description" name="description" rows="4" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add Vision</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Vision Modal -->
        <div class="modal fade" id="editVisionModal" tabindex="-1" aria-labelledby="editVisionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form action="" method="POST" enctype="multipart/form-data" id="editVisionForm">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editVisionModalLabel">Edit Vision</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="vision_id" id="edit_vision_id">

                            <div class="mb-3">
                                <label for="edit_icon" class="form-label">Icon Image</label>
                                <input type="file" id="edit_icon" name="icon" class="form-control" 
                                    accept="image/*">
                                <div id="editCurrentIcon" class="mt-2"></div>
                            </div>

                            <div class="mb-3">
                                <label for="edit_heading" class="form-label">Heading <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="edit_heading" name="heading" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_description" class="form-label">Description<span
                                            class="text-danger">*</span></label>
                                <textarea id="edit_description" name="description" rows="4" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Update Vision</button>
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
            const addModal = new bootstrap.Modal(document.getElementById('addVisionModal'));
            const editModal = new bootstrap.Modal(document.getElementById('editVisionModal'));

            document.getElementById('btnAddVision').addEventListener('click', () => {
                document.getElementById('addVisionForm').reset();
                addModal.show();
            });

            document.querySelectorAll('.btnEditVision').forEach(button => {
                button.addEventListener('click', () => {
                    const visionId = button.dataset.id;
                    const icon = button.dataset.icon;
                    const heading = button.dataset.heading;
                    const description = button.dataset.description;

                    const editForm = document.getElementById('editVisionForm');
                    editForm.action = "{{ url('website_frontend/vision/update') }}/" + visionId;

                    document.getElementById('edit_vision_id').value = visionId;
                    document.getElementById('edit_heading').value = heading || '';
                    document.getElementById('edit_description').value = description || '';

                    if (icon) {
                        document.getElementById('editCurrentIcon').innerHTML =
                            `<img src="{{ asset('') }}${icon}" style="height: 100px;">`;
                    } else {
                        document.getElementById('editCurrentIcon').innerHTML = '';
                    }

                    editModal.show();
                });
            });

            // SweetAlert Delete Confirmation
            document.querySelectorAll('.btnDeleteVision').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.closest('form').submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush

