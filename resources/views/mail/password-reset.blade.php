<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Reset Password</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            padding: 20px 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 16px;
            color: #333;
            margin-bottom: 20px;
        }
        .code-box {
            background: #f0fdf4;
            border: 2px solid #10b981;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
        }
        .code-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #059669;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .code {
            font-size: 48px;
            font-weight: 700;
            color: #059669;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
        }
        .expiry {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .expiry-text {
            font-size: 14px;
            color: #92400e;
            margin: 0;
        }
        .instructions {
            background: #f3f4f6;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .instructions h3 {
            margin-top: 0;
            color: #111;
            font-size: 16px;
        }
        .instructions ol {
            margin: 10px 0;
            padding-left: 20px;
        }
        .instructions li {
            margin: 8px 0;
            color: #555;
        }
        .footer {
            background: #f9fafb;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #666;
        }
        .footer a {
            color: #10b981;
            text-decoration: none;
        }
        .security-note {
            background: #fee2e2;
            border-left: 4px solid #ef4444;
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .security-note-text {
            font-size: 12px;
            color: #991b1b;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🔒 Reset Password</h1>
            <p style="margin: 10px 0 0; opacity: 0.9;">Green Saving</p>
        </div>

        <!-- Content -->
        <div class="content">
            <p class="greeting">
                Halo <strong>{{ $user->full_name ?? $user->name }}</strong>,
            </p>

            <p>
                Kami menerima permintaan untuk mereset password akun Anda. Gunakan kode di bawah untuk melanjutkan proses reset password.
            </p>

            <!-- Code Box -->
            <div class="code-box">
                <div class="code-label">Kode Reset Password</div>
                <div class="code">{{ $resetCode }}</div>
            </div>

            <!-- Expiry Warning -->
            <div class="expiry">
                <p class="expiry-text">
                    ⏰ Kode ini berlaku selama <strong>15 menit</strong>. Jangan bagikan kode ini kepada siapapun.
                </p>
            </div>

            <!-- Instructions -->
            <div class="instructions">
                <h3>Langkah-langkah Reset Password:</h3>
                <ol>
                    <li>Buka halaman <a href="{{ config('app.url') }}/forgot-password" style="color: #10b981; text-decoration: none;"><strong>lupa password</strong></a></li>
                    <li>Masukkan email Anda: <strong>{{ $user->email }}</strong></li>
                    <li>Salin kode reset di atas dan masukkan ke form verifikasi</li>
                    <li>Buat password baru yang kuat (minimal 8 karakter)</li>
                    <li>Selesai! Silakan login dengan password baru</li>
                </ol>
            </div>

            <!-- Security Note -->
            <div class="security-note">
                <p class="security-note-text">
                    ⚠️ Jika Anda tidak meminta reset password, abaikan email ini. Kode ini hanya berlaku 15 menit dan tidak akan berfungsi setelahnya.
                </p>
            </div>

            <p style="color: #666; margin-top: 30px; font-size: 14px;">
                Butuh bantuan? Hubungi kami di <a href="mailto:support@greensaving.com" style="color: #10b981; text-decoration: none;">support@greensaving.com</a>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="margin: 0; color: #999;">
                © {{ date('Y') }} Green Saving. Semua hak dilindungi.
            </p>
            <p style="margin: 5px 0 0; color: #999; font-size: 11px;">
                Email ini dikirim ke {{ $user->email }} karena permintaan reset password
            </p>
        </div>
    </div>
</body>
</html>
