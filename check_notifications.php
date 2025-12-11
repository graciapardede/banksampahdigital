<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Redemption;
use App\Models\Notification;

echo "=== CHECK ADMIN USERS ===\n";
$admins = User::where('role', 'admin')->get();
echo "Total admins: " . $admins->count() . "\n";
foreach ($admins as $admin) {
    echo "ID: {$admin->id}, Name: {$admin->name}, Branch: {$admin->branch_id}\n";
}

echo "\n=== CHECK RECENT REDEMPTIONS ===\n";
$redemptions = Redemption::latest()->take(5)->get();
echo "Recent redemptions: " . $redemptions->count() . "\n";
foreach ($redemptions as $redemption) {
    echo "ID: {$redemption->id}, User: {$redemption->user_id}, Status: {$redemption->status}, Branch: {$redemption->branch_id}\n";
}

echo "\n=== CHECK NOTIFICATIONS TABLE ===\n";
$notifications = \Illuminate\Notifications\DatabaseNotification::latest()->take(10)->get();
echo "Recent notifications: " . $notifications->count() . "\n";
foreach ($notifications as $notif) {
    echo "ID: {$notif->id}, Notifiable ID: {$notif->notifiable_id}, Type: {$notif->type}\n";
    echo "Data: " . json_encode(json_decode($notif->data, true)) . "\n\n";
}
