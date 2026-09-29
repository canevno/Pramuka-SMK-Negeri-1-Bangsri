<?php
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap the app to access the router
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$router = $app->make('router');
$routeCollection = $router->getRoutes();

$defined = [];
foreach ($routeCollection as $route) {
    $name = $route->getName();
    if ($name) $defined[$name] = true;
}

// Scan views for route('name') usages
$usages = [];
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/../resources/views'));
foreach ($files as $f) {
    if (! $f->isFile()) continue;
    if (substr($f->getFilename(), -6) !== '.blade.php') continue;
    $content = file_get_contents($f->getPathname());
    if (preg_match_all('/route\(\s*(["\'])([^"\']+)\1/', $content, $m, PREG_SET_ORDER)) {
        foreach ($m as $match) {
            $usages[$match[2]][] = $f->getPathname();
        }
    }
}

$missing = [];
foreach ($usages as $name => $files) {
    if (! isset($defined[$name])) {
        $missing[$name] = $files;
    }
}

if (empty($missing)) {
    echo "No missing named routes found in views.\n";
    exit(0);
}

echo "Missing route names used in views:\n\n";
foreach ($missing as $name => $files) {
    echo "- $name\n";
    foreach (array_unique($files) as $f) {
        echo "    " . $f . "\n";
    }
    echo "\n";
}

exit(1);
