<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Transactions;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function edit($enrollmentId)
    {
        $enrollment = Enrollment::with(['course', 'student'])->findOrFail($enrollmentId);
        $transaction = Transactions::where('enrollment_id', $enrollmentId)->first();

        return response()->json([
            'enrollment' => $enrollment,
            'transaction' => $transaction,
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'enrollment_id' => 'required|exists:enrollment,id',
            'payment_method' => 'required|string',
            'transaction_reference' => 'nullable|string|max:255',
        ]);

        $transaction = Transactions::updateOrCreate(
            ['enrollment_id' => $request->enrollment_id],
            [
                'payment_mode' => $request->payment_method,
                'status' => 1
            ]
        );

        return redirect()->back()->with('success', 'Payment recorded successfully!');
    }
}
