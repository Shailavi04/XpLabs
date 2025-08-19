<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\attendance;
use App\Models\batch;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {


        return view('admin.attendance.index');
    }


    public function create()
    {

        $selectedMonth = Carbon::now()->month;
        $today = Carbon::today();


        $attendances = Attendance::whereMonth('date', $selectedMonth)
            ->get()
            ->groupBy(function ($att) {
                return $att->student_id . '_' . Carbon::parse($att->date)->day;
            });

        $startOfMonth = Carbon::now()->startOfMonth();
        $pastDays = [];
        for ($date = $startOfMonth->copy(); $date->lt($today); $date->addDay()) {
            $pastDays[] = $date->day;
        }

        $batches = batch::get();
        $students = Student::with('user')->get();

        return view('admin.attendance.create', compact('batches', 'students', 'attendances','pastDays'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'student_id' => 'required|integer',
            'date' => 'required|date',
            'status' => 'required',
            'remarks' => 'nullable|string',
        ]);

        attendance::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'date' => $request->date,
            ],
            [
                'status' => $request->status,
                'remarks' => $request->remarks,
            ]
        );

        return redirect()->back()->with('success', 'Attendance saved successfully.');
    }
}
