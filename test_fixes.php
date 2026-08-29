<?php
ini_set('memory_limit', '512M');
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== BUG 1: Monthly Revenue (no SQLite YEAR/MONTH error) ===\n";
try {
    $service = app(\App\Services\Admin\ReportService::class);
    $result = $service->monthlyRevenue('2025-01-01', '2026-12-31');
    echo "OK: " . count($result['records']) . " months, total \${$result['total']}\n";
} catch (\Throwable $e) {
    echo "FAIL: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== BUG 2: Occupancy (no infinite loop / N+1 queries) ===\n";
try {
    $count = \App\Models\BookingRoom::count();
    echo "BookingRoom count: $count\n";
    $start = microtime(true);
    \Illuminate\Support\Facades\DB::enableQueryLog();
    $result = $service->occupancy('2026-06-01', '2026-06-05');
    $elapsed = round((microtime(true) - $start) * 1000, 1);
    $queryCount = count(\Illuminate\Support\Facades\DB::getQueryLog());
    echo "OK: " . count($result['records']) . " days, {$elapsed}ms, avg rate {$result['avgRate']}%, query count: $queryCount\n";
} catch (\Throwable $e) {
    echo "FAIL: " . $e->getMessage() . "\n";
}

echo "\n=== BUG 3: Manager route access ===\n";
$middleware = new \App\Http\Middleware\CheckRole();
$manager = \App\Models\User::where('email', 'manager@booking.com')->first();
if (!$manager) {
    echo "Manager user not found\n";
    exit(1);
}
auth()->login($manager);

$allowedRoutes = ['admin.employees.index', 'admin.discounts.index', 'admin.contents.index'];
$blockedRoutes = ['admin.dashboard'];

foreach ($allowedRoutes as $name) {
    try {
        $r = \Illuminate\Http\Request::create(route($name), 'GET');
        $r->setUserResolver(fn() => auth()->user());
        $middleware->handle($r, fn($r) => response('OK'), 'administrator', 'hotel-manager');
        echo "[OK] {$name} (allowed)\n";
    } catch (\Exception $e) {
        echo "[FAIL] {$name} => " . $e->getMessage() . "\n";
    }
}
foreach ($blockedRoutes as $name) {
    try {
        $r = \Illuminate\Http\Request::create(route($name), 'GET');
        $r->setUserResolver(fn() => auth()->user());
        $middleware->handle($r, fn($r) => response('OK'), 'administrator');
        echo "[UNEXPECTED] {$name} => allowed (should be blocked)\n";
    } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
        echo "[OK] {$name} => blocked (403)\n";
    }
}

echo "\nAll checks complete.\n";
