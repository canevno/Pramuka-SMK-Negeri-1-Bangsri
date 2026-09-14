<?php
$viewsDir = __DIR__ . '/../resources/views';
$routesDir = __DIR__ . '/../routes';

function collectRouteUsages($dir) {
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    $usages = [];
    foreach ($it as $file) {
        if (!$file->isFile()) continue;
        $path = $file->getPathname();
        if (!preg_match('/\.blade\.php$/', $path)) continue;
        $lines = file($path);
        foreach ($lines as $num => $line) {
            if (strpos($line, "route(") !== false) {
                if (preg_match_all('/route\(\s*["\']([^"\']+)["\']/', $line, $m)) {
                    foreach ($m[1] as $name) {
                        $usages[$name][] = $path . ':' . ($num+1);
                    }
                }
            }
        }
    }
    return $usages;
}

function collectDefinedRoutes($dir) {
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    $names = [];
    foreach ($it as $file) {
        if (!$file->isFile()) continue;
        $path = $file->getPathname();
        if (!preg_match('/\.php$/', $path)) continue;
        $lines = file($path);
        foreach ($lines as $num => $line) {
            if (strpos($line, "->name(") !== false || preg_match('/->name\(/', $line)) {
                if (preg_match_all('/->name\(\s*["\']([^"\']+)["\']/', $line, $m)) {
                    foreach ($m[1] as $name) {
                        $names[$name][] = $path . ':' . ($num+1);
                    }
                }
            }
        }
    }
    return $names;
}

$usages = collectRouteUsages($viewsDir);
$defined = collectDefinedRoutes($routesDir);

$missing = [];
foreach ($usages as $name => $locations) {
    if (!isset($defined[$name])) {
        $missing[$name] = $locations;
    }
}

if (empty($missing)) {
    echo "No missing route names found.\n";
    exit(0);
}

foreach ($missing as $name => $locs) {
    echo "MISSING: $name\n";
    foreach ($locs as $l) echo "  - $l\n";
}

echo "\nDefined routes found: " . count($defined) . "\n";

?>