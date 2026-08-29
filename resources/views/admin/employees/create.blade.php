<x-app-layout>
    <x-slot name="header"><h2 class="h4 mb-0">Create Employee</h2></x-slot>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.employees.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" required></div>
                    <div class="col-md-6 mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
                    <div class="col-md-6 mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
                    <div class="col-md-6 mb-3"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control"></div>
                    <div class="col-md-6 mb-3"><label class="form-label">Hotel</label><select name="hotel_id" class="form-select"><option value="">—</option>@foreach($hotels as $h)<option value="{{ $h->id }}">{{ $h->name }}</option>@endforeach</select></div>
                    <div class="col-md-3 mb-3"><label class="form-label">Position</label><input type="text" name="position" class="form-control"></div>
                    <div class="col-md-3 mb-3"><label class="form-label">Hire Date</label><input type="date" name="hire_date" class="form-control"></div>
                </div>
                <div class="d-flex justify-content-end"><a href="{{ route('admin.employees.index') }}" class="btn btn-outline-navy me-2">Cancel</a><button type="submit" class="btn btn-navy">Create</button></div>
            </form>
        </div>
    </div>
</x-app-layout>
