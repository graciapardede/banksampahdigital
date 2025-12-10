<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\PasswordResetMail;

echo "=== TEST GMAIL CONFIGURATION ===\n\n";

// Test 1: Check mail configuration
echo "1. Email Configuration:\n";
echo "   MAIL_MAILER: " . config('mail.default') . "\n";
echo "   MAIL_HOST: " . config('mail.mailers.smtp.host') . "\n";
echo "   MAIL_PORT: " . config('mail.mailers.smtp.port') . "\n";
echo "   MAIL_USERNAME: " . config('mail.mailers.smtp.username') . "\n";
echo "   MAIL_FROM: " . config('mail.from.address') . "\n\n";

// Test 2: Try to send test email
echo "2. Testing Email Send...\n";
$user = User::where('email', 'graciapardede30@gmail.com')->first();

if (!$user) {
    echo "   ❌ User tidak ditemukan!\n";
    exit;
}

$resetCode = "123456";

try {
    Mail::to($user->email)->send(new PasswordResetMail($user, $resetCode));
    echo "   ✓ Email berhasil dikirim ke: {$user->email}\n";
    echo "   ✓ Kode Reset: {$resetCode}\n";
} catch (\Exception $e) {
    echo "   ❌ Email gagal terkirim!\n";
    echo "   Error: " . $e->getMessage() . "\n";
    echo "   \n   Solusi:\n";
    echo "   1. Pastikan Gmail account sudah enable 2-factor authentication\n";
    echo "   2. Generate App Password dari https://myaccount.google.com/apppasswords\n";
    echo "   3. Update MAIL_PASSWORD di .env dengan App Password tersebut\n";
    echo "   4. Restart PHP server\n";
}

echo "\n=== DONE ===\n";
