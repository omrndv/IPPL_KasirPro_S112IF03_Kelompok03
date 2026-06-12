<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Pendaftaran Akun - KasirPro</title>
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 40px 20px;
            color: #1e293b;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 24px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.03);
        }
        .header {
            background-color: #2563eb;
            padding: 24px;
            text-align: center;
            color: #ffffff;
        }
        .header-logo {
            display: inline-block;
            width: 36px;
            height: 36px;
            line-height: 36px;
            background-color: #ffffff;
            color: #2563eb;
            font-weight: 900;
            font-size: 18px;
            border-radius: 12px;
            margin-bottom: 8px;
        }
        .header-title {
            font-size: 18px;
            font-weight: 900;
            letter-spacing: -0.025em;
            margin: 0;
        }
        .content {
            padding: 40px 32px;
            text-align: center;
        }
        .title {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 12px;
        }
        .text {
            font-size: 14px;
            line-height: 1.6;
            color: #64748b;
            margin-bottom: 32px;
        }
        .otp-box {
            display: inline-block;
            background-color: #eff6ff;
            color: #2563eb;
            font-size: 32px;
            font-weight: 900;
            letter-spacing: 0.2em;
            padding: 16px 32px;
            border-radius: 16px;
            border: 1px solid #dbeafe;
            margin-bottom: 32px;
        }
        .footer {
            padding: 24px 32px;
            border-top: 1px solid #f1f5f9;
            background-color: #fafafa;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-logo">K</div>
            <div class="header-title">KASIRPRO</div>
        </div>
        <div class="content">
            <h2 class="title">Selamat Datang di KasirPro!</h2>
            <p class="text">
                Terima kasih telah melakukan pendaftaran akun. Gunakan kode One-Time Password (OTP) di bawah ini untuk memverifikasi alamat email Anda dan mengaktifkan akun:
            </p>
            <div class="otp-box">{{ $otp }}</div>
            <p class="text" style="margin-bottom: 0; font-size: 12px;">
                * Kode OTP ini berlaku selama <strong>15 menit</strong>. Jangan bagikan kode ini kepada siapa pun demi keamanan akun Anda. Jika Anda tidak merasa melakukan pendaftaran ini, silakan abaikan email ini.
            </p>
        </div>
        <div class="footer">
            &copy; 2026 KasirPro. Smart POS untuk bisnis bertumbuh.<br>
            Dikirim secara otomatis. Mohon tidak membalas email ini.
        </div>
    </div>
</body>
</html>
