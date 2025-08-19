<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\EnrollmentStatusLog;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;

class EnrollmentController extends Controller
{


    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->role_id == 1) {
            // Admin sees all data
            $centers = DB::table('centers')->get();
            $students = Student::with('user')->get(); // Eloquent with relation
            $courses = DB::table('courses')->get();
        } else {
            $userCenterIds = DB::table('center_user')
                ->where('user_id', $user->id)
                ->pluck('center_id')
                ->toArray();

            $centers = DB::table('centers')->whereIn('id', $userCenterIds)->get();

            $students = Student::with('user')
                ->whereIn('center_id', $userCenterIds)
                ->get();

            // dd($students);

            $courses = DB::table('courses')->whereIn('center_id', $userCenterIds)->get();
        }

        $categories = DB::table('categories')->get();

        $enrollmentsByStudent = DB::table('enrollment')
            ->select('student_id', 'course_id')
            ->get()
            ->groupBy('student_id')
            ->map(function ($items) {
                return collect($items)->pluck('course_id')->toArray();
            });

        return view('admin.enrollment.index', compact(
            'students',
            'courses',
            'categories',
            'enrollmentsByStudent',
            'centers'
        ));
    }

    public function data(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'] ?? null;

        $studentId = $request->get('student_id');
        $courseId = $request->get('course_id');
        $dateRange = $request->get('date_range'); // expected format: "YYYY-MM-DD - YYYY-MM-DD"

        // Base query with relations
        $query = Enrollment::with(['student', 'course']);

        // Filter by student if given
        if (!empty($studentId)) {
            $query->where('student_id', $studentId);
        }

        // Filter by course if given
        if (!empty($courseId)) {
            $query->where('course_id', $courseId);
        }

        // Filter by date range if given
        if (!empty($dateRange)) {
            $dates = explode(' - ', $dateRange);
            if (count($dates) == 2) {
                $startDate = $dates[0];
                $endDate = $dates[1];
                $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            }
        }

        // Search across student name or course code or token amount
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->whereHas('student', function ($q2) use ($searchValue) {
                    $q2->where('name', 'like', '%' . $searchValue . '%');
                })->orWhereHas('course', function ($q3) use ($searchValue) {
                    $q3->where('code', 'like', '%' . $searchValue . '%');
                })->orWhere('token_amount', 'like', '%' . $searchValue . '%');
            });
        }

        $totalRecords = Enrollment::count();
        $totalFiltered = $query->count();

        $enrollments = $query->offset($start)->limit($length)->get();

        $data = [];
        $i = $start + 1;

        foreach ($enrollments as $enrollment) {
            $statusLabel = match ($enrollment->status) {
                1 => 'Pending',
                2 => 'Enrolled',
                3 => 'Completed',
                4 => 'Dropped',
            };

            $data[] = [
                'DT_RowIndex' => $i++,
                'id' => $enrollment->id,
                'student_name' => $enrollment->student->user->name ?? '-',
                'course_code' => $enrollment->course->name ?? '-',
                'token_amount' => number_format($enrollment->token_amount, 2),
                'status' => $statusLabel,
                'created_at' => $enrollment->created_at->format('d M Y'),
                'action' => '
<div class="btn-group">
    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0.25rem 0.5rem;">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 5.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 1.5a1.5 1.5 0 1 1 0 3 
                1.5 1.5 0 0 1 0-3zm0 4.5a1.5 1.5 0 1 1 0 3 
                1.5 1.5 0 0 1 0-3z"/>
        </svg>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="javascript:void(0);" class="dropdown-item editEnrollmentBtn" data-id="' . $enrollment->id . '">
                <i class="fas fa-edit text-warning me-1"></i> Edit
            </a>
        </li>
        <li>
            <form action="' . route('enrollment.destroy', $enrollment->id) . '" method="POST" class="delete-enrollment-form" style="margin:0;">
                ' . csrf_field() . method_field('DELETE') . '
                <button type="button" class="dropdown-item text-danger sweet-delete-btn">
                    <i class="fas fa-trash-alt me-1"></i> Delete
                </button>
            </form>
        </li>
    </ul>
</div>
',


            ];
        }

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'center_id' => 'required|exists:centers,id',
            'course_ids' => 'required|array|min:1',
            'token_amounts' => 'required|array',
            'remarks' => 'nullable|string|max:255',
        ]);

        $studentId = $validated['student_id'];
        $centerId = $validated['center_id'];
        $courseIds = $validated['course_ids'];
        $tokenAmounts = $request->input('token_amounts');
        $remarks = $validated['remarks'] ?? null;

        $student = Student::findOrFail($studentId);
        $studentIcard = $student->icard ?? null;

        DB::beginTransaction();
        try {
            $courses = Course::whereIn('id', $courseIds)->get()->keyBy('id');

            foreach ($courseIds as $courseId) {
                $course = $courses[$courseId] ?? null;
                if (!$course) throw new \Exception("Course not found: $courseId");

                $tokenAmount = $tokenAmounts[$courseId] ?? 0;
                $totalFee = $course->total_fee ?? 0;

                $enrollmentCode = date('Ymd') . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
                $transactionId = 'TRX' . now()->format('YmdHis') . rand(100, 999);

                // Create enrollment
                $enrollment = Enrollment::create([
                    'student_id' => $studentId,
                    'student_icard' => $studentIcard,
                    'center_id' => $centerId,
                    'course_id' => $courseId,
                    'enrollment_id' => $enrollmentCode,
                    'token_amount' => $tokenAmount,
                    'status' => 2,
                    'payment_status' => 0,
                    'remarks' => $remarks,
                ]);

                // Create payment entry
                $payment = Payment::create([
                    'enrollment_id' => $enrollmentCode,
                    'total_fee' => $totalFee,
                    'amount_paid' => $tokenAmount,
                    'amount_due' => $totalFee - $tokenAmount,
                    'last_payment_date' => now()->toDateString(),
                ]);

                // Create transaction entry
                Transaction::create([
                    'payment_id' => $payment->id,
                    'amount' => $tokenAmount,
                    'transaction_id' => $transactionId,
                    'payment_method_id' => 1,
                    'payment_date' => now()->toDateString(),
                    'status' => 1,
                    'remarks' => 'Initial token payment',
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Enrollment(s), payment(s), and transaction(s) added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }




    public function edit($id)
    {
        $enrollment = Enrollment::with('course')->findOrFail($id);

        return response()->json([
            'enrollment' => $enrollment,

        ]);
    }




    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'center_id' => 'required|exists:centers,id',
            'course_ids' => 'required|array|min:1',
            'token_amounts' => 'required|array',
            'remarks' => 'nullable|string|max:255',
        ]);

        $studentId = $validated['student_id'];
        $centerId = $validated['center_id'];
        $courseIds = $validated['course_ids'];
        $tokenAmounts = $request->input('token_amounts');
        $remarks = $validated['remarks'] ?? null;

        $student = Student::findOrFail($studentId);
        $studentIcard = $student->icard ?? null;

        DB::beginTransaction();
        try {
            // Delete old enrollment, payment, and transaction
            $enrollment = Enrollment::findOrFail($id);
            if ($enrollment) {
                Payment::where('enrollment_id', $enrollment->enrollment_id)->delete();
                Transaction::whereIn('payment_id', Payment::pluck('id'))->delete();
                $enrollment->delete();
            }

            $courses = Course::whereIn('id', $courseIds)->get()->keyBy('id');

            foreach ($courseIds as $courseId) {
                $course = $courses[$courseId] ?? null;
                if (!$course) throw new \Exception("Course not found: $courseId");

                $tokenAmount = $tokenAmounts[$courseId] ?? 0;
                $totalFee = $course->total_fee ?? 0;

                $enrollmentCode = date('Ymd') . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
                $transactionId = 'TRX' . now()->format('YmdHis') . rand(100, 999);

                // Create updated enrollment
                $enrollment = Enrollment::create([
                    'student_id' => $studentId,
                    'student_icard' => $studentIcard,
                    'center_id' => $centerId,
                    'course_id' => $courseId,
                    'enrollment_id' => $enrollmentCode,
                    'token_amount' => $tokenAmount,
                    'status' => 2,
                    'payment_status' => 0,
                    'remarks' => $remarks,
                ]);

                // Create updated payment
                $payment = Payment::create([
                    'enrollment_id' => $enrollmentCode,
                    'total_fee' => $totalFee,
                    'amount_paid' => $tokenAmount,
                    'amount_due' => $totalFee - $tokenAmount,
                    'last_payment_date' => now()->toDateString(),
                ]);

                // Create updated transaction
                Transaction::create([
                    'payment_id' => $payment->id,
                    'amount' => $tokenAmount,
                    'transaction_id' => $transactionId,
                    'payment_method_id' => 1,
                    'payment_date' => now()->toDateString(),
                    'status' => 1,
                    'remarks' => 'Updated token payment',
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Enrollment(s) updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function destroy(Request $request, $id)
    {

        $enroll = Enrollment::where('id', $id)->first();
        // dd($enroll);

        // if ($student->image && file_exists(public_path('uploads/students/' . $student->image))) {
        //     unlink(public_path('uploads/students/' . $student->image));
        // }

        $enroll->delete();

        // if ($request->ajax()) {
        //     return response()->json(['success' => true, 'message' => 'Student deleted successfully.']);
        // }

        return redirect()->route('enrollment.index')->with('success', 'Student deleted successfully.');
    }

    public function lifecycle()
    {

        return view('admin.enrollment.lifecycle');
    }
    public function lifecycleData(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'] ?? null;

        $baseQuery = Enrollment::select('enrollment.*')
            ->selectRaw("(SELECT MAX(changed_at) FROM enrollment_status_logs WHERE enrollment_id = enrollment.id AND status = 3) AS latest_completed")
            ->selectRaw("(SELECT MAX(changed_at) FROM enrollment_status_logs WHERE enrollment_id = enrollment.id AND status = 4) AS latest_dropped")
            ->with(['student', 'course']);

        if (!empty($searchValue)) {
            $baseQuery->whereHas('student', function ($q) use ($searchValue) {
                $q->where('name', 'like', "%$searchValue%");
            })->orWhereHas('course', function ($q) use ($searchValue) {
                $q->where('name', 'like', "%$searchValue%");
            });
        }

        $totalRecords = $baseQuery->count();
        $totalFiltered = $totalRecords;

        $enrollments = $baseQuery->offset($start)
            ->limit($length)
            ->orderByDesc('enrollment.created_at')
            ->get();

        $data = [];
        $i = $start + 1;

        foreach ($enrollments as $enrollment) {

            $viewUrl = route('enrollment.show', $enrollment->id);
            $row = [];

            $row['id'] = $enrollment->id;
            $row['status_code'] = $enrollment->status;
            $row['DT_RowIndex'] = $i++;
            $row['student'] = $enrollment->student->name ?? '-';
            $row['course'] = $enrollment->course->name ?? '-';
            $row['amount'] = '₹' . number_format($enrollment->token_amount, 2);
            $row['action'] =  '<div class="btn-group">
                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0.25rem 0.5rem;">
                         <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 5.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 1.5a1.5 1.5 0 1 1 0 3 
                        1.5 1.5 0 0 1 0-3zm0 4.5a1.5 1.5 0 1 1 0 3 
                        1.5 1.5 0 0 1 0-3z"/>
                </svg>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="' . $viewUrl . '" class="dropdown-item">
                        <i class="fas fa-eye text-info me-1"></i> View
                    </a>
                        </li>
                        
                    </ul>
                </div>';

            $statusText = [
                1 => 'Pending',
                2 => 'Enrolled',
                3 => 'Completed',
                4 => 'Dropped',
            ][$enrollment->status] ?? 'Unknown';

            $row['status'] = $statusText;

            $row['start_date'] = optional($enrollment->created_at)->format('d M Y') ?? '-';
            $row['completion_date'] = $enrollment->latest_completed ? \Carbon\Carbon::parse($enrollment->latest_completed)->format('d M Y') : '-';
            $row['dropped_date'] = $enrollment->latest_dropped ? \Carbon\Carbon::parse($enrollment->latest_dropped)->format('d M Y') : '-';


            $row['status_date'] = match ($enrollment->status) {
                2 => $row['start_date'],
                3 => $row['completion_date'],
                4 => $row['dropped_date'],
                default => $row['start_date']
            };

            $data[] = $row;
        }

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ]);
    }


    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:enrollment,id',
            'status' => 'required|in:1,2,3,4'
        ]);

        $enrollment = Enrollment::find($request->id);
        $newStatus = (int)$request->status;

        $hasCompletedBefore = EnrollmentStatusLog::where('enrollment_id', $enrollment->id)
            ->where('status', 3)
            ->exists();

        if ($hasCompletedBefore && $newStatus == 4) {
            return back()->with('error', 'Cannot mark enrollment as dropped after it is completed.');
        }

        $enrollment->status = $newStatus;
        $enrollment->save();

        \App\Models\EnrollmentStatusLog::create([
            'enrollment_id' => $enrollment->id,
            'status' => $newStatus,
            'changed_at' => now(),
        ]);

        return redirect()->route('enrollment.lifecycle')->with('success', 'Enrollment status updated successfully.');
    }

    public function show($id)
    {
        $enrollment = Enrollment::select('enrollment_id', 'student_id', 'course_id', 'token_amount', 'created_at')
            ->where('id', $id)
            ->first();

        if (!$enrollment) {
            return abort(404, 'Enrollment not found');
        }

        $student = Student::find($enrollment->student_id);

        $course = Course::find($enrollment->course_id);

        $payment = Payment::where('enrollment_id', $enrollment->enrollment_id)->first();

        $transactions = null;
        if ($payment) {
            $transactions = Transaction::where('payment_id', $payment->id)
                ->orderBy('created_at', 'asc')
                ->get();
        }


        return view('admin.enrollment.detail', compact(
            'enrollment',
            'student',
            'course',
            'payment',
            'transactions'
        ));
    }

    public function getCoursesByCenter(Request $request)
    {
        $user = auth()->user();
        $centerId = $request->center_id;

        if (!$centerId) {
            return response()->json(['courses' => []]);
        }

        // Non-admin: only allow their own center
        if ($user->role_id != 1) {
            $allowedCenters = DB::table('center_user')
                ->where('user_id', $user->id)
                ->pluck('center_id')
                ->toArray();

            if (!in_array($centerId, $allowedCenters)) {
                return response()->json(['courses' => []]);
            }
        }

        // Fetch courses for the given center
        $courses = DB::table('courses')
            ->where('center_id', $centerId)
            ->select('id', 'name', 'token_amount', 'duration')
            ->get();

        return response()->json(['courses' => $courses]);
    }
}
