<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    public function store(Request $request){

    $request->validate([
        'student_id' => 'required|exists:students,id',
        'course_ids' => 'required|array',
        'course_ids.*' => 'exists:courses,id',
        'token_amount' => 'required|numeric|min:0',
    ]);

    DB::beginTransaction();

    try {
        foreach ($request->course_ids as $course_id) {
            Subscription::create([
                'student_id' => $request->student_id,
                'course_id' => $course_id,
                'token_amount' => $request->token_amount,
                'is_confirmed' => false,
                'status' => 0,
                'total_installments' => 0,
                'installments_paid' => 0,
            ]);
        }

        DB::commit();

        return redirect()->back()->with('success', 'Enrollment(s) added successfully.');

    } catch (\Exception $e) {
        DB::rollback();
        return redirect()->back()->with('error', 'Something went wrong. ' . $e->getMessage());
    }
}
}
