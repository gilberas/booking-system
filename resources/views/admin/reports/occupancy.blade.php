<x-app-layout>
    <x-slot name="header"><h2 class="h4 mb-0">Occupancy Report</h2></x-slot>
    @include('admin.reports._filters')
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead><tr><th>Date</th><th class="text-end">Occupied</th><th class="text-end">Available</th><th class="text-end">Rate</th></tr></thead>
                <tbody>
                    @foreach ($records as $r)
                        <tr>
                            <td>{{ $r['date'] }}</td>
                            <td class="text-end">{{ $r['occupied'] }}</td>
                            <td class="text-end">{{ $r['available'] }}</td>
                            <td class="text-end">{{ $r['rate'] }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <p class="text-muted mt-2 small">{{ $totalRooms }} rooms · Avg occupancy {{ number_format($avgRate, 1) }}%</p>
</x-app-layout>
