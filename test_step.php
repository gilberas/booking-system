<?php
ini_set('memory_limit', '512M');
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Step 1: Test the occupancy query alone
echo "Step 1: Testing BookingRoom query...\n";
$from = '2026-06-01';
$to = '2026-06-30';
$bookingRooms = \App\Models\BookingRoom::with('booking')
    ->whereHas('booking', fn($q) => $q->whereIn('status', ['confirmed', 'checked_in']))
    ->whereDate('check_in', '<=', $to)
    ->whereDate('check_out', '>', $from)
    ->get();
echo "  Found " . $bookingRooms->count() . " records\n";

echo "Step 2: Testing iteration...\n";
$records = collect();
$period = now()->parse($from);
$end = now()->parse($to);
$i = 0;
while ($period->lte($end)) {
    $i++;
    $date = $period->format('Y-m-d');
    $occupied = $bookingRooms->filter(fn($br) => $br->check_in->lte($date) && $br->check_out->gt($date))->count();
    $records->push(['date' => $date, 'occupied' => $occupied]);
    $period->addDay();
}
echo "  Iterated $i days, produced " . $records->count() . " records\n";

echo "SUCCESS\n";
