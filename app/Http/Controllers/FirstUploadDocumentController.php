<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class FirstUploadDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $user = auth()->user();

    $employee = Employee::where('id', $user->employee_id)->first();

    if (!$employee) {
        return back()->with('error', 'Employee not found');
    }

    $uploadedDocs = \App\Models\Document::where('employee_id', $employee->id)
        ->pluck('name')
        ->toArray();

    $uploadedDocs = array_filter(array_map('trim', $uploadedDocs));

    $employeeDocumentsRaw = $employee->documents;

    if (is_array($employeeDocumentsRaw)) {
        $employeeDocs = $employeeDocumentsRaw;
    } else {
        $decoded = json_decode($employeeDocumentsRaw, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $employeeDocs = $decoded;
        } elseif (!empty($employeeDocumentsRaw)) {
            $employeeDocs = array(trim($employeeDocumentsRaw));
        } else {
            $employeeDocs = array();
        }
    }

    $employeeDocs = array_filter(array_map('trim', $employeeDocs));

    $pendingDocs = array_diff($employeeDocs, $uploadedDocs);

    return view('admin.pages.firstuploaddocument.index', compact('employee', 'pendingDocs'));
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
        //
    }
}
