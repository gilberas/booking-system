<?php
ini_set('memory_limit', '512M');
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "=== Full Manager Walkthrough ===\n\n";

// Login as manager
$manager = \App\Models\User::where('email', 'manager@booking.com')->first();
if (!$manager) { echo "Manager not found\n"; exit(1); }

$pages = [
    'Staff Dashboard' => '/dashboard',
    'Hotels' => '/admin/hotels',
    'Room Types' => '/admin/hotels/1/room-types',
    'Rooms' => '/admin/room-types/1/rooms',
    'Amenities' => '/admin/amenities',
    'Reports Index' => '/admin/reports',
    'Monthly Revenue' => '/admin/reports/monthly-revenue?from=2026-01-01&to=2026-12-31',
    'Occupancy' => '/admin/reports/occupancy?from=2026-06-01&to=2026-06-30',
    'Room Performance' => '/admin/reports/room-performance?from=2026-01-01&to=2026-12-31',
    'Cancelled Bookings' => '/admin/reports/cancelled-bookings?from=2026-01-01&to=2026-12-31',
    'Payments' => '/admin/reports/payments?from=2026-01-01&to=2026-12-31',
    'Customers Report' => '/admin/reports/customers?from=2026-01-01&to=2026-12-31',
    'Manage Bookings' => '/admin/manage-bookings',
    'Payments List' => '/admin/payments',
    'Customers List' => '/admin/customers',
    'Employees' => '/admin/employees',
    'Discounts' => '/admin/discounts',
    'Contents' => '/admin/contents',
];

$request = \Illuminate\Http\Request::capture();
$request->server->set('REQUEST_URI', '/');
$request->server->set('SERVER_NAME', '127.0.0.1');
$request->server->set('SERVER_PORT', 80);
$request->server->set('HTTP_HOST', '127.0.0.1');

$session = $app->make(\Illuminate\Session\Store::class);
$request->setSession($session);

// Authenticate manager
auth()->login($manager);

$errors = [];
foreach ($pages as $name => $uri) {
    try {
        $req = \Illuminate\Http\Request::create($uri, 'GET');
        $req->setUserResolver(fn() => $manager);
        $req->setSession($session);
        $response = $kernel->handle($req);
        $status = $response->getStatusCode();
        $mark = $status < 400 ? 'OK' : ($status == 500 ? 'ERR' : 'WARN');
        echo "[{$mark}] {$name} => {$status}";
        if ($status >= 400) {
            $body = substr((string) $response->getContent(), 0, 100);
            echo (str_contains($body, 'SQLSTATE') || str_contains($body, 'FatalError')) ? " SQL_ERROR" : "";
            $errors[] = $name;
        }
        echo "\n";
    } catch (\Throwable $e) {
        echo "[ERR] {$name} => {$e->getMessage()}\n";
        $errors[] = $name;
    }
}

echo "\n";
echo count($errors) > 0 ? "FAILURES: " . implode(', ', $errors) : "All pages pass.\n";
