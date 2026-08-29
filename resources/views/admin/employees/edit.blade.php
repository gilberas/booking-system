<x-app-layout>
    <x-slot name="header"><h2 class="h4 mb-0">Edit Employee — {{ $employee->user->name }}</h2></x-slot>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.employees.update', $employee) }}">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3"><label class="form-label">Position</label><input type="text" name="position" class="form-control" value="{{ old('position', $employee->position) }}"></div>
                    <div class="col-md-6 mb-3"><label class="form-label">Hotel</label><select name="hotel_id" class="form-select"><option value="">—</option>@foreach($hotels as $h)<option value="{{ $h->id }}" {{ $employee->hotel_id == $h->id ? 'selected' : '' }}>{{ $h->name }}</option>@endforeach</select></div>
                    <div class="col-md-4 mb-3"><label class="form-label">Hire Date</label><input type="date" name="hire_date" class="form-control" value="{{ old('hire_date', $employee->hire_date?->format('Y-m-d')) }}"></div>
                    <div class="col-md-4 mb-3"><div class="form-check mt-4"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active" {{ old('is_active', $employee->is_active) ? 'checked' : '' }}><label class="form-check-label" for="is_active">Active</label></div></div>
                </div>
                <div class="d-flex justify-content-end"><a href="{{ route('admin.employees.index') }}" class="btn btn-outline-navy me-2">Cancel</a><button type="submit" class="btn btn-navy">Update</button></div>
            </form>
        </div>
    </div>
</x-app-layout>
