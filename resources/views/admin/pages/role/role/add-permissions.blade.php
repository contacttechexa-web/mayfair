@extends('admin.master.main')

@section('content')
@include('admin.pages.role.partials.mobile-fixes')
<div class="content role-mobile-content">
    <nav class="mb-2" aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">{{ $role->name }}</li>
        </ol>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">

                @if (session('status'))
                    <div id="alertMessage" class="alert bg-success alert-dismissible fade show text-white" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const alertMessage = document.getElementById('alertMessage');
                            if (alertMessage) {
                                setTimeout(function () {
                                    alertMessage.classList.remove('show');
                                    alertMessage.classList.add('fade');
                                }, 5000);
                            }
                        });
                    </script>
                @endif

                @php
                    $groupedPermissions = $permissions->groupBy(function ($permission) {
                        $name = strtolower(trim($permission->name));
                        $words = preg_split('/\s+/', $name);

                        // module last word hoga
                        $module = end($words);

                        // custom labels
                        $labels = [
                            'role' => 'Role',
                            'permission' => 'Permission',
                            'user' => 'User',
                            'team' => 'Team',
                            'payroll' => 'Payroll',
                            'attendance' => 'Attendance',
                            'employee' => 'Employee',
                            'leave' => 'Leave',
                            'expenses' => 'Expenses',
                            'announcements' => 'Announcements',
                            'payslip' => 'Payslip',
                            'payslipupload' => 'Payslip Upload',
                            'announcementsdocument' => 'Announcements Document',
                            'shift' => 'Shift',
                            'document' => 'Document',
                            'rota' => 'Rota',
                        ];

                        return $labels[$module] ?? ucfirst($module);
                    });
                @endphp

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const selectAllBtn = document.getElementById('selectAllBtn');
                        const checkboxes = document.querySelectorAll('.permission-checkbox');

                        function updateMainButtonText() {
                            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                            selectAllBtn.textContent = allChecked ? 'DeSelect All' : 'Select All';
                        }

                        function updateSectionButton(sectionClass) {
                            const sectionCheckboxes = document.querySelectorAll('.' + sectionClass);
                            const sectionBtn = document.querySelector('[data-target="' + sectionClass + '"]');

                            if (sectionBtn) {
                                const allChecked = Array.from(sectionCheckboxes).every(cb => cb.checked);
                                sectionBtn.textContent = allChecked ? 'DeSelect Section' : 'Select Section';
                            }
                        }

                        updateMainButtonText();

                        selectAllBtn.addEventListener('click', function () {
                            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                            checkboxes.forEach(cb => cb.checked = !allChecked);

                            document.querySelectorAll('.section-toggle-btn').forEach(btn => {
                                btn.textContent = allChecked ? 'Select Section' : 'DeSelect Section';
                            });

                            updateMainButtonText();
                        });

                        document.querySelectorAll('.section-toggle-btn').forEach(button => {
                            button.addEventListener('click', function () {
                                const target = this.getAttribute('data-target');
                                const sectionCheckboxes = document.querySelectorAll('.' + target);
                                const allChecked = Array.from(sectionCheckboxes).every(cb => cb.checked);

                                sectionCheckboxes.forEach(cb => cb.checked = !allChecked);
                                this.textContent = allChecked ? 'Select Section' : 'DeSelect Section';

                                updateMainButtonText();
                            });
                        });

                        checkboxes.forEach(cb => {
                            cb.addEventListener('change', function () {
                                updateMainButtonText();

                                const classes = Array.from(this.classList);
                                const sectionClass = classes.find(cls => cls.startsWith('section-'));
                                if (sectionClass) {
                                    updateSectionButton(sectionClass);
                                }
                            });
                        });

                        document.querySelectorAll('.section-toggle-btn').forEach(btn => {
                            updateSectionButton(btn.getAttribute('data-target'));
                        });
                    });
                </script>

                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header text-white bg-light">
                        <h4 class="mb-0">
                            Role : {{ $role->name }}
                            <a href="{{ url('roles') }}" class="btn btn-light float-end">Back</a>
                        </h4>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ url('roles/' . $role->id . '/give-permissions') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                @error('permission')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <label class="fw-bold mb-3">Permissions</label>

                                <div class="mb-4">
                                    <button type="button" id="selectAllBtn" class="btn btn-secondary">Select All</button>
                                </div>

                                @foreach ($groupedPermissions as $module => $modulePermissions)
                                    @php
                                        $sectionClass = 'section-' . \Illuminate\Support\Str::slug($module);
                                    @endphp

                                    <div class="card mb-4 border">
                                        <div class="card-header bg-light permission-section-header">
                                            <h5 class="mb-0 text-primary">{{ $module }}</h5>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-primary section-toggle-btn"
                                                    data-target="{{ $sectionClass }}">
                                                Select Section
                                            </button>
                                        </div>

                                        <div class="card-body">
                                            <div class="row">
                                                @foreach ($modulePermissions as $permission)
                                                    <div class="col-md-3 mb-2">
                                                        <div class="form-check">
                                                            <input
                                                                class="form-check-input permission-checkbox {{ $sectionClass }}"
                                                                type="checkbox"
                                                                name="permission[]"
                                                                value="{{ $permission->name }}"
                                                                id="perm-{{ $permission->id }}"
                                                                {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                                                            >
                                                            <label class="form-check-label" for="perm-{{ $permission->id }}">
                                                                {{ $permission->name }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
