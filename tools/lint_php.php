<?php
$dirs = [
    'app', 'routes', 'resources', 'database', 'bootstrap', 'config', 'tests', 'public'
];

$errors = [];
foreach ($dirs as $d) {
    if (!is_dir($d)) {
        continue;
    }
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($d));
    foreach ($it as $f) {
        if (! $f->isFile()) continue;
        if (substr($f->getFilename(), -4) !== '.php') continue;
        $path = $f->getPathname();
        $output = [];
        $ret = 0;
        exec('php -l '.escapeshellarg($path).' 2>&1', $output, $ret);
        if ($ret !== 0) {
            $errors[$path] = implode("\n", $output);
        }
    }
}

// Check top-level php files
$topFiles = ['artisan', 'index.php'];
foreach ($topFiles as $t) {
    if (is_file($t)) {
        $output = [];
        $ret = 0;
        exec('php -l '.escapeshellarg($t).' 2>&1', $output, $ret);
        if ($ret !== 0) {
            $errors[$t] = implode("\n", $output);
        }
    }
}

if (empty($errors)) {
    echo "No PHP syntax errors found in checked directories.".PHP_EOL;
    exit(0);
}

foreach ($errors as $file => $msg) {
    echo "---- ERROR: ". $file ." ----\n";
    echo $msg ."\n\n";
}

exit(1);
