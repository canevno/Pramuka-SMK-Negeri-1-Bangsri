<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Student;

function getListsForAmbalan($ambalan){
    $normalized = strtoupper(trim($ambalan));
    if ($normalized === 'PA') {
        $variants = ['PA', 'Putra', 'putra', 'L', 'Laki-laki', 'Laki-Laki'];
    } elseif ($normalized === 'PI') {
        $variants = ['PI', 'Putri', 'putri', 'P', 'Perempuan'];
    } else {
        $variants = [];
    }

    $sanggaQuery = Student::query();
    $subSanggaQuery = Student::query();

    if (!empty($variants)) {
        $sanggaQuery->whereIn('ambalan', $variants);
        $subSanggaQuery->whereIn('ambalan', $variants);
    }

    $sanggaList = $sanggaQuery->whereNotNull('sangga')->where('sangga','!=','')->pluck('sangga')->map(fn($item)=>trim(preg_replace('/[0-9]/','',$item)))->unique()->values();
    $subSanggaList = $subSanggaQuery->whereNotNull('sub_sangga')->where('sub_sangga','!=','')->pluck('sub_sangga')->unique()->values();

    return [
        'ambalan'=> $ambalan,
        'sangga' => $sanggaList->toArray(),
        'subs' => $subSanggaList->toArray(),
    ];
}

$data = [
    getListsForAmbalan('PA'),
    getListsForAmbalan('PI'),
    // overall
    (function(){
        $s = Student::whereNotNull('sangga')->where('sangga','!=','')->pluck('sangga')->map(fn($item)=>trim(preg_replace('/[0-9]/','',$item)))->unique()->values()->toArray();
        $ss = Student::whereNotNull('sub_sangga')->where('sub_sangga','!=','')->pluck('sub_sangga')->unique()->values()->toArray();
        return ['ambalan'=>'ALL','sangga'=>$s,'subs'=>$ss];
    })()
];

echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
