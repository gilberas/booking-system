<x-app-layout>
    <x-slot name="header"><div class="d-flex justify-content-between"><h2 class="h4 mb-0">{{ $employee->user->name }}</h2></div></x-slot>
    <div class="card">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Code</dt><dd class="col-sm-9">{{ $employee->employee_code }}</dd>
                <dt class="col-sm-3">Email</dt><dd class="col-sm-9">{{ $employee->user->email }}</dd>
                <dt class="col-sm-3">Phone</dt><dd class="col-sm-9">{{ $employee->user->phone ?? '—' }}</dd>
                <dt class="col-sm-3">Position</dt><dd class="col-sm-9">{{ $employee->position ?? '—' }}</dd>
                <dt class="col-sm-3">Hotel</dt><dd class="col-sm-9">{{ $employee->hotel?->name ?? '—' }}</dd>
                <dt class="col-sm-3">Hire Date</dt><dd class="col-sm-9">{{ $employee->hire_date?->format('M d, Y') ?? '—' }}</dd>
                <dt class="col-sm-3">Salary</dt><dd class="col-sm-9">{{ $employee->salary ? '$'.number_format($employee->salary, 2) : '—' }}</dd>
                <dt class="col-sm-3">Status</dt><dd class="col-sm-9">{!! $employee->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' !!}</dd>
            </dl>
        </div>
    </div>
</x-app-layout>
