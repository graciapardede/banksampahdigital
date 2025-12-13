<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== ECOPROVIDER PRODUCTION API TEST ===\n\n";

// For testing, use production URLs
$productionUrls = [
    'status' => 'https://services.bsdgs.fun/api/status',
    'news' => 'https://services.bsdgs.fun/api/news',
    'events' => 'https://services.bsdgs.fun/api/events',
    'tips' => 'https://services.bsdgs.fun/api/tips',
];

echo "Testing Production EcoProvider API\n";
echo "================================================\n\n";

// Test each endpoint
foreach ($productionUrls as $name => $url) {
    echo "Testing $name endpoint: $url\n";
    
    try {
        $response = \Illuminate\Support\Facades\Http::timeout(10)->get($url);
        
        if ($response->successful()) {
            $data = $response->json();
            $itemCount = count($data['data'] ?? $data ?? []);
            echo "✓ Status: " . $response->status() . " - Retrieved " . $itemCount . " items\n";
        } else {
            echo "✗ Status: " . $response->status() . "\n";
        }
    } catch (\Exception $e) {
        echo "✗ Error: " . $e->getMessage() . "\n";
    }
    
    echo "\n";
}

echo "\nIntegration Test Complete!\n";
echo "================================================\n\n";

// Now test with local configured URLs
echo "\nLocal Configuration Test:\n";
echo "Environment: " . config('app.env') . "\n";
echo "ECO_PROVIDER_BASE_URL: " . env('ECO_PROVIDER_BASE_URL') . "\n";
echo "ECO_NEWS_API: " . env('ECO_NEWS_API') . "\n\n";

$service = app('App\Services\EcoProviderService');
$status = $service->checkStatus();
echo "Local Service Status: " . $status['status'] . "\n";
if (isset($status['error'])) {
    echo "Error: " . $status['error'] . "\n";
}

