<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Leave;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Mail\LeaveNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('permission:view leave', ['only' => ['index']]);
        $this->middleware('permission:create leave', ['only' => ['create', 'store']]);
        $this->middleware('permission:update leave', ['only' => ['update', 'edit']]);
        $this->middleware('permission:delete leave', ['only' => ['destroy']]);
        $this->middleware('permission:show leave', ['only' => ['show']]);
        $this->middleware('permission:status leave', ['only' => ['accept', 'reject']]);
    }

public function index(Request $request)
{
    $user = auth()->user();

    

    $selectedMonth = $request->input('month');
    $selectedYear = $request->input('year');

    $query = Leave::with('employee');

    if (!in_array($user->role, ['admin', 'HR', 'Accountant'])) {
        $query->where('employee_id', $user->employee_id);
    }

    // ✅ Apply month & year filters if selected
    if ($selectedMonth && $selectedYear) {
        $query->whereMonth('created_at', $selectedMonth)
              ->whereYear('created_at', $selectedYear);
    } elseif ($selectedYear) {
        $query->whereYear('created_at', $selectedYear);
    } elseif ($selectedMonth) {
        $query->whereMonth('created_at', $selectedMonth);
    }

    $leaves = $query->orderBy('created_at', 'desc')->get();

    // ✅ Calculate leave days
    foreach ($leaves as $leave) {
        if ($leave->date) {
            $leave->leave_days = 1;
        } elseif ($leave->start_date && $leave->end_date) {
            $leave->leave_days = Carbon::parse($leave->start_date)->diffInDays(Carbon::parse($leave->end_date)) + 1;
        } else {
            $leave->leave_days = null;
        }
    }

    // Send selected filters to view
    return view('admin.pages.leave.index', compact('leaves', 'selectedMonth', 'selectedYear'));
}





    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user(); // Get the currently authenticated user

        if ($user->role === 'Employee') {
    
    $employees = Employee::where('id', $user->employee_id)
        ->get(['id', 'first_name', 'last_name']);
} else {
   
    $employees = Employee::where('role', '!=', 'admin')->get(['id', 'first_name', 'last_name']);
}

        return view('admin.pages.leave.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */


public function store(Request $request)
{
    DB::transaction(function () use ($request) {

        // Create new Leave
        $leave = new Leave();
        $leave->employee_id = $request->employee_id;
        $leave->leave_type  = $request->leave_type;
        $leave->age         = $request->duration; // (field name weird, but keeping your code)
        $leave->reason      = $request->reason;
        $leave->start_date  = $request->start_date;
        $leave->end_date    = $request->end_date;
        $leave->start_time  = $request->start_time;
        $leave->end_time    = $request->end_time;
        $leave->date        = $request->date;

        $leave->first_half  = $request->leave_duration == 'First half' ? 1 : 0;
        $leave->last_half   = $request->leave_duration == 'Second half' ? 1 : 0;

        // Image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_image.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $leave->image = 'images/' . $imageName;
        }

        $leave->save();
if ($request->leave_type === 'Annual leave') {

    $daysToAdd = 0;

    if (!empty($request->start_date) && !empty($request->end_date)) {
        $start = Carbon::parse($request->start_date)->startOfDay();
        $end   = Carbon::parse($request->end_date)->startOfDay();
        $daysToAdd = $start->diffInDays($end) + 1;
    } elseif (!empty($request->date)) {
        $daysToAdd = 1;
        if ($request->leave_duration === 'First half' || $request->leave_duration === 'Second half') {
            $daysToAdd = 0.5;
        }
    }

    if ($daysToAdd > 0) {
        $daysToAdd = (float) $daysToAdd;

        DB::transaction(function () use ($request, $daysToAdd) {

            // 1) increment used
            Employee::where('id', $request->employee_id)
                ->increment('used_annual_leave', $daysToAdd);

            // 2) recompute remain from updated used
            Employee::where('id', $request->employee_id)->update([
                'remain_annual_leave' => DB::raw('total_annual_leave - used_annual_leave'),
            ]);
        });
    }
}

        // Send Email
        $employee = Employee::find($request->employee_id);
        $employeeName = $employee ? $employee->first_name . ' ' . $employee->last_name : 'Unknown Employee';

        Mail::to('hamzakayani371@gmail.com')->send(new LeaveNotification($leave, $employeeName));
    });

    return redirect()->route('leave.index')->with('success', 'Leave request submitted successfully.');
}


    public function accept($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->status = 1; // Set status to Accepted
        $leave->save();

        return redirect()->back()->with('success', 'Leave request accepted.');
    }

    public function reject($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->status = 2; // Set status to Rejected
        $leave->save();

        return redirect()->back()->with('success', 'Leave request rejected.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $leave = Leave::findOrFail($id);

        $leave->delete();

        return redirect()->route('leave.index')->with('success', 'Leave Cancel successfully');
    }
}
