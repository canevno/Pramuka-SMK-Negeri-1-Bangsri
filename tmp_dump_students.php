<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$rows = DB::table('students')
    ->select('nama','sangga','sub_sangga')
    ->where('kelas_asal','like','%X%')
    ->whereRaw("(sangga IS NULL OR sangga='')")
    ->limit(10)
    ->get();

echo json_encode($rows->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
