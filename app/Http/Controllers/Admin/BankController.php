<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\bank_detail;
use App\Models\students_instructor;
use App\Models\User;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $users = students_instructor::with('user')->get();


        return view('admin.account_details.index', compact('users'));
    }

    // Data for DataTable
    public function data(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'] ?? null;

        $query = bank_detail::with('studentInstructor');

        // Search filter
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('account_holder_name', 'like', "%{$searchValue}%")
                    ->orWhere('account_number', 'like', "%{$searchValue}%")
                    ->orWhere('ifsc_code', 'like', "%{$searchValue}%")
                    ->orWhere('bank_name', 'like', "%{$searchValue}%");
            });
        }

        $totalRecords = $query->count();
        $totalFiltered = (clone $query)->count();

        // Pagination
        if (is_numeric($length) && $length > 0) {
            $query->skip($start)->take($length);
        }

        $accounts = $query->orderBy('id', 'desc')->get();

        $data = [];
        $i = $start + 1;

        foreach ($accounts as $account) {
            $row = [];
            $row['DT_RowIndex'] = $i++;
            $row['user'] = $account->studentInstructor->user->name ?? '-';
            $row['account_holder_name'] = $account->account_holder_name;
            $row['account_number'] = $account->account_number;
            $row['ifsc_code'] = $account->ifsc_code;
            $row['bank_name'] = $account->bank_name;
            $row['status'] = $account->active ? 'Active' : 'Inactive';

            $editUrl = route('bank_account.edit', $account->id);
            $deleteUrl = route('bank_account.destroy', $account->id);

            $row['action'] = '
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item edit-account-btn" data-id="' . $account->id . '">
                                <i class="fas fa-edit text-primary me-1"></i> Edit
                            </a>
                        </li>
                        <li>
                            <form action="' . $deleteUrl . '" method="POST" style="margin:0;" id="delete-form-' . $account->id . '">
                                ' . csrf_field() . '
                                <button type="button" class="dropdown-item text-danger" onclick="confirmDelete(' . $account->id . ')">
                                    <i class="fas fa-trash-alt me-1"></i> Delete
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>';

            $data[] = $row;
        }

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ]);
    }

    // Store Bank Account
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'account_holder_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'ifsc_code' => 'required|string|max:20',
            'bank_name' => 'required|string|max:255',
        ]);

        bank_detail::create([
            'user_id' => $request->user_id,
            'account_holder_name' => $request->account_holder_name,
            'account_number' => $request->account_number,
            'ifsc_code' => $request->ifsc_code,
            'bank_name' => $request->bank_name,
            'active' => $request->active ?? 1,
        ]);

        return redirect()->back()->with('success', 'Bank account created successfully.');
    }

    // Get Bank Account for Edit (AJAX)
    public function edit($id)
    {
        $account =  bank_detail::with('studentInstructor')->findOrFail($id);
        return response()->json([
            'account' => $account,
            'user_name' => $account->studentInstructor->user_name ?? '' 
        ]);
    }

    // Update Bank Account
    public function update(Request $request, $id)
    {
        $account = bank_detail::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'account_holder_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'ifsc_code' => 'required|string|max:20',
            'bank_name' => 'required|string|max:255',
        ]);

        $account->update([
            'user_id' => $request->user_id,
            'account_holder_name' => $request->account_holder_name,
            'account_number' => $request->account_number,
            'ifsc_code' => $request->ifsc_code,
            'bank_name' => $request->bank_name,
            'active' => $request->active ?? 1,
        ]);

        return redirect()->back()->with('success', 'Bank account updated successfully.');
    }

    // Delete Bank Account
    public function destroy($id)
    {
        $account = bank_detail::findOrFail($id);
        $account->delete();

        return redirect()->back()->with('success', 'Bank account deleted successfully.');
    }
}
