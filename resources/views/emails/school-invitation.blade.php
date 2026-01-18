<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Admin Sekolah</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .email-container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 3px solid #3b82f6;
            margin-bottom: 30px;
        }

        h1 {
            color: #1e40af;
            margin: 0;
            font-size: 24px;
        }

        .school-info {
            background-color: #eff6ff;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }

        .school-name {
            font-size: 18px;
            font-weight: bold;
            color: #1e40af;
        }

        .token-box {
            background-color: #f8fafc;
            border: 2px dashed #3b82f6;
            padding: 20px;
            text-align: center;
            border-radius: 6px;
            margin: 25px 0;
        }

        .token {
            font-size: 24px;
            font-weight: bold;
            color: #1e40af;
            letter-spacing: 2px;
            font-family: 'Courier New', monospace;
        }

        .token-label {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: #3b82f6;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }

        .btn:hover {
            background-color: #2563eb;
        }

        .instructions {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
        }

        .instructions h3 {
            margin-top: 0;
            color: #92400e;
        }

        .instructions ol {
            margin: 10px 0;
            padding-left: 20px;
        }

        .instructions li {
            margin: 8px 0;
        }

        .expiry-info {
            background-color: #fee2e2;
            border-left: 4px solid #ef4444;
            padding: 12px;
            margin: 20px 0;
            font-size: 14px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>🎓 Undangan Admin Sekolah</h1>
        </div>

        <p>Halo,</p>

        <p>Anda telah diundang untuk bergabung sebagai <strong>Admin Sekolah</strong> untuk:</p>

        <div class="school-info">
            <div class="school-name">{{ $sekolah->nama ?? 'Sekolah' }}</div>
            <div style="font-size: 14px; color: #64748b; margin-top: 5px;">
                NPSN: {{ $sekolah->npsn ?? '-' }}
            </div>
        </div>

        <p>Untuk melanjutkan, silakan gunakan <strong>Token Undangan</strong> berikut saat mendaftar:</p>

        <div class="token-box">
            <div class="token-label">Token Undangan Anda</div>
            <div class="token">{{ $token }}</div>
        </div>

        <div style="text-align: center;">
            <a href="{{ $registrationUrl }}" class="btn">Daftar Sekarang</a>
        </div>

        <div class="instructions">
            <h3>📋 Cara Mendaftar:</h3>
            <ol>
                <li>Klik tombol "Daftar Sekarang" di atas</li>
                <li>Isi formulir registrasi dengan data Anda</li>
                <li>Masukkan Token Undangan di atas pada kolom yang tersedia</li>
                <li>Selesaikan proses registrasi</li>
                <li>Verifikasi email Anda (jika diperlukan)</li>
                <li>Login dan mulai mengelola data sekolah</li>
            </ol>
        </div>

        <div class="expiry-info">
            <strong>⚠️ Perhatian:</strong> Token ini berlaku hingga <strong>{{ $expiresAt->format('d/m/Y H:i') }}
                WIB</strong>.
            Pastikan Anda mendaftar sebelum waktu tersebut.
        </div>

        <p>Jika Anda tidak merasa meminta undangan ini, silakan abaikan email ini.</p>

        <div class="footer">
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
            <p>Jika Anda memiliki pertanyaan, silakan hubungi administrator sistem.</p>
        </div>
    </div>
</body>

</html>