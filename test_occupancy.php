<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$service = $app->make(\App\Services\Admin\ReportService::class);
$count = \App\Models\BookingRoom::count();
echo "BookingRoom count: $count\n";
$totalRooms = max(1, \App\Models\Room::count());
echo "TotalRooms: $totalRooms\n";

$start = microtime(true);
$result = $service->occupancy('2026-06-01', '2026-06-05');
$elapsed = round((microtime(true) - $start) * 1000, 2);
echo 'OK: ' . count($result['records']) . ' days, ' . $elapsed . "ms, avg rate {$result['avgRate']}%\n";
