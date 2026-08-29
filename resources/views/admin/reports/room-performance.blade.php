<x-app-layout>
    <x-slot name="header"><h2 class="h4 mb-0">Room Performance</h2></x-slot>
    @include('admin.reports._filters')
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead><tr><th>Room</th><th>Type</th><th>Hotel</th><th class="text-end">Bookings</th><th>Status</th></tr></thead>
                <tbody>
                    @foreach ($records as $r)
                        <tr>
                            <td>#{{ $r->room_number }}</td>
                            <td>{{ $r->roomType?->name ?? '—' }}</td>
                            <td>{{ $r->hotel?->name ?? '—' }}</td>
                            <td class="text-end">{{ $r->bookingRooms_count }}</td>
                            <td><span class="badge bg-{{ $r->status === 'available' ? 'success' : ($r->status === 'occupied' ? 'warning' : 'danger') }}">{{ ucfirst($r->status) }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
