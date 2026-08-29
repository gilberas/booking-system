<x-app-layout>
    <x-slot name="header"><div class="d-flex justify-content-between"><h2 class="h4 mb-0">{{ $customer->name }}</h2></div></x-slot>
    <div class="row">
        <div class="col-md-5">
            <div class="card mb-3">
                <div class="card-header">Details</div>
                <div class="card-body">
                    <dl class="row mb-0 small">
                        <dt class="col-sm-4">Email</dt><dd class="col-sm-8">{{ $customer->email }}</dd>
                        <dt class="col-sm-4">Phone</dt><dd class="col-sm-8">{{ $customer->phone ?? '—' }}</dd>
                        <dt class="col-sm-4">Active</dt><dd class="col-sm-8">{{ $customer->is_active ? 'Yes' : 'No' }}</dd>
                        <dt class="col-sm-4">Joined</dt><dd class="col-sm-8">{{ $customer->created_at->format('M d, Y') }}</dd>
                        @if ($customer->customerProfile)
                            <dt class="col-sm-4">DOB</dt><dd class="col-sm-8">{{ $customer->customerProfile->date_of_birth?->format('M d, Y') ?? '—' }}</dd>
                            <dt class="col-sm-4">Nationality</dt><dd class="col-sm-8">{{ $customer->customerProfile->nationality ?? '—' }}</dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">Recent Bookings</div>
                <div class="list-group list-group-flush">
                    @forelse ($customer->bookings as $b)
                        <a href="{{ route('admin.manage-bookings.show', $b) }}" class="list-group-item list-group-item-action d-flex justify-content-between">
                            <span><strong>{{ $b->booking_number }}</strong> — {{ $b->hotel->name }}</span>
                            <span class="badge bg-{{ $b->status === 'confirmed' ? 'success' : ($b->status === 'cancelled' ? 'danger' : 'warning') }}">{{ ucfirst($b->status) }}</span>
                        </a>
                    @empty
                        <div class="list-group-item text-muted">No bookings.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
