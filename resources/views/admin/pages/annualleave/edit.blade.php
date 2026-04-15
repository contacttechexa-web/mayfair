@extends('admin.master.main')

@section('content')

@include('admin.pages.partials.form-styles')

<div class="form-container">
    <div class="form-header">
        <h3>
            <i class="fas fa-calendar-alt"></i>
            Edit Annual Leave
        </h3>
        <a href="{{ route('annualleave.index') }}" class="btn">
            <i class="fas fa-arrow-left me-2"></i>Back
        </a>
    </div>

    <div class="form-card">
        <form action="{{ route('annualleave.update', $employee->id) }}" method="POST" id="annualLeaveEditForm">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group-wrapper">
                        <label for="employeeName"><i class="fas fa-user me-2"></i>Employee</label>
                        <input type="text" class="form-control" id="employeeName" value="{{ $employee->first_name }} {{ $employee->last_name }}" disabled>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="form-group-wrapper">
                        <label for="total_annual_leave"><i class="fas fa-calendar-alt me-2"></i>Total</label>
                        <input type="number" min="0" step="1" class="form-control" id="total_annual_leave" name="total_annual_leave" value="{{ old('total_annual_leave', $employee->total_annual_leave ?? 0) }}" required>
                        @if ($errors->has('total_annual_leave'))
                            <span class="text-danger">{{ $errors->first('total_annual_leave') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group-wrapper">
                        <label for="used_annual_leave"><i class="fas fa-calendar-check me-2"></i>Used</label>
                        <input type="number" min="0" step="1" class="form-control" id="used_annual_leave" name="used_annual_leave" value="{{ old('used_annual_leave', $employee->used_annual_leave ?? 0) }}" required>
                        @if ($errors->has('used_annual_leave'))
                            <span class="text-danger">{{ $errors->first('used_annual_leave') }}</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group-wrapper">
                        <label for="remain_annual_leave"><i class="fas fa-hourglass-half me-2"></i>Remaining</label>
                        <input type="number" min="0" step="1" class="form-control" id="remain_annual_leave" name="remain_annual_leave" value="{{ old('remain_annual_leave', $employee->remain_annual_leave ?? 0) }}" required>
                        @if ($errors->has('remain_annual_leave'))
                            <span class="text-danger">{{ $errors->first('remain_annual_leave') }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-actions mt-4">
                <button type="submit" class="btn btn-submit">
                    <i class="fas fa-save me-2"></i>Update
                </button>
                <a href="{{ route('annualleave.index') }}" class="btn btn-back">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>
    
        <script>
        // Auto-calc remaining annual leave: remaining = total - used
        (function() {
            const total = document.getElementById('total_annual_leave');
            const used = document.getElementById('used_annual_leave');
            const remain = document.getElementById('remain_annual_leave');

            function recalc() {
                const t = parseInt(total.value) || 0;
                const u = parseInt(used.value) || 0;
                let r = t - u;
                if (r < 0) r = 0;
                remain.value = r;
            }

            if (total && used && remain) {
                total.addEventListener('input', recalc);
                used.addEventListener('input', recalc);
                recalc();
            }
        })();
    </script>

@endsection
