<?php
require __DIR__ . '/../vendor/autoload.php';
$rc = new ReflectionClass(\App\Http\Controllers\Admin\AttendanceController::class);
$rm = $rc->getMethod('exportWord');
$params = $rm->getParameters();
echo "Method exportWord in ";
foreach ($params as $i => $p) {
    echo "param[$i]: name=" . $p->getName() . " optional=" . ($p->isOptional() ? 'yes' : 'no') . "\n";
}
echo "total=" . count($params) . "\n";
