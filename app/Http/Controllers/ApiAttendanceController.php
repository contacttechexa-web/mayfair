<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ApiAttendanceController extends Controller
{
    
    public function checkIn(Request $request)
{
    $user = Auth::user();
    $employee_id = $user->employee_id;

    // Ensure employee_id exists
    if (!$employee_id) {
        return response()->json([
            'message' => 'Employee ID not found'
        ], 404);
    }

    // Get current date and time
    $currentDateTime = Carbon::now();
    $currentDate = $currentDateTime->toDateString();
    $currentTime = $currentDateTime->toTimeString();

    // Check if already checked in today
    $existingAttendance = Attendance::where('employee_id', $employee_id)
        ->where('clock_in_date', $currentDate)
        ->first();

    if ($existingAttendance) {

        $checkInTime = Carbon::parse($existingAttendance->clock_in_time);
        $timePassed = $checkInTime->diff($currentDateTime);

        $timePassedFormatted = sprintf(
            '%02d:%02d:%02d',
            $timePassed->h,
            $timePassed->i,
            $timePassed->s
        );

        return response()->json([
            'message' => 'You have already checked in today',
            'employee' => [
                'employee_id' => $employee_id,
                'check_in_time' => $existingAttendance->clock_in_time,
                'time_passed' => $timePassedFormatted
            ]
        ], 400);
    }

    // Create attendance record
    $attendance = new Attendance();
    $attendance->employee_id = $employee_id;
    $attendance->clock_in_date = $currentDate;
    $attendance->clock_in_time = $currentTime;
    $attendance->clock_out_date = null;
    $attendance->clock_out_time = null;
    $attendance->reason = 'Online attendance';
    $attendance->save();

    return response()->json([
        'message' => 'Check-in successful',
        'employee' => [
            'employee_id' => $employee_id,
            'check_in_time' => $currentTime,
            'time_passed' => '00:00:00'
        ]
    ], 200);
}
    
    
    public function checkOut(Request $request)
    {
        $user = Auth::user();
        $employee_id = $user->employee_id; 
    
        // Find today's attendance record for the employee
        $attendance = Attendance::where('employee_id', $employee_id)
            ->whereDate('clock_in_date', Carbon::now()->toDateString())
            ->whereNotNull('clock_in_time')
            ->first();
    
        if (!$attendance) {
            return response()->json([
                'message' => 'No check-in record found for today'
            ], 404);
        }
    
        // Check if the employee has already checked out
        if ($attendance->clock_out_time) {
            return response()->json([
                'message' => 'You have already checked out today',
            ], 400);
        }
    
        // Get current time for check-out
        $clockOutTime = Carbon::now();
    
        // Calculate the time difference between check-in and check-out
        $checkInTime = Carbon::parse($attendance->clock_in_time);
        $timeElapsedInSeconds = $clockOutTime->diffInSeconds($checkInTime);
    
        // Convert seconds into hours, minutes, and seconds
        $hours = floor($timeElapsedInSeconds / 3600);
        $minutes = floor(($timeElapsedInSeconds % 3600) / 60);
        $seconds = $timeElapsedInSeconds % 60;
    
        // Format the time as HH:MM:SS
        $timeElapsedFormatted = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    
        // Update the attendance record for check-out
        $attendance->clock_out_date = $clockOutTime->toDateString();
        $attendance->clock_out_time = $clockOutTime->toTimeString();
        $attendance->save();
    
        return response()->json([
            'message' => 'Check-out successful',
            'attendance' => $attendance,
            'time_spent' => $timeElapsedFormatted, // Show time spent between check-in and check-out
        ], 200);
    }


    public function getCurrentMonthAttendance(Request $request)
    {
        try {
            // Retrieve the authenticated user
            $user = $request->user();
            $employeeId = $user->employee_id;

            // Get the current month and year
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;

            // Fetch all attendance records for the current month up to today
            $attendances = Attendance::where('employee_id', $employeeId)
                ->whereMonth('clock_in_date', $currentMonth)
                ->whereYear('clock_in_date', $currentYear)
                ->whereDate('clock_in_date', '<=', Carbon::now()->toDateString())
                ->get();

            // Get all the days of the current month up to today, excluding Saturdays and Sundays
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfDay();
            $allDays = [];

            while ($startDate->lte($endDate)) {
                // Skip Saturdays and Sundays
                if (!$startDate->isWeekend()) {
                    $allDays[] = $startDate->format('Y-m-d');
                }
                $startDate->addDay();
            }

            // Identify present and absent days
            $presentDays = $attendances->keyBy('clock_in_date')->toArray();
            $absentDays = array_diff($allDays, array_keys($presentDays));

            // Return the response
            return response()->json([
                'present_days' => $presentDays,
                'absent_days' => $absentDays,
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    
}
