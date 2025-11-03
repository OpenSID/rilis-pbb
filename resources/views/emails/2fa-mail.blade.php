<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kode 2FA PBB</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #28a745;
            padding-bottom: 25px;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #28a745;
            margin: 0;
            font-size: 28px;
        }

        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: #28a745;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            color: white;
        }

        .otp-code {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
            color: white;
            font-size: 36px;
            font-weight: bold;
            text-align: center;
            padding: 25px;
            border-radius: 12px;
            letter-spacing: 8px;
            margin: 30px 0;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        .info-box {
            background-color: #d4edda;
            border-left: 5px solid #28a745;
            padding: 20px;
            margin: 25px 0;
            border-radius: 5px;
        }

        .warning-box {
            background-color: #fff3cd;
            border-left: 5px solid #ffc107;
            padding: 20px;
            margin: 25px 0;
            color: #856404;
            border-radius: 5px;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 25px;
            border-top: 2px solid #dee2e6;
            color: #6c757d;
            font-size: 14px;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            margin: 20px 0;
            font-weight: bold;
        }

        .stats {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
            text-align: center;
        }

        .stat-item {
            flex: 1;
            padding: 15px;
        }

        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
        }

        .stat-label {
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    @php
    $expires = config('otp.expires_minutes') ?? env('OTP_EXPIRES_MINUTES', 5);
    $maxSend = config('otp.max_send') ?? env('OTP_MAX_SEND', 1);
    $maxAttempts = config('otp.max_attempts') ?? env('OTP_MAX_ATTEMPTS', 3);
    @endphp

    <div class="container">
        <div class="header">
            <div class="logo">🔐</div>
            <h1>Kode 2FA PBB</h1>
            <p style="color: #6c757d; margin: 10px 0 0;">Sistem Autentikasi Dua Faktor</p>
        </div>

        <p style="font-size: 16px;">Halo,</p>

        <p>Anda telah meminta kode verifikasi 2FA (Two-Factor Authentication) untuk mengakses sistem PBB. Gunakan kode
            berikut untuk menyelesaikan proses autentikasi:</p>

        <div class="otp-code">
            {{ $otp }}
        </div>

        <div class="stats">
            <div class="stat-item">
                <div class="stat-number">{{ $expires }}</div>
                <div class="stat-label">Menit</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $maxSend }}x</div>
                <div class="stat-label">Penggunaan</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $maxAttempts }}</div>
                <div class="stat-label">Max Percobaan</div>
            </div>
        </div>

        <div class="info-box">
            <p><strong>📋 Informasi Penting:</strong></p>
            <ul style="margin: 10px 0;">
                <li>Kode ini berlaku selama <strong>{{ $expires }} menit</strong> dari waktu pengiriman</li>
                <li>Kode hanya dapat digunakan <strong>{{ $maxSend }} kali</strong></li>
                <li>Maksimal <strong>{{ $maxAttempts }} kali percobaan</strong> salah sebelum kode diblokir</li>
                <li>Setelah berhasil, 2FA akan aktif sebagai lapisan keamanan tambahan</li>
            </ul>
        </div>

        <div class="warning-box">
            <p><strong>⚠️ Peringatan Keamanan:</strong></p>
            <p>Jangan bagikan kode ini kepada siapa pun. Tim PBB tidak akan pernah meminta kode 2FA Anda melalui
                telepon, email balasan, atau cara lainnya. Jika Anda tidak meminta kode ini, mohon abaikan email ini dan
                segera hubungi administrator sistem.</p>
        </div>

        <p style="color: #6c757d; font-size: 14px;">
            <strong>Catatan:</strong> Setelah aktivasi berhasil, 2FA akan menjadi bagian dari proses login Anda. Anda
            akan diminta memasukkan kode ini setiap kali login.
        </p>

        <div class="footer">
            <p><strong>PBB</strong> - Sistem Dashboard Kabupaten</p>
            <p>Email ini dikirim secara otomatis oleh sistem. Harap jangan membalas email ini.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Semua hak dilindungi undang-undang.</p>
            <p style="font-size: 12px; margin-top: 15px;">
                Dikirim pada {{ now()->format('d/m/Y H:i:s') }} WIB
            </p>
        </div>
    </div>
</body>

</html>