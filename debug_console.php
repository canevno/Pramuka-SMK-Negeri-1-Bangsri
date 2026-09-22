<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$ref = new ReflectionClass($kernel);
$getArtisan = $ref->getMethod('getArtisan');
$getArtisan->setAccessible(true);
$artisan = $getArtisan->invoke($kernel);
var_dump(get_class($artisan));
var_dump($artisan->getLaravel() ? get_class($artisan->getLaravel()) : null);
$all = $artisan->all();
var_dump(array_key_exists('serve', $all));
if (array_key_exists('serve', $all)) {
    $serve = $all['serve'];
    var_dump(get_class($serve));
    var_dump($serve->getLaravel() ? get_class($serve->getLaravel()) : null);
}
