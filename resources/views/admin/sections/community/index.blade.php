@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Community List</h1>
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
                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">Yesterday</a></li>
                            <li><a class="dropdown-item" href="#">Last 7 Days</a></li>
                            <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                            <li><a class="dropdown-item" href="#">Last 6 Months</a></li>
                            <li><a class="dropdown-item" href="#">Last Year</a></li>
                        </ul>
                    </div>
                    <div class="d-flex justify-content-end mb-3">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCompanyModal">
                            + Add Community
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Listing Table --}}
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Background Image</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($join_our_community as $join)
                                        <tr>
                                            <td>{{ $join->title }}</td>
                                            <td>{{ $join->description }}</td>
                                            <td>
                                                @if ($join->background_image)
                                                    <img src="{{ asset('/' . $join->background_image) }}" alt="Logo"
                                                        height="40">
                                                @else
                                                    No Image
                                                @endif

                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary" type="button"
                                                        id="dropdownMenu{{ $join->id }}" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end"
                                                        aria-labelledby="dropdownMenu{{ $join->id }}">
                                                        <li>
                                                            <a href="javascript:void(0);" class="dropdown-item edit-btn"
                                                                data-id="{{ $join->id }}"
                                                                data-title="{{ $join->title }}"
                                                                data-description="{{ $join->description }}"
                                                                data-bs-toggle="modal" data-bs-target="#editCompanyModal">
                                                                <i class="fas fa-edit text-primary me-2"></i> Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form id="delete-form-{{ $join->id }}"
                                                                action="{{ route('web_pages.community.destroy', $join->id) }}"
                                                                method="POST" class="d-none">
                                                                @csrf
                                                            </form>
                                                            <a href="javascript:void(0);" class="dropdown-item text-danger"
                                                                onclick="confirmDelete({{ $join->id }})">
                                                                <i class="fas fa-trash-alt me-2"></i> Delete
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No entries found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Add Modal --}}
        <div class="modal fade" id="addCompanyModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('web_pages.community.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Community</h5>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>

                            <div class="mb-3 col-12">
                                <label for="description">Description</label>
                                <textarea name="description" rows="4" class="form-control"></textarea>
                            </div>

                            <div class="mb-3">
                                <label>Background image</label>
                                <input type="file" name="image" class="form-control" required>
                            </div>

                            {{-- Dynamic Cards --}}
                            <div class="mb-3">
                                <label>Cards</label>
                                <div id="card-wrapper"></div>
                                <button type="button" class="btn btn-sm btn-secondary mt-2" id="add-card-btn">+ Add
                                    Card</button>
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

        <div class="modal fade" id="editCompanyModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" id="editCompanyForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="edit_id">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Community</h5>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Title</label>
                                <input type="text" name="title" id="edit_title" class="form-control" required>
                            </div>

                            <div class="mb-3 col-12">
                                <label for="edit_description">Description</label>
                                <textarea name="description" id="edit_description" rows="4" class="form-control"></textarea>
                            </div>

                            <div class="mb-3">
                                <label>Background image</label>
                                <input type="file" name="image" class="form-control">
                            </div>

                            {{-- Dynamic Cards Edit --}}
                            <div class="mb-3">
                                <label>Cards</label>
                                <div id="edit-card-wrapper"></div>
                                <button type="button" class="btn btn-sm btn-secondary mt-2" id="edit-add-card-btn">+ Add
                                </button>
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
    </div>
@endsection

@push('script')
    <script>
        let cardIndex = 0;

        $(document).on('click', '.remove-card-btn', function() {
            $(this).closest('.card-input-group').remove();
        });

        $('#edit-add-card-btn').on('click', function() {
            $('#edit-card-wrapper').append(`
        <div class="d-flex gap-2 mb-2 card-input-group">
            <input type="text" name="edit_cards[${cardIndex}][title]" class="form-control" placeholder="Card Title" required>
            <input type="number" name="edit_cards[${cardIndex}][count]" class="form-control" placeholder="Count" required>
            <button type="button" class="btn btn-danger btn-sm remove-card-btn">x</button>
        </div>
    `);
            cardIndex++;
        });


        $('.edit-btn').on('click', function() {

            let id = $(this).data('id');
            let title = $(this).data('title');
            let desc = $(this).data('description');

            $('#edit_id').val(id);
            $('#edit_title').val(title);
            $('#edit_description').val(desc);
            $('#editCompanyForm').attr('action', `/website_frontend/community/update/${id}`);

            $('#edit-card-wrapper').html('');
            cardIndex = 0;

            $.get(`/website_frontend/community/edit/${id}`, function(res) {
                console.log("AJAX response cards:", res.cards); // Debug line

                if (res.cards && Array.isArray(res.cards) && res.cards.length > 0) {
                    res.cards.forEach((card) => {
                        $('#edit-card-wrapper').append(`
                    <div class="d-flex gap-2 mb-2 card-input-group">
                        <input type="text" name="edit_cards[${cardIndex}][title]" class="form-control" value="${card.title}" placeholder="Card Title" required>
                        <input type="number" name="edit_cards[${cardIndex}][count]" class="form-control" value="${card.count}" placeholder="Count" required>
                        <button type="button" class="btn btn-danger btn-sm remove-card-btn">x</button>
                    </div>
                `);
                        cardIndex++;
                    });
                } else {
                    // No cards returned, optionally add one empty input
                    $('#edit-card-wrapper').append(`
                <div class="d-flex gap-2 mb-2 card-input-group">
                    <input type="text" name="edit_cards[${cardIndex}][title]" class="form-control" placeholder="Card Title" required>
                    <input type="number" name="edit_cards[${cardIndex}][count]" class="form-control" placeholder="Count" required>
                    <button type="button" class="btn btn-danger btn-sm remove-card-btn">x</button>
                </div>
            `);
                    cardIndex++;
                }
            });
        });
    </script>
@endpush
