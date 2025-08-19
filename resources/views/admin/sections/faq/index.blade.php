@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">FAQ List</h1>
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
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addContactModal">
                            + Add FAQ
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
                                        <th>Question</th>
                                        <th>Answer</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($faqs as $faq)
                                        <tr>
                                            <td>{{ $faq->question }}</td>
                                            <td>{{ $faq->answer }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary" type="button"
                                                        id="dropdownMenu{{ $faq->id }}" data-bs-toggle="dropdown"
                                                        aria-expanded="false" style="padding: 4px 8px; border-radius: 6px;">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end"
                                                        aria-labelledby="dropdownMenu{{ $faq->id }}">
                                                        <li>
                                                            <a href="javascript:void(0);" class="dropdown-item edit-btn"
                                                                data-id="{{ $faq->id }}" data-bs-toggle="modal"
                                                                data-bs-target="#editContactModal">
                                                                <i class="fas fa-edit text-primary me-2"></i> Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form id="delete-form-{{ $faq->id }}"
                                                                action="{{ route('web_pages.faq.destroy', $faq->id) }}"
                                                                method="POST" class="d-none">
                                                                @csrf
                                                            </form>
                                                            <a href="javascript:void(0);" class="dropdown-item text-danger"
                                                                onclick="confirmDelete({{ $faq->id }})">
                                                                <i class="fas fa-trash-alt me-2"></i> Delete
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No data found</td>
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
        <!-- Add Contact Modal -->
        <div class="modal fade" id="addContactModal" tabindex="-1" aria-labelledby="addContactModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('web_pages.faq.store') }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Faq</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="mb-3">
                                <label>Question</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Answer</label>
                                <input type="text" name="heading" class="form-control" required>
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
        <!-- Edit Contact Modal -->
        <div class="modal fade" id="editContactModal" tabindex="-1" aria-labelledby="editContactModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" id="editContactForm">
                    @csrf
                    <input type="hidden" name="id" id="edit_id" />
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit FAQ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="mb-3">
                                <label>Question</label>
                                <input type="text" name="title" id="edit_question" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Answer</label>
                                <input type="text" name="heading" id="edit_answer" class="form-control" required>
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
        $('.edit-btn').on('click', function() {
            let id = $(this).data('id');
            console.log(id);


            $.ajax({
                url: `/website_frontend/faq/edit/${id}`,
                method: "GET",
                success: function(res) {
                    if (res && res.faq) {
                        let faq = res.faq;

                        console.log(res.faq);

                        $('#edit_id').val(faq.id);
                        $('#edit_question').val(faq.question);
                        $('#edit_answer').val(faq.answer);
                       

                        $('#editContactForm').attr('action', '/website_frontend/faq/update/' + faq
                            .id);
                        $('#editContactModal').modal('show');
                    }
                },
                error: function() {
                    alert('Failed to fetch contact details.');
                }
            });
        });
    </script>
@endpush
