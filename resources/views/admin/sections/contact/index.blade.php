@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Contact List</h1>
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
                            + Add Contact
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
                                        <th>Heading</th>
                                        <th>Description</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($contacts as $contact)
                                        <tr>
                                            <td>{{ $contact->title }}</td>
                                            <td>{{ $contact->heading }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit(strip_tags($contact->decription), 60) }}
                                            </td>
                                            <td>{{ $contact->address }}</td>
                                            <td>{{ $contact->phone }}</td>
                                            <td>{{ $contact->email_address }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary" type="button"
                                                        id="dropdownMenu{{ $contact->id }}" data-bs-toggle="dropdown"
                                                        aria-expanded="false" style="padding: 4px 8px; border-radius: 6px;">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end"
                                                        aria-labelledby="dropdownMenu{{ $contact->id }}">
                                                        <li>
                                                            <a href="javascript:void(0);" class="dropdown-item edit-btn"
                                                                data-id="{{ $contact->id }}" data-bs-toggle="modal"
                                                                data-bs-target="#editContactModal">
                                                                <i class="fas fa-edit text-primary me-2"></i> Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form id="delete-form-{{ $contact->id }}"
                                                                action="{{ route('web_pages.contact.destroy', $contact->id) }}"
                                                                method="POST" class="d-none">
                                                                @csrf
                                                            </form>
                                                            <a href="javascript:void(0);" class="dropdown-item text-danger"
                                                                onclick="confirmDelete({{ $contact->id }})">
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
                <form method="POST" action="{{ route('web_pages.contact.store') }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Contact</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="mb-3">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Heading</label>
                                <input type="text" name="heading" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Description</label>
                                <textarea name="decription" class="form-control" rows="4" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label>Address</label>
                                <input type="text" name="address" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email_address" class="form-control" required>
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
                            <h5 class="modal-title">Edit Contact</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="mb-3">
                                <label>Title</label>
                                <input type="text" name="title" id="edit_title" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Heading</label>
                                <input type="text" name="heading" id="edit_heading" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Description</label>
                                <textarea name="decription" id="edit_decription" class="form-control" rows="4" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label>Address</label>
                                <input type="text" name="address" id="edit_address" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Phone</label>
                                <input type="text" name="phone" id="edit_phone" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email_address" id="edit_email_address" class="form-control"
                                    required>
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
                url: `/website_frontend/contact/edit/${id}`,
                method: "GET",
                success: function(res) {
                    if (res && res.contact) {
                        let data = res.contact;

                        console.log(res.contact);

                        $('#edit_id').val(data.id);
                        $('#edit_title').val(data.title);
                        $('#edit_heading').val(data.heading);
                        $('#edit_decription').val(data.decription);
                        $('#edit_address').val(data.address);
                        $('#edit_phone').val(data.phone);
                        $('#edit_email_address').val(data.email_address);

                        $('#editContactForm').attr('action', '/website_frontend/contact/update/' + data
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
