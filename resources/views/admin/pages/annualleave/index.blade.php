@extends('admin.master.main')

@section('content')

@if(session('success'))
<meta name="flash-success" content="{{ session('success') }}">
@endif
@if(session('error'))
<meta name="flash-error" content="{{ session('error') }}">
@endif

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">

<script>
    // Flash messages using meta tags
    document.addEventListener('DOMContentLoaded', function() {
        const successMsg = document.querySelector('meta[name="flash-success"]');
        const errorMsg = document.querySelector('meta[name="flash-error"]');

        if (successMsg) {
            Swal.fire({
                position: 'bottom-end',
                icon: 'success',
                title: successMsg.getAttribute('content'),
                showConfirmButton: false,
                timer: 3000,
                toast: true,
                background: '#28a745',
                customClass: {
                    popup: 'small-swal-popup'
                }
            });
        }

        if (errorMsg) {
            Swal.fire({
                position: 'bottom-end',
                icon: 'error',
                title: errorMsg.getAttribute('content'),
                showConfirmButton: false,
                timer: 3000,
                toast: true,
                background: '#dc3545',
                customClass: {
                    popup: 'small-swal-popup'
                }
            });
        }
    });
</script>

<div class="col-lg-12">
    <div class="d-flex justify-content-between align-items-center mb-3" style="padding-left: 10px; padding-top: 0;">
        <div class="d-flex align-items-center">
           
            <div>
                <h4 class="mb-0" style="font-weight: 600; font-size: 1.5rem; color: #0f172a;">Annual Leaves</h4>
                <p class="text-muted mb-0" style="font-size: 0.9rem;margin-left: 12px;">Manage annual leave records</p>
            </div>
        </div>

    </div>
    <div class="statbox widget box box-shadow">
       

<form method="GET" action="{{ route('annualleave.index') }}" class="mb-3 d-flex gap-2 align-items-center">

    {{-- Employee Dropdown --}}
    <select name="employee_id" class="form-control" style="max-width:280px;" onchange="this.form.submit()">
        <option value="">-- All Employees --</option>
        @foreach($employees as $emp)
            <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>
                {{ $emp->first_name }} {{ $emp->last_name }}
            </option>
        @endforeach
    </select>

    {{-- Leave Year Dropdown (1 April Based) --}}
    <select name="leave_year" class="form-control" style="max-width:320px;" onchange="this.form.submit()">
        <option value="">-- All Leave Years --</option>
        @foreach($leaveYears as $year)
            <option value="{{ $year }}" {{ request('leave_year') == $year ? 'selected' : '' }}>
                1 April {{ $year }} - 31 March {{ $year + 1 }}
            </option>
        @endforeach
    </select>

    {{-- Reset --}}
    @if(request()->filled('employee_id') || request()->filled('leave_year'))
        <a href="{{ route('annualleave.index') }}" class="btn btn-secondary btn-sm">Reset</a>
    @endif

</form>
        <div class="widget-content widget-content-area">
            <table id="style-2" class="table table-striped align-middle style-2 dt-table-hover">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th>Employee Name</th>
                        <th>Total Annual Leave</th>
                        <th>Used Annual Leave</th>
                        <th>Remaining Annual Leave</th>
                        <th class="text-center" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($annualLeaves as $annualLeave)
                    <tr>
                        <td><strong style="color: #0f172a;">#{{ $annualLeave->id }}</strong></td>
                        <td>
                            <strong style="color: #1e293b; font-weight: 600;">
                                {{ $annualLeave->first_name }} {{ $annualLeave->last_name }}
                            </strong>
                        </td>
                        <td style="color: #475569;">
                            <i class="fas fa-calendar-alt me-1" style="color: #64748b;"></i>{{ $annualLeave->total_annual_leave }}
                        </td>
                        <td style="color: #475569;">
                            <i class="fas fa-calendar-check me-1" style="color: #64748b;"></i>{{ $annualLeave->used_annual_leave }}
                        </td>
                        <td style="color: #475569; max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <i class="fas fa-hourglass-half me-1" style="color: #64748b;"></i>{{ $annualLeave->remain_annual_leave }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('annualleave.edit', $annualLeave->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection