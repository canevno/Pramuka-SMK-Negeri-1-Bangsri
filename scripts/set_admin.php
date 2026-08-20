<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$email = 'pramukasmkn1bangsri@gmail.com';

$user = \App\Models\User::where('email', $email)->first();
if ($user) {
    $user->is_admin = 1;
    if (! $user->email_verified_at) {
        $user->email_verified_at = date('Y-m-d H:i:s');
    }
    $user->save();
    echo "User updated to admin: {$email}\n";
} else {
    echo "User not found: {$email}\n";
}
