@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Bank Account List</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Tables</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Bank Accounts</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="javascript:void(0);" class="btn btn-primary btn-wave d-flex align-items-center gap-2"
                    data-bs-toggle="modal" data-bs-target="#addAccountModal">
                    <i class="fas fa-plus"></i> Add Account
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table id="account-table" class="table table-bordered w-100">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Account Holder Name</th>
                            <th>Account Number</th>
                            <th>IFSC Code</th>
                            <th>Bank Name</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Bank Account Modal -->
    <div class="modal fade" id="addAccountModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form action="{{ route('bank_account.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Bank Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">

                            <div class="col-md-12">
                                <label>User</label>
                                <select name="user_id" class="form-select" required>
                                    <option value="">-- Select User --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->user->name }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Account Holder Name</label>
                                <input type="text" name="account_holder_name" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label>Account Number</label>
                                <input type="text" name="account_number" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label>IFSC Code</label>
                                <input type="text" name="ifsc_code" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label>Bank Name</label>
                                <input type="text" name="bank_name" class="form-control" required>
                            </div>

                            <div class="col-md-12">
                                <label>Status</label>
                                <select name="active" class="form-select">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Account</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Bank Account Modal -->
    <div class="modal fade" id="editAccountModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <form method="POST" id="editAccountForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Bank Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <input type="hidden" name="id" id="editAccountId">

                            <div class="col-md-12">
                                <label>User</label>
                                <select name="user_id" id="editUserId" class="form-select" required>
                                    <option value="">-- Select User --</option>
                                    @foreach ($users as $studentInstructor)
                                        <option value="{{ $studentInstructor->id }}">
                                            {{ $studentInstructor->user->name ?? 'No Name' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="col-md-6">
                                <label>Account Holder Name</label>
                                <input type="text" name="account_holder_name" id="editAccountHolderName"
                                    class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label>Account Number</label>
                                <input type="text" name="account_number" id="editAccountNumber" class="form-control"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label>IFSC Code</label>
                                <input type="text" name="ifsc_code" id="editIFSC" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label>Bank Name</label>
                                <input type="text" name="bank_name" id="editBankName" class="form-control" required>
                            </div>

                            <div class="col-md-12">
                                <label>Status</label>
                                <select name="active" id="editStatus" class="form-select">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Account</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {

            // Open Edit Account modal & populate fields
            $(document).on('click', '.edit-account-btn', function() {
                let id = $(this).data('id');
                $.get("{{ url('bank_account/edit') }}/" + id, function(response) {
                    if (response.account) {
                        const a = response.account;

                        $('#editUserId').val(a.user_id).trigger('change');
                        $('#editAccountHolderName').val(a.account_holder_name);
                        $('#editAccountNumber').val(a.account_number);
                        $('#editIFSC').val(a.ifsc_code);
                        $('#editBankName').val(a.bank_name);
                        $('#editStatus').val(a.active);

                        $('#editAccountForm').attr('action', "{{ url('bank_account/update') }}/" +
                            id);
                        $('#editAccountModal').modal('show');
                    }
                });
            });

            $('#account-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('bank_account.data') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'user',
                        name: 'user'
                    },
                    {
                        data: 'account_holder_name',
                        name: 'account_holder_name'
                    },
                    {
                        data: 'account_number',
                        name: 'account_number'
                    },
                    {
                        data: 'ifsc_code',
                        name: 'ifsc_code'
                    },
                    {
                        data: 'bank_name',
                        name: 'bank_name'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    searchPlaceholder: "Search bank accounts...",
                    search: ""
                }
            });

        });
    </script>
@endpush
