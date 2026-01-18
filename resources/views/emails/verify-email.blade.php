<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
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

        .logo {
            margin-bottom: 15px;
        }

        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .content {
            margin: 25px 0;
        }

        .btn-container {
            text-align: center;
            margin: 30px 0;
        }

        .btn {
            display: inline-block;
            padding: 14px 35px;
            background-color: #3b82f6;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #2563eb;
        }

        .info-box {
            background-color: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 15px;
            margin: 20px 0;
        }

        .warning-box {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
        }

        .url-box {
            background-color: #f8fafc;
            border: 2px dashed #cbd5e1;
            padding: 15px;
            border-radius: 6px;
            word-wrap: break-word;
            font-size: 12px;
            color: #64748b;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 12px;
        }

        .regards {
            margin-top: 25px;
            font-weight: bold;
            color: #1e40af;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">🎓</div>
            <h1>Verifikasi Alamat Email</h1>
        </div>

        <div class="greeting">
            Halo, <strong>{{ $user->name }}</strong>!
        </div>

        <div class="content">
            <p>Terima kasih telah mendaftar di <strong>SERASI BINTUNI</strong>.</p>

            <p>Untuk melanjutkan, silakan verifikasi alamat email Anda dengan mengklik tombol di bawah ini:</p>
        </div>

        <div class="btn-container">
            <a href="{{ $verificationUrl }}" class="btn">Verifikasi Alamat Email</a>
        </div>

        <div class="info-box">
            <strong>📧 Mengapa perlu verifikasi?</strong><br>
            Verifikasi email memastikan bahwa Anda adalah pemilik sah dari alamat email ini dan membantu menjaga
            keamanan akun Anda.
        </div>

        <div class="warning-box">
            <strong>⚠️ Penting:</strong> Jika Anda tidak membuat akun di sistem kami, abaikan email ini. Tidak ada
            tindakan lebih lanjut yang diperlukan.
        </div>

        <div class="regards">
            Salam,<br>
            Tim SERASI BINTUNI
        </div>

        <div class="url-box">
            <p style="margin: 0 0 10px 0; font-weight: bold; color: #475569;">Jika tombol tidak berfungsi:</p>
            Salin dan tempel URL berikut ke browser Anda:<br>
            <a href="{{ $verificationUrl }}" style="color: #3b82f6; word-break: break-all;">{{ $verificationUrl }}</a>
        </div>

        <div class="footer">
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
            <p>© {{ date('Y') }} SERASI BINTUNI - Sistem Perencanaan Terintegrasi</p>
        </div>
    </div>
</body>

</html>