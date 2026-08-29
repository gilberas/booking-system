<x-app-layout>
    <x-slot name="header"><h2 class="h4 mb-0">Edit Discount — {{ $discount->code }}</h2></x-slot>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.discounts.update', $discount) }}">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-4 mb-3"><label class="form-label">Code</label><input type="text" name="code" class="form-control" value="{{ old('code', $discount->code) }}" required></div>
                    <div class="col-md-4 mb-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" value="{{ old('name', $discount->name) }}" required></div>
                    <div class="col-md-2 mb-3"><label class="form-label">Type</label><select name="type" class="form-select"><option value="percentage" {{ $discount->type==='percentage'?'selected':'' }}>Percentage</option><option value="fixed" {{ $discount->type==='fixed'?'selected':'' }}>Fixed</option></select></div>
                    <div class="col-md-2 mb-3"><label class="form-label">Value</label><input type="number" step="0.01" name="value" class="form-control" value="{{ old('value', $discount->value) }}" required></div>
                    <div class="col-md-4 mb-3"><label class="form-label">Min Amount</label><input type="number" step="0.01" name="min_amount" class="form-control" value="{{ old('min_amount', $discount->min_amount) }}"></div>
                    <div class="col-md-4 mb-3"><label class="form-label">Max Uses</label><input type="number" name="max_uses" class="form-control" value="{{ old('max_uses', $discount->max_uses) }}"></div>
                    <div class="col-md-2 mb-3"><label class="form-label">Starts</label><input type="date" name="starts_at" class="form-control" value="{{ old('starts_at', $discount->starts_at?->format('Y-m-d')) }}"></div>
                    <div class="col-md-2 mb-3"><label class="form-label">Expires</label><input type="date" name="expires_at" class="form-control" value="{{ old('expires_at', $discount->expires_at?->format('Y-m-d')) }}"></div>
                    <div class="col-md-6 mb-3"><div class="form-check mt-4"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" class="form-check-input" value="1" id="is_active" {{ old('is_active', $discount->is_active) ? 'checked' : '' }}><label class="form-check-label" for="is_active">Active</label></div></div>
                </div>
                <div class="d-flex justify-content-end"><a href="{{ route('admin.discounts.index') }}" class="btn btn-outline-navy me-2">Cancel</a><button type="submit" class="btn btn-navy">Update</button></div>
            </form>
        </div>
    </div>
</x-app-layout>
