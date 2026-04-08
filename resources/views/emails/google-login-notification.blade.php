<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Login Google</title>
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
        
        .info-box {
            background: #d1fae5;
            border-left: 4px solid #10b981;
            padding: 15px 20px;
            border-radius: 8px;
            margin: 25px 0;
        }
        
        .info-box p {
            color: #065f46;
            font-size: 14px;
            margin: 0;
        }
        
        .info-box strong {
            color: #064e3b;
            display: block;
            margin-bottom: 5px;
        }
        
        .login-details {
            background: #f9fafb;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }
        
        .detail-item {
            display: flex;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .detail-item:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: #374151;
            width: 140px;
            font-size: 14px;
        }
        
        .detail-value {
            color: #6b7280;
            font-size: 14px;
            flex: 1;
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
        
        .button-section {
            text-align: center;
            margin: 30px 0;
        }
        
        .btn-action {
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
            margin: 5px;
        }
        
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 14, 254, 0.3);
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
            
            .btn-action {
                padding: 12px 30px;
                font-size: 14px;
            }
            
            .detail-item {
                flex-direction: column;
            }
            
            .detail-label {
                width: 100%;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <div class="security-icon">🔐</div>
            <h1>Notifikasi Login</h1>
            <p>Login berhasil dengan Google</p>
        </div>
        
        <!-- Body -->
        <div class="email-body">
            <p class="text-content">
                Halo <strong>{{ $user->name }}</strong>,
            </p>
            
            <p class="text-content">
                Akun Anda baru saja berhasil login ke <strong>Expose FC</strong> menggunakan akun Google.
            </p>
            
            <!-- Info Box -->
            <div class="info-box">
                <strong>✅ Login Berhasil</strong>
                <p>{{ $isNewUser ? 'Selamat datang! Akun Anda telah berhasil dibuat dan Anda sudah login.' : 'Anda telah berhasil masuk ke akun Anda.' }}</p>
            </div>
            
            <!-- Login Details -->
            <div class="login-details">
                <h3 style="color: #1f2937; margin-bottom: 15px; font-size: 16px;">Detail Login:</h3>
                <div class="detail-item">
                    <div class="detail-label">📧 Email:</div>
                    <div class="detail-value">{{ $user->email }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">🕐 Waktu Login:</div>
                    <div class="detail-value">{{ $loginTime }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">🌐 IP Address:</div>
                    <div class="detail-value">{{ $ipAddress }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">💻 Perangkat:</div>
                    <div class="detail-value">{{ $userAgent }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">🔑 Metode:</div>
                    <div class="detail-value">Google OAuth 2.0</div>
                </div>
            </div>
            
            <!-- Alert Box -->
            <div class="alert-box">
                <p><strong>⚠️ Bukan Anda yang login?</strong> Jika Anda tidak melakukan login ini, segera hubungi tim support kami untuk mengamankan akun Anda.</p>
            </div>
            
            <!-- Button Section -->
            <div class="button-section">
                <a href="{{ url('/') }}" class="btn-action" style="color: #ffffff !important; text-decoration: none !important;">Kunjungi Website</a>
            </div>
            
            <p class="text-content" style="margin-top: 30px;">
                <strong>Tips Keamanan Akun:</strong>
            </p>
            <ul style="color: #4b5563; font-size: 14px; margin-left: 20px;">
                <li>Pastikan Anda keluar dari akun setelah selesai menggunakan</li>
                <li>Jangan gunakan perangkat publik untuk login</li>
                <li>Aktifkan keamanan dua faktor di akun Google Anda</li>
                <li>Periksa aktivitas login secara berkala</li>
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