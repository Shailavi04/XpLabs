@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">About Section List</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active">About</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAboutUsModal">+ Add
                    Section</button>
            </div>
        </div>

        {{-- Table --}}
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="aboutUsTable">
                                <thead>
                                    <tr>
                                        <th>Heading</th>
                                        <th>Sub Heading</th>
                                        <th>Description</th>
                                        <th>Image</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($abouts as $about)
                                        <tr id="about-row-{{ $about->id }}">
                                            <td>{{ $about->heading }}</td>
                                            <td>{{ $about->sub_heading ?? '-' }}</td>
                                            <td>{!! \Illuminate\Support\Str::limit(strip_tags($about->description), 100) !!}</td>
                                            <td>
                                                @if ($about->main_image)
                                                    <img src="{{ asset($about->main_image) }}" alt="Image"
                                                        style="max-height: 50px;">
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                        data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <button class="dropdown-item btn-edit"
                                                                data-id="{{ $about->id }}">
                                                                <i class="fas fa-edit text-primary me-1"></i>Edit
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item btn-delete"
                                                                data-id="{{ $about->id }}">
                                                                <i class="fas fa-trash-alt me-2"></i>Delete
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No data found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Include Modal for Add and Edit --}}
        {{-- Add Modal --}}
        <div class="modal fade" id="addAboutUsModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <form method="POST" action="{{ route('web_pages.about_us.store') }}" enctype="multipart/form-data"
                    id="addAboutUsForm">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add About Section</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Heading <span class="text-danger">*</span></label>
                                <input type="text" name="heading" class="form-control" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Sub Heading</label>
                                <input type="text" name="sub_heading" class="form-control">
                            </div>
                            <div class="mb-3 col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" rows="4" class="form-control"></textarea>
                            </div>
                            <div class="mb-3 col-12">
                                <label class="form-label">Upload Image</label>
                                <input type="file" name="main_image" accept="image/*" class="form-control">
                            </div>

                            <hr>
                            <div id="addCardsContainer" class="row g-3"></div>
                            <button type="button" id="addCardBtn" class="btn btn-sm btn-secondary mt-2">+ Add Card</button>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Edit Modal --}}
        <div class="modal fade" id="editAboutUsModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <form method="POST" enctype="multipart/form-data" id="editAboutUsForm">
                    @csrf
                    <input type="hidden" name="id" id="edit_id">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit About Section</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Heading <span class="text-danger">*</span></label>
                                <input type="text" name="heading" id="edit_heading" class="form-control" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Sub Heading</label>
                                <input type="text" name="sub_heading" id="edit_sub_heading" class="form-control">
                            </div>
                            <div class="mb-3 col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" id="edit_description" rows="4" class="form-control"></textarea>
                            </div>
                            <div class="mb-3 col-12">
                                <label class="form-label">Upload Image</label>
                                <input type="file" name="main_image" id="edit_main_image" accept="image/*"
                                    class="form-control">
                                <img id="currentMainImage" style="max-height: 120px; margin-top: 10px; display: none;">
                            </div>

                            <hr>
                            <div id="editCardsContainer" class="row g-3"></div>
                            <button type="button" id="editAddCardBtn" class="btn btn-sm btn-secondary mt-2">+ Add
                                Card</button>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
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
        function createCardRow(index, card = {}) {
            return `
            <div class="row mb-3 card-row" data-index="${index}">
                <div class="col-md-10">
                    <div class="mb-2">
                        <label class="form-label">Icon Title</label>
                        <input type="text" name="cards[${index}][icon_text]" class="form-control" value="${card.icon_text || ''}">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Icon Description</label>
                        <textarea name="cards[${index}][icon_description]" class="form-control" rows="2">${card.icon_description || ''}</textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Icon Image</label>
                        <input type="file" name="cards[${index}][icon]" accept="image/*" class="form-control">
                        ${card.icon ? `<img src="{{ asset('') }}${card.icon}" style="max-height: 50px; margin-top: 5px;">` : ''}
                    </div>
                </div>
                <div class="col-auto d-flex align-items-center">
                    <button type="button" class="btn btn-danger btn-sm remove-card-btn">Remove</button>
                </div>
            </div>`;
        }

        $(function() {
            let addCardCount = 0;
            let editCardCount = 0;

            $('#addCardBtn').click(function() {
                $('#addCardsContainer').append(createCardRow(addCardCount));
                addCardCount++;
            });

            $('#addCardsContainer').on('click', '.remove-card-btn', function() {
                $(this).closest('.card-row').remove();
            });

            $('#editAddCardBtn').click(function() {
                $('#editCardsContainer').append(createCardRow(editCardCount));
                editCardCount++;
            });

            $('#editCardsContainer').on('click', '.remove-card-btn', function() {
                $(this).closest('.card-row').remove();
            });

            $('.btn-edit').click(function() {
                const id = $(this).data('id');
                $.get(`{{ url('website_frontend/about_us/edit') }}/${id}`, function(res) {
                    if (res.status) {
                        $('#edit_id').val(res.data.id);
                        $('#edit_heading').val(res.data.heading);
                        $('#edit_sub_heading').val(res.data.sub_heading);
                        $('#edit_description').val(res.data.description || '');
                        $('#currentMainImage').hide();

                        if (res.data.main_image) {
                            $('#currentMainImage').attr('src', '{{ asset('') }}' + res.data
                                .main_image).show();
                        }

                        $('#editCardsContainer').empty();
                        editCardCount = 0;

                        if (Array.isArray(res.data.cards)) {
                            res.data.cards.forEach(card => {
                                $('#editCardsContainer').append(createCardRow(editCardCount,
                                    card));
                                editCardCount++;
                            });
                        }

                        $('#editAboutUsForm').attr('action',
                            `{{ url('website_frontend/about_us/update') }}/${id}`);
                        $('#editAboutUsModal').modal('show');
                    }
                });
            });

            $('.btn-delete').click(function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You cannot undo this action!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then(result => {
                    if (result.isConfirmed) {
                        $.post(`{{ url('website_frontend/about_us/destroy') }}/${id}`, {
                            _token: '{{ csrf_token() }}'
                        }, function(res) {
                            if (res.status) {
                                $('#about-row-' + id).remove();
                                Swal.fire('Deleted!', res.message, 'success');
                            } else {
                                Swal.fire('Error!', res.message || 'Failed to delete.',
                                    'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
