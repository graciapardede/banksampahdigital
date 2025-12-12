<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Google OAuth Configuration Check ===\n\n";

echo "1. Environment Variables:\n";
echo "   GOOGLE_CLIENT_ID: " . (env('GOOGLE_CLIENT_ID') ? "✓ Set" : "✗ Missing") . "\n";
echo "   GOOGLE_CLIENT_SECRET: " . (env('GOOGLE_CLIENT_SECRET') ? "✓ Set" : "✗ Missing") . "\n";
echo "   GOOGLE_REDIRECT_URI: " . env('GOOGLE_REDIRECT_URI') . "\n\n";

echo "2. Services Config:\n";
$config = config('services.google');
echo "   client_id: " . ($config['client_id'] ? "✓ Set" : "✗ Missing") . "\n";
echo "   client_secret: " . ($config['client_secret'] ? "✓ Set" : "✗ Missing") . "\n";
echo "   redirect: " . $config['redirect'] . "\n\n";

echo "3. Socialite Check:\n";
try {
    $driver = \Laravel\Socialite\Facades\Socialite::driver('google');
    echo "   Socialite Google driver: ✓ Available\n";
} catch (\Exception $e) {
    echo "   Socialite Google driver: ✗ Error - " . $e->getMessage() . "\n";
}

echo "\n4. GoogleAuthController:\n";
$controllerPath = app_path('Http/Controllers/GoogleAuthController.php');
echo "   File exists: " . (file_exists($controllerPath) ? "✓ Yes" : "✗ No") . "\n";

echo "\n5. Routes Check:\n";
$routes = \Illuminate\Support\Facades\Route::getRoutes();
$googleRoutes = $routes->getRoutesByName();
echo "   auth.google: " . (isset($googleRoutes['auth.google']) ? "✓ Defined" : "✗ Missing") . "\n";
echo "   auth.google.callback: " . (isset($googleRoutes['auth.google.callback']) ? "✓ Defined" : "✗ Missing") . "\n";

echo "\n=== Verification Complete ===\n";
?>
