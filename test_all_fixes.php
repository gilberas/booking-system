<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== BUG 1: Monthly Revenue (SQLite YEAR/MONTH compatibility) ===\n";
try {
    $service = $app->make(\App\Services\Admin\ReportService::class);
    $result = $service->monthlyRevenue('2025-01-01', '2026-12-31');
    echo "OK: " . count($result['records']) . " months, total \${$result['total']}\n";
} catch (\Throwable $e) {
    echo "FAIL: " . $e->getMessage() . "\n";
}

echo "\n=== BUG 2: Occupancy (N+1 query elimination) ===\n";
try {
    $start = microtime(true);
    $result = $service->occupancy('2026-06-01', '2026-06-30');
    $elapsed = round((microtime(true) - $start) * 1000);
    echo "OK: " . count($result['records']) . " days, {$elapsed}ms, avg rate {$result['avgRate']}%\n";
} catch (\Throwable $e) {
    echo "FAIL: " . $e->getMessage() . "\n";
}

echo "\n=== BUG 3: Manager route access ===\n";
$middleware = new \App\Http\Middleware\CheckRole();
$manager = \App\Models\User::where('email', 'manager@booking.com')->first();
Auth::login($manager);

$managerRoutes = [
    'admin.employees.index',
    'admin.discounts.index',
    'admin.contents.index',
];
$allowedRoles = ['administrator', 'hotel-manager'];

foreach ($managerRoutes as $routeName) {
    try {
        $url = route($routeName);
        $request = \Illuminate\Http\Request::create($url, 'GET');
        $request->setUserResolver(fn() => auth()->user());
        $response = $middleware->handle($request, fn($r) => response('OK', 200), ...$allowedRoles);
        echo "[OK] {$routeName}\n";
    } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
        echo "[FAIL] {$routeName} => 403\n";
    }
}

// Also confirm admin-only routes still blocked for manager
$adminOnly = ['admin.dashboard'];
foreach ($adminOnly as $routeName) {
    $url = route($routeName);
    $request = \Illuminate\Http\Request::create($url, 'GET');
    $request->setUserResolver(fn() => $manager);
    try {
        $response = $middleware->handle($request, fn($r) => response('OK', 200), 'administrator');
        echo "[UNEXPECTED] {$routeName} => 200 (should be 403)\n";
    } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
        echo "[OK] {$routeName} => 403 (correctly blocked)\n";
    }
}

Auth::logout();
