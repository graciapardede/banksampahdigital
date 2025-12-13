<?php
// Bootstrap Laravel
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Test EcoProviderService
$service = app('App\Services\EcoProviderService');
$news = $service->getNews();

echo "=== EcoProviderService Test ===\n";
echo "Number of news: " . count($news) . "\n";
echo "News data type: " . gettype($news) . "\n";

if (count($news) > 0) {
    echo "\n=== First News Item ===\n";
    echo json_encode($news[0], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
} else {
    echo "\nNo news returned! Check:\n";
    echo "- .env ECO_NEWS_API value\n";
    echo "- API endpoint availability\n";
    echo "- Check laravel.log for errors\n";
}
