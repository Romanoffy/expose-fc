<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Perubahan Email</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6;
            padding: 20px;
            line-height: 1.6;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .email-header {
            background: linear-gradient(135deg, #000efe 0%, #0056b3 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }
        
        .email-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .email-header p {
            font-size: 16px;
            opacity: 0.95;
        }
        
        .security-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            margin: 0 auto 20px;
            font-size: 40px;
            line-height: 80px;
            text-align: center;
        }
        
        .email-body {
            padding: 40px 30px;
        }
        
        .text-content {
            color: #4b5563;
            font-size: 15px;
            margin-bottom: 20px;
        }
        
        .text-content strong {
            color: #1f2937;
        }
        
        .email-change-section {
            background: #f9fafb;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }
        
        .email-box {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 12px 15px;
            margin: 10px 0;
        }
        
        .email-box-label {
            color: #6b7280;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        
        .email-box-value {
            color: #1f2937;
            font-size: 15px;
            font-weight: 600;
        }
        
        .arrow-icon {
            text-align: center;
            color: #000efe;
            font-size: 24px;
            margin: 10px 0;
        }
        
        .info-box {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 15px 20px;
            border-radius: 8px;
            margin: 25px 0;
        }
        
        .info-box p {
            color: #1e40af;
            font-size: 14px;
            margin: 0;
        }
        
        .info-box strong {
            color: #1e3a8a;
            display: block;
            margin-bottom: 5px;
        }
        
        .button-section {
            text-align: center;
            margin: 30px 0;
        }
        
        .btn-verify {
            display: inline-block;
            background: linear-gradient(135deg, #000efe 0%, #0056b3 100%);
            color: white;
            padding: 14px 40px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 14, 254, 0.2);
        }
        
        .btn-verify:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 14, 254, 0.3);
        }
        
        .link-section {
            background: #f9fafb;
            border-radius: 8px;
            padding: 15px 20px;
            margin: 20px 0;
        }
        
        .link-section p {
            color: #6b7280;
            font-size: 12px;
            margin: 5px 0;
            text-align: center;
        }
        
        .link-section a {
            color: #000efe;
            text-decoration: none;
            word-break: break-all;
            font-size: 13px;
        }
        
        .link-section a:hover {
            text-decoration: underline;
        }
        
        .alert-box {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px 20px;
            border-radius: 8px;
            margin: 25px 0;
        }
        
        .alert-box p {
            color: #92400e;
            font-size: 14px;
            margin: 0;
        }
        
        .action-section {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
        }
        
        .action-section h3 {
            color: #991b1b;
            font-size: 16px;
            margin-bottom: 10px;
        }
        
        .action-section p {
            color: #7f1d1d;
            font-size: 14px;
        }
        
        .email-footer {
            background: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        
        .email-footer p {
            color: #6b7280;
            font-size: 13px;
            margin: 5px 0;
        }
        
        .email-footer a {
            color: #000efe;
            text-decoration: none;
        }
        
        .email-footer a:hover {
            text-decoration: underline;
        }
        
        @media only screen and (max-width: 600px) {
            .email-body {
                padding: 30px 20px;
            }
            
            .email-header {
                padding: 30px 20px;
            }
            
            .email-header h1 {
                font-size: 24px;
            }
            
            .btn-verify {
                padding: 12px 30px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <div class="security-icon">🔄</div>
            <h1>Verifikasi Perubahan Email</h1>
            <p>Konfirmasi alamat email baru Anda</p>
        </div>
        
        <!-- Body -->
        <div class="email-body">
            <p class="text-content">
                Halo <strong>{{ $user->name }}</strong>,
            </p>
            
            <p class="text-content">
                Kami menerima permintaan untuk mengubah alamat email akun Anda di <strong>Expose FC</strong>.
            </p>
            
            <!-- Email Change Section -->
            <div class="email-change-section">
                <h3 style="color: #1f2937; font-size: 16px; margin-bottom: 15px;">Detail Perubahan Email</h3>
                
                <div class="email-box">
                    <div class="email-box-label">📧 Email Lama</div>
                    <div class="email-box-value">{{ $user->email }}</div>
                </div>
                
                <div class="arrow-icon">⬇️</div>
                
                <div class="email-box">
                    <div class="email-box-label">✨ Email Baru</div>
                    <div class="email-box-value">{{ $newEmail }}</div>
                </div>
            </div>
            
            <!-- Info Box -->
            <div class="info-box">
                <strong>ℹ️ Informasi Penting</strong>
                <p>Klik tombol di bawah untuk memverifikasi dan mengaktifkan email baru Anda. Setelah diverifikasi, Anda akan menggunakan email baru untuk login.</p>
            </div>
            
            <!-- Button Section -->
            <div class="button-section">
                <a href="{{ $url }}" class="btn-verify" style="color: #ffffff !important; text-decoration: none !important;">Verifikasi Email Baru</a>
            </div>
            
            <p style="text-align: center; color: #6b7280; font-size: 13px; margin: 15px 0;">
                Atau salin dan tempel tautan di bawah ini ke browser Anda:
            </p>
            
            <!-- Link Section -->
            <div class="link-section">
                <p><a href="{{ $url }}">{{ $url }}</a></p>
            </div>
            
            <!-- Action Section -->
            <div class="action-section">
                <h3>❌ Bukan Anda yang Melakukan?</h3>
                <p>Jika Anda tidak melakukan perubahan ini, abaikan email ini dan email Anda akan tetap tidak berubah. Hubungi kami jika ada yang mencurigakan.</p>
            </div>
            
            <!-- Alert Box -->
            <div class="alert-box">
                <p><strong>⏰ Link verifikasi ini akan berlaku selama 24 jam.</strong> Setelah itu, Anda perlu meminta link verifikasi baru melalui pengaturan profil.</p>
            </div>
            
            <p class="text-content" style="margin-top: 30px;">
                <strong>Tips Keamanan:</strong>
            </p>
            <ul style="color: #4b5563; font-size: 14px; margin-left: 20px;">
                <li>Pastikan Anda mengenali perubahan email ini</li>
                <li>Jangan bagikan link verifikasi ke siapapun</li>
                <li>Gunakan email yang aman dan masih aktif</li>
                <li>Periksa email secara berkala untuk notifikasi penting</li>
            </ul>
        </div>
        
        <!-- Footer -->
        <div class="email-footer">
            <p><strong>Expose FC</strong></p>
            <p>Email otomatis dari sistem. Mohon tidak membalas email ini.</p>
            <p>Jika ada pertanyaan, hubungi kami di <a href="mailto:support@exposefc.com">support@exposefc.com</a></p>
            
            <p style="margin-top: 20px; font-size: 12px; color: #9ca3af;">
                © {{ date('Y') }} Expose FC. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>