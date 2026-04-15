<?php

namespace App\Http\Controllers;

use Log;
use DateTime;
use Carbon\Carbon;
use App\Models\Leave;
use App\Models\PayRoll;
use App\Models\Employee;
use Barryvdh\DomPDF\PDF;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\PayslipUpload;
use Illuminate\Support\Facades\Auth;


class PayRollController extends Controller
{

    protected $pdf;

    public function __construct(PDF $pdf = null)
    {
        if ($pdf) {
            $this->pdf = $pdf;
        }

        $this->middleware('permission:view payroll', ['only' => ['index']]);
        $this->middleware('permission:create payroll', ['only' => ['create', 'store']]);
        $this->middleware('permission:update payroll', ['only' => ['update', 'edit']]);
        $this->middleware('permission:delete payroll', ['only' => ['destroy']]);
        $this->middleware('permission:show payroll', ['only' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'Employee') {
    // Employee sirf apni payroll dekhe
    $payrolls = PayRoll::with('employee')
        ->where('employee_id', $user->employee_id)
        ->orderBy('created_at', 'desc')
        ->get();
} else {
    // Baaki sab roles sab payrolls dekhein
    $payrolls = PayRoll::with('employee')
        ->orderBy('created_at', 'desc')
        ->get();
}

        return view('admin.pages.payroll.index', compact('payrolls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        $user = auth()->user(); // Get the currently authenticated user

        if ($user->role === 'admin' ||$user->role === 'HR' || $user->role === 'Accountant') {
            // Admin sees all employees
            $employees = Employee::all(['id', 'first_name', 'last_name']);
        } else {
            // Non-admin sees only their own record
            $employees = Employee::where('id', $user->employee_id)
                ->get(['id', 'first_name', 'last_name']);
        }

        return view('admin.pages.payroll.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'salary' => 'required|numeric',
            'bonus' => 'nullable|numeric',
            'deduction' => 'nullable|numeric',
            'total' => 'required|numeric',
        ]);

        // Create a new payroll entry
        $payroll = Payroll::create($validated);

        // Redirect to a specific route or return a response
        return redirect()->route('payroll.index')->with('success', 'Payroll entry created successfully!');
    }

    /**
     * Display the specified resource.
     */





 

     public function show($payrollId, $employeeId, $firstName, $lastName, Request $request)
    {
        $currentYear = \Carbon\Carbon::now()->year;

        // Months list
        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            $months[$m] = \Carbon\Carbon::createFromDate($currentYear, $m, 1)->format('F');
        }

        // Last 5 years
        $years = [];
        for ($y = 0; $y < 5; $y++) {
            $years[] = $currentYear - $y;
        }

        $employees = Employee::where('role', '!=', 'admin')->get();

        $selectedMonth = $request->month ? (int) $request->month : null;
        $selectedYear = $request->year ? (int) $request->year : null;
        $selectedMonthName = $selectedMonth ? \Carbon\Carbon::createFromDate($currentYear, $selectedMonth, 1)->format('F') : null;

        // Fetch all payslips
        $employeeModel = Employee::find($employeeId);
        $payslipUploads = \App\Models\PayslipUpload::all();
        $matchingPdfs = [];

        foreach ($payslipUploads as $upload) {
            $pdfPaths = is_array($upload->pdfs) ? $upload->pdfs : json_decode($upload->pdfs, true);
            if (!is_array($pdfPaths)) continue;

            foreach ($pdfPaths as $pdfPath) {
                $filename = basename($pdfPath);
                $nameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
                $parts = preg_split('/[_\-]/', $nameWithoutExt);
                $employeeIdFromPdf = $parts[0];

                if ($employeeModel->employee_id == $employeeIdFromPdf) {
                    // Check month/year filter if selected
                    $pdfMonth = \Carbon\Carbon::parse($upload->created_at)->month;
                    $pdfYear = \Carbon\Carbon::parse($upload->created_at)->year;

                    if ($selectedMonth && $selectedYear) {
                        if ($pdfMonth == $selectedMonth && $pdfYear == $selectedYear) {
                            $matchingPdfs[] = $pdfPath;
                        }
                    } elseif ($selectedMonth) {
                        if ($pdfMonth == $selectedMonth) {
                            $matchingPdfs[] = $pdfPath;
                        }
                    } elseif ($selectedYear) {
                        if ($pdfYear == $selectedYear) {
                            $matchingPdfs[] = $pdfPath;
                        }
                    } else {
                        // No filter selected → show all
                        $matchingPdfs[] = $pdfPath;
                    }
                }
            }
        }

        // Not found message if month/year selected but no PDF
        $notFoundMessage = null;
        if (($selectedMonth || $selectedYear) && empty($matchingPdfs)) {
            $notFoundMessage = "No payslips found for " . ($selectedMonthName ? $selectedMonthName . ' ' : '') . ($selectedYear ?? '');
        }

        return view('admin.pages.payroll.show', compact(
            'employeeId',
            'currentYear',
            'months',
            'years',
            'employees',
            'firstName',
            'lastName',
            'matchingPdfs',
            'selectedMonthName',
            'selectedYear',
            'notFoundMessage'
        ));
    }

     
     





    






    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $payroll = Payroll::findOrFail($id);
        $employees = Employee::where('role', '!=', 'admin')->get();

        return view('admin.pages.payroll.edit', compact('payroll', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'salary' => 'required|numeric',
            'bonus' => 'nullable|numeric',
            'deduction' => 'nullable|numeric',
            'total' => 'required|numeric',
        ]);

        $payroll = Payroll::findOrFail($id);
        $payroll->update($validated);

        return redirect()->route('payroll.index')->with('success', 'Payroll entry updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payroll = PayRoll::findOrFail($id);

        $payroll->delete();

        return redirect()->route('payroll.index')->with('success', 'PayRoll Delete successfully');
    }



      public function generate(Request $request, $employeeId, $firstName, $lastName)
    {
        // Validate request
        $request->validate([
            'employee' => 'required|exists:employees,id',
            'month' => 'nullable|integer|min:1|max:12',
            'year' => 'nullable|integer',
        ]);

        // Build last 5 years for dropdown
        $currentYear = \Carbon\Carbon::now()->year;
        $years = [];
        for ($y = 0; $y < 5; $y++) {
            $years[] = $currentYear - $y;
        }

        // Fetch selected employee
        $employee = \App\Models\Employee::find($request->employee);

        // Selected filters
        $selectedMonth = $request->month ? (int) $request->month : null;
        $selectedYear = $request->year ? (int) $request->year : null;

        // Fetch payslips
        $payslipUploads = \App\Models\PayslipUpload::query()->get();

        $matchingPdfs = [];

        foreach ($payslipUploads as $payslipUpload) {
            $pdfPaths = is_array($payslipUpload->pdfs)
                ? $payslipUpload->pdfs
                : json_decode($payslipUpload->pdfs, true);

            if (!is_array($pdfPaths)) continue;

            foreach ($pdfPaths as $pdfPath) {
                $filename = basename($pdfPath);
                $nameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
                $parts = preg_split('/[_\-]/', $nameWithoutExt);

                $employeeIdFromPdf = $parts[0];
                $fileYear = isset($parts[1]) && is_numeric($parts[1]) ? (int)$parts[1] : null;

                // Match employee
                if ($employee->employee_id == $employeeIdFromPdf) {
                    $isMatch = true;

                    // Month filter
                    if ($selectedMonth) {
                        $isMatch = $isMatch && (\Carbon\Carbon::parse($payslipUpload->created_at)->month == $selectedMonth);
                    }

                    // Year filter
                    if ($selectedYear) {
                        if (\Schema::hasColumn('payslip_uploads', 'year')) {
                            $isMatch = $isMatch && ($payslipUpload->year == $selectedYear);
                        } elseif ($fileYear !== null) {
                            $isMatch = $isMatch && ($fileYear == $selectedYear);
                        } else {
                            // Use created_at as fallback
                            $isMatch = $isMatch && (\Carbon\Carbon::parse($payslipUpload->created_at)->year == $selectedYear);
                        }
                    }

                    if ($isMatch) {
                        $matchingPdfs[] = $pdfPath;
                    }
                }
            }
        }

        // For month name display
        $monthName = $selectedMonth
            ? \DateTime::createFromFormat('!m', $selectedMonth)->format('F')
            : null;

        // If searched but no result
        if (($selectedMonth || $selectedYear) && empty($matchingPdfs)) {
            $notFoundMessage = "No payslips found for " .
                ($monthName ? $monthName . ' ' : '') . ($selectedYear ?? '');
        }

        // If no filters, show all payslips for employee
        if (!$selectedMonth && !$selectedYear && empty($matchingPdfs)) {
            foreach ($payslipUploads as $payslipUpload) {
                $pdfPaths = is_array($payslipUpload->pdfs)
                    ? $payslipUpload->pdfs
                    : json_decode($payslipUpload->pdfs, true);

                if (!is_array($pdfPaths)) continue;

                foreach ($pdfPaths as $pdfPath) {
                    $filename = basename($pdfPath);
                    $nameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
                    $parts = preg_split('/[_\-]/', $nameWithoutExt);
                    $employeeIdFromPdf = $parts[0];

                    if ($employee->employee_id == $employeeIdFromPdf) {
                        $matchingPdfs[] = $pdfPath;
                    }
                }
            }
        }

        // Return view
        return view('admin.pages.payroll.show', [
            'employees' => \App\Models\Employee::all(),
            'matchingPdfs' => $matchingPdfs,
            'notFoundMessage' => $notFoundMessage ?? null,
            'employeeId' => $employeeId,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'selectedMonthName' => $monthName,
            'selectedYear' => $selectedYear,
            'years' => $years, // ✅ Fixed
        ]);
    }
    

    
    
}
