<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnnualLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function index(Request $request)
{
    $employees = Employee::select('id', 'first_name', 'last_name')
        ->where('role', '!=', 'admin')
        ->orderBy('first_name')
        ->get();

    $annualLeavesQuery = Employee::select(
            'id',
            'first_name',
            'last_name',
            'total_annual_leave',
            'used_annual_leave',
            'remain_annual_leave',
            'updated_at' // ✅ needed for year filter
        )
        ->where('role', '!=', 'admin')
        ->orderBy('id', 'desc');

    // ✅ Employee dropdown filter
    if ($request->filled('employee_id')) {
        $annualLeavesQuery->where('id', $request->employee_id);
    }

    // ✅ Leave Year filter (1 April to 31 March)
    if ($request->filled('leave_year')) {
        $year = (int) $request->leave_year; // e.g. 2026

        $startDate = Carbon::create($year, 4, 1)->startOfDay(); // 1 April YYYY
        $endDate   = Carbon::create($year + 1, 3, 31)->endOfDay(); // 31 March YYYY+1

        $annualLeavesQuery->whereBetween('updated_at', [$startDate, $endDate]);
    }

    $annualLeaves = $annualLeavesQuery->get();

    // ✅ dropdown years generate (last 6 leave years)
    // If today is before April, current leave-year start is previous year
    $currentLeaveYear = now()->month >= 4 ? now()->year : now()->year - 1;

    $leaveYears = [];
    for ($i = 0; $i < 6; $i++) {
        $leaveYears[] = $currentLeaveYear - $i; // e.g. 2026, 2025, 2024...
    }

    return view('admin.pages.annualleave.index', compact('annualLeaves', 'employees', 'leaveYears'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $employee = Employee::findOrFail($id);
        return view('admin.pages.annualleave.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employee = Employee::findOrFail($id);

        $validated = $request->validate([
            'total_annual_leave' => 'required|numeric|min:0',
            'used_annual_leave' => 'required|numeric|min:0',
            'remain_annual_leave' => 'required|numeric|min:0',
        ]);

        $employee->update([
            'total_annual_leave' => $validated['total_annual_leave'],
            'used_annual_leave' => $validated['used_annual_leave'],
            'remain_annual_leave' => $validated['remain_annual_leave'],
        ]);

        return redirect()->route('annualleave.index')->with('success', 'Annual leave updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
