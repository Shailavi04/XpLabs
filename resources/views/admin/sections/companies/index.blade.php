@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Companies List</h1>
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
                            + Add Companies
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
                                        <th>Slug</th>
                                        <th>Logo</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($companies as $company)
                                        <tr>
                                            <td>{{ $company->title }}</td>
                                            <td>{{ $company->page }}</td>
                                            <td>
                                                @if ($company->company_images)
                                                    @php $images = json_decode($company->company_images, true); @endphp

                                                    @if (is_array($images))
                                                        @foreach ($images as $img)
                                                            <img src="{{ asset('uploads/companies/' . $img) }}"
                                                                alt="" width="80" height="40"
                                                                class="me-1 mb-1">
                                                        @endforeach
                                                    @else
                                                        <img src="{{ asset('uploads/companies/' . $images) }}"
                                                            alt="" width="80" height="40">
                                                    @endif
                                                @else
                                                    No Image
                                                @endif
                                            </td>

                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary" type="button"
                                                        id="dropdownMenu{{ $company->id }}" data-bs-toggle="dropdown"
                                                        aria-expanded="false" style="padding: 4px 8px; border-radius: 6px;">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end"
                                                        aria-labelledby="dropdownMenu{{ $company->id }}">
                                                        <li>
                                                            <a href="javascript:void(0);" class="dropdown-item edit-btn"
                                                                data-id="{{ $company->id }}"
                                                                data-page="{{ $company->page }}"
                                                                data-title="{{ $company->title }}" data-bs-toggle="modal"
                                                                data-bs-target="#editCompanyModal">
                                                                <i class="fas fa-edit text-primary me-2"></i> Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form id="delete-form-{{ $company->id }}"
                                                                action="{{ route('web_pages.companies.destroy', $company->id) }}"
                                                                method="POST" class="d-none">
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
                                            <td colspan="3" class="text-center">No company entries found.</td>
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
                <form action="{{ route('web_pages.companies.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Company</h5>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Select page</label>

                                <select name="page" required class="form-control">
                                    <option value="home">Home</option>
                                    <option value="course">Course</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Logo</label>
                                <input type="file" name="company_images[]" class="form-control" multiple required>
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
                            <h5 class="modal-title">Edit Company</h5>
                        </div>
                        <div class="modal-body">

                            <div class="mb-3">
                                <label>Select page</label>
                                <select name="page" id="edit_page" class="form-control" required>
                                    <option value="home">Home</option>
                                    <option value="course">Course</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Title</label>
                                <input type="text" name="title" id="edit_title" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Logo </label>
                                <input type="file" name="company_images[]" class="form-control" multiple>
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
        $('.edit-btn').on('click', function() {
            let id = $(this).data('id');
            let title = $(this).data('title');
            let page = $(this).data('page');


            $('#edit_id').val(id);
            $('#edit_title').val(title);
            $('#edit_page').val(page);
            $('#editCompanyForm').attr('action', '/website_frontend/companies/update/' + id);


        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
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
