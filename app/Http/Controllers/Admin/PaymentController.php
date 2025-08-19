<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    //
    public function index()
    {
        // Just return view for payment list
        return view('admin.payment.index'); // Adjust view path as needed
    }
    public function data(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start', 0);
        $length = $request->get('length', 10);
        $searchValue = $request->get('search')['value'] ?? null;

        // Query joining transactions with payments, enrollments, students, and courses
        $query = DB::table('transactions')
            ->join('payments', 'transactions.payment_id', '=', 'payments.id')
            ->join('enrollment', 'payments.enrollment_id', '=', 'enrollment.enrollment_id')
            ->join('students', 'enrollment.student_id', '=', 'students.id')
            ->join('users', 'users.id', '=', 'students.user_id')
            ->join('courses', 'enrollment.course_id', '=', 'courses.id')
            ->select(
                'transactions.*',
                'payments.total_fee',
                'payments.amount_paid',
                'payments.status as payment_status',
                'payments.id as payment_id',
                'payments.enrollment_id',
                'users.name as student_name',
                'courses.name as course_name'
            );

        // dd($query->get());

        // Apply search filter
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('enrollment.enrollment_id', 'like', "%{$searchValue}%")
                    ->orWhere('students.name', 'like', "%{$searchValue}%")
                    ->orWhere('courses.name', 'like', "%{$searchValue}%")
                    ->orWhere('transactions.transaction_id', 'like', "%{$searchValue}%");
            });
        }

        $totalRecords = (clone $query)->count();

        if (is_numeric($length) && $length > 0) {
            $query->skip($start)->take($length);
        }

        $transactions = $query->orderBy('transactions.created_at', 'desc')->get();

        $data = [];
        $index = $start + 1;

        foreach ($transactions as $trx) {
            $statusText = match ($trx->payment_status) {
                1 => '<span class="badge bg-success">Paid</span>',
                3 => '<span class="badge bg-danger">Cancelled</span>',
                2 => '<span class="badge bg-info">Partial</span>',
                default => '<span class="badge bg-secondary">Unknown</span>',
            };

            $data[] = [
                'DT_RowIndex'     => $index++,
                'enrollment_id'   => $trx->enrollment_id ?? '-',
                'student_name'    => $trx->student_name ?? '-',
                'course_name'     => $trx->course_name ?? '-',
                'total_fee'       => number_format($trx->total_fee, 2),
                'amount_paid'     => number_format($trx->amount, 2), // This transaction amount
                'transaction_id'  => $trx->transaction_id ?? '-',
                'payment_date'    => $trx->payment_date ?? '-',
                'status'          => $statusText,

            ];
        }

        return response()->json([
            'draw'            => intval($draw),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data'            => $data,
        ]);
    }

    public function fetchEnrollment(Request $request)
    {
        $enrollment = Enrollment::with(['student', 'course'])
            ->where('enrollment_id', $request->enrollment_id)
            ->first();

        if (!$enrollment) {
            return response()->json(['success' => false, 'message' => 'Enrollment not found.']);
        }

        $amountPaid = DB::table('payments')
            ->where('enrollment_id', $enrollment->enrollment_id)
            ->value('amount_paid');

        return response()->json([
            'success' => true,
            'data' => [
                'student_name' => $enrollment->student->user->name,
                'course_name' => $enrollment->course->name,
                'total_fee' => $enrollment->course->total_fee,
                'amount_paid' => $amountPaid,
            ]
        ]);
    }


    public function store(Request $request)
    {
        // Basic validation
        $request->validate([
            'enrollment_id' => 'required|exists:payments,enrollment_id',
            'amount' => 'required|numeric|min:1',
        ]);

        $payment = Payment::where('enrollment_id', $request->enrollment_id)->first();

        if (!$payment) {
            return back()->with('error', 'Payment not found for enrollment.')->withInput();
        }

        // Check if user entered amount more than amount due
        if ($request->amount > $payment->amount_due) {
            return back()->with('error', 'Payment amount cannot be greater than amount due (' . number_format($payment->amount_due, 2) . ').')->withInput();
        }

        DB::transaction(function () use ($request, $payment) {
            // Create transaction
            Transaction::create([
                'payment_id' => $payment->id,
                'amount' => $request->amount,
                'transaction_id' => 'TRX' . now()->format('YmdHis') . rand(100, 999),
                'payment_method_id' => 1,
                'payment_date' => now(),
                'status' => 1,
                'remarks' => null,
            ]);

            // Update payment summary
            $totalPaid = $payment->transactions()->where('status', 1)->sum('amount');
            $amountDue = $payment->total_fee - $totalPaid;
            if ($amountDue < 0) $amountDue = 0;

            $payment->amount_paid = $totalPaid;
            $payment->amount_due = $amountDue;

            if ($totalPaid >= $payment->total_fee) {
                $payment->status = 1; // Fully Paid
            } elseif ($totalPaid > 0) {
                $payment->status = 2; // Partial
            } else {
                $payment->status = 3; // Pending
            }

            $payment->last_payment_date = now();
            $payment->save();
        });

        return back()->with('success', 'Payment transaction added and status updated.');
    }
}
