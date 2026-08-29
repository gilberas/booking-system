<?php
ini_set('memory_limit', '512M');
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Testing now()...\n";
try {
    $n = now();
    echo "now(): " . get_class($n) . " " . $n->format('Y-m-d') . "\n";
} catch (\Throwable $e) {
    echo "now() failed: " . $e->getMessage() . "\n";
}

echo "Testing now()->parse()...\n";
try {
    $from = '2026-06-01';
    $p = now()->parse($from);
    echo "parsed: " . get_class($p) . " " . $p->format('Y-m-d') . "\n";
} catch (\Throwable $e) {
    echo "parse failed: " . $e->getMessage() . "\n";
}

echo "Testing addDay...\n";
try {
    $p->addDay();
    echo "after addDay: " . $p->format('Y-m-d') . "\n";
} catch (\Throwable $e) {
    echo "addDay failed: " . $e->getMessage() . "\n";
}

echo "Testing while loop (5 iterations)...\n";
try {
    $period = now()->parse('2026-06-01');
    $end = now()->parse('2026-06-05');
    $i = 0;
    while ($period->lte($end) && $i < 100) {
        $i++;
        $date = $period->format('Y-m-d');
        echo "  iteration $i: $date\n";
        if ($i > 10) { echo "  breaking after 10\n"; break; }
        $period->addDay();
    }
} catch (\Throwable $e) {
    echo "loop failed: " . $e->getMessage() . "\n";
}
echo "Done\n";
