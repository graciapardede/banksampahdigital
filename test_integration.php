<?php
/**
 * BankSampahDigital - EcoProvider Integration Test
 * 
 * Script ini melakukan testing konektivitas antara:
 * - BankSampahDigital (Main App) - Port 8000
 * - EcoProvider Service (API) - Port 8001
 * 
 * Gunakan:
 * php test_integration.php
 */

// Bootstrap Laravel
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Http;

// Color codes untuk terminal output
class Colors {
    const RESET = "\033[0m";
    const GREEN = "\033[32m";
    const RED = "\033[31m";
    const YELLOW = "\033[33m";
    const BLUE = "\033[34m";
    const CYAN = "\033[36m";
}

function success($message) {
    echo Colors::GREEN . "✓ " . $message . Colors::RESET . "\n";
}

function error($message) {
    echo Colors::RED . "✗ " . $message . Colors::RESET . "\n";
}

function warning($message) {
    echo Colors::YELLOW . "⚠ " . $message . Colors::RESET . "\n";
}

function info($message) {
    echo Colors::BLUE . "ℹ " . $message . Colors::RESET . "\n";
}

function header_section($title) {
    echo "\n" . Colors::CYAN . "=== " . $title . " ===" . Colors::RESET . "\n\n";
}

// ============================================================================
// TEST CONFIGURATION
// ============================================================================
header_section("CONFIGURATION CHECK");

$appEnv = config('app.env');
$appUrl = config('app.url');
$ecoProviderBaseUrl = env('ECO_PROVIDER_BASE_URL');

info("Environment: " . $appEnv);
info("App URL: " . $appUrl);
info("EcoProvider Base URL: " . $ecoProviderBaseUrl);

// ============================================================================
// TEST 1: LOCAL ENDPOINTS
// ============================================================================
header_section("TEST 1: ENDPOINT CONNECTIVITY");

$endpoints = [
    'News API' => env('ECO_NEWS_API'),
    'Events API' => env('ECO_EVENTS_API'),
    'Tips API' => env('ECO_TIPS_API'),
    'Status API' => env('ECO_STATUS_API'),
];

$allEndpointsOk = true;

foreach ($endpoints as $name => $url) {
    try {
        $response = Http::timeout(5)->get($url);
        
        if ($response->successful()) {
            success("$name: $url (HTTP " . $response->status() . ")");
            
            // Try to decode JSON
            $data = $response->json();
            if (isset($data['data'])) {
                info("  └─ Response has 'data' field with " . count($data['data']) . " items");
            } elseif (isset($data['status'])) {
                info("  └─ Response status: " . $data['status']);
            }
        } else {
            error("$name: $url (HTTP " . $response->status() . ")");
            $allEndpointsOk = false;
        }
    } catch (\Exception $e) {
        error("$name: " . $e->getMessage());
        $allEndpointsOk = false;
    }
}

// ============================================================================
// TEST 2: SERVICE CLASS INTEGRATION
// ============================================================================
header_section("TEST 2: SERVICE INTEGRATION");

try {
    $service = app('App\Services\EcoProviderService');
    
    // Test getNews
    try {
        $news = $service->getNews();
        if (!empty($news)) {
            success("EcoProviderService::getNews() - Retrieved " . count($news) . " items");
        } else {
            warning("EcoProviderService::getNews() - Empty response");
        }
    } catch (\Exception $e) {
        error("EcoProviderService::getNews() - " . $e->getMessage());
    }
    
    // Test getEvents
    try {
        $events = $service->getEvents();
        if (!empty($events)) {
            success("EcoProviderService::getEvents() - Retrieved " . count($events) . " items");
        } else {
            warning("EcoProviderService::getEvents() - Empty response");
        }
    } catch (\Exception $e) {
        error("EcoProviderService::getEvents() - " . $e->getMessage());
    }
    
    // Test getTips
    try {
        $tips = $service->getTips();
        if (!empty($tips)) {
            success("EcoProviderService::getTips() - Retrieved " . count($tips) . " items");
        } else {
            warning("EcoProviderService::getTips() - Empty response");
        }
    } catch (\Exception $e) {
        error("EcoProviderService::getTips() - " . $e->getMessage());
    }
    
    // Test checkStatus
    try {
        $status = $service->checkStatus();
        if ($status['status'] === 'ok') {
            success("EcoProviderService::checkStatus() - Status is OK");
        } else {
            warning("EcoProviderService::checkStatus() - Status: " . $status['status']);
            if (isset($status['error'])) {
                info("  └─ Error: " . $status['error']);
            }
        }
    } catch (\Exception $e) {
        error("EcoProviderService::checkStatus() - " . $e->getMessage());
    }
    
} catch (\Exception $e) {
    error("Failed to instantiate EcoProviderService: " . $e->getMessage());
}

// ============================================================================
// TEST 3: API AUTHENTICATION
// ============================================================================
header_section("TEST 3: AUTHENTICATION CHECK");

$apiKey = env('ECO_API_KEY');
$apiSecret = env('ECO_API_SECRET');

if (empty($apiKey) && empty($apiSecret)) {
    warning("No API credentials configured (optional for local development)");
} else {
    info("API Key configured: " . (strlen($apiKey) > 0 ? "Yes" : "No"));
    info("API Secret configured: " . (strlen($apiSecret) > 0 ? "Yes" : "No"));
}

// ============================================================================
// TEST 4: CORS CONFIGURATION
// ============================================================================
header_section("TEST 4: CORS CONFIGURATION");

$corsConfig = config('cors');
if (!empty($corsConfig)) {
    success("CORS configuration loaded");
    info("Allowed origins: " . count($corsConfig['allowed_origins']) . " configured");
    
    foreach ($corsConfig['allowed_origins'] as $origin) {
        info("  └─ " . $origin);
    }
} else {
    error("CORS configuration not found");
}

// ============================================================================
// TEST 5: ENVIRONMENT MISMATCH CHECK
// ============================================================================
header_section("TEST 5: ENVIRONMENT CONSISTENCY");

$productionOrigins = [
    'https://bsdgs.fun',
    'https://services.bsdgs.fun',
];

$localOrigins = [
    'http://127.0.0.1:8000',
    'http://127.0.0.1:8001',
];

$isProduction = $appEnv === 'production';
$baseUrlIsProduction = strpos($appUrl, 'https') === 0;

if ($isProduction && !$baseUrlIsProduction) {
    warning("APP_ENV is production but APP_URL is not HTTPS!");
} elseif (!$isProduction && $baseUrlIsProduction) {
    warning("APP_ENV is local but APP_URL is HTTPS!");
} else {
    success("Environment and URL are consistent");
}

// ============================================================================
// SUMMARY
// ============================================================================
header_section("SUMMARY");

if ($allEndpointsOk) {
    success("All endpoints are reachable!");
    echo "\n" . Colors::GREEN . "✓ Integration test passed! You can proceed with deployment." . Colors::RESET . "\n";
} else {
    error("Some endpoints are unreachable!");
    echo "\n" . Colors::YELLOW . "⚠ Please check the errors above and verify:" . Colors::RESET . "\n";
    echo "  1. EcoProvider Service is running on port 8001\n";
    echo "  2. Network connectivity between services\n";
    echo "  3. Firewall and port forwarding settings\n";
    echo "  4. .env configuration matches your setup\n";
}

echo "\n";
