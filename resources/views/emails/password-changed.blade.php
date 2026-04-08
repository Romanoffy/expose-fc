<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Berhasil Diubah</title>
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
        
        .alert-box {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .alert-box p {
            color: #92400e;
            font-size: 14px;
            margin: 0;
        }
        
        .alert-box strong {
            color: #78350f;
            display: block;
            margin-bottom: 5px;
        }
        
        .info-section {
            background: #f9fafb;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .info-item:last-child {
            border-bottom: none;
        }
        
        .info-label {
            color: #6b7280;
            font-weight: 600;
            font-size: 14px;
        }
        
        .info-value {
            color: #1f2937;
            font-weight: 500;
            font-size: 14px;
            text-align: right;
            max-width: 60%;
            word-break: break-word;
        }
        
        .text-content {
            color: #4b5563;
            font-size: 15px;
            margin-bottom: 20px;
        }
        
        .text-content strong {
            color: #1f2937;
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
            margin-bottom: 15px;
        }
        
        .btn-contact {
            display: inline-block;
            background: #dc2626;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: background 0.3s ease;
        }
        
        .btn-contact:hover {
            background: #b91c1c;
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
        
        .social-links {
            margin-top: 20px;
        }
        
        .social-links a {
            display: inline-block;
            margin: 0 8px;
            color: #6b7280;
            font-size: 20px;
            text-decoration: none;
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
            
            .info-item {
                flex-direction: column;
                gap: 5px;
            }
            
            .info-value {
                text-align: left;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <div class="security-icon">🔒</div>
            <h1>Password Berhasil Diubah</h1>
            <p>Keamanan akun Anda adalah prioritas kami</p>
        </div>
        
        <!-- Body -->
        <div class="email-body">
            <p class="text-content">
                Halo <strong>{{ $user->name }}</strong>,
            </p>
            
            <p class="text-content">
                Kami menginformasikan bahwa password akun Anda di <strong>Expose FC</strong> telah berhasil diubah.
            </p>
            
            <!-- Alert Box -->
            <div class="alert-box">
                <strong>⚠️ Penting untuk Keamanan</strong>
                <p>Jika Anda tidak melakukan perubahan ini, segera hubungi tim kami untuk mengamankan akun Anda.</p>
            </div>
            
            <!-- Info Section -->
            <div class="info-section">
                <h3 style="color: #1f2937; font-size: 16px; margin-bottom: 15px;">Detail Perubahan</h3>
                
                <div class="info-item">
                    <span class="info-label">📅 Waktu Perubahan:</span>
                    <span class="info-value">{{ $changedAt }}</span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">🌐 IP Address:</span>
                    <span class="info-value">{{ $ipAddress }}</span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">💻 Perangkat:</span>
                    <span class="info-value">{{ $userAgent }}</span>
                </div>
            </div>
            
            <p class="text-content">
                Password baru Anda telah aktif dan dapat digunakan untuk login ke akun Anda.
            </p>
            
            <!-- Action Section -->
            <div class="action-section">
                <h3>❌ Bukan Anda yang Melakukan?</h3>
                <p>Jika Anda tidak mengenali aktivitas ini, segera hubungi kami untuk mengamankan akun Anda.</p>
                <a href="mailto:support@exposefc.com" class="btn-contact" style="color: #ffffff !important; text-decoration: none !important;">Hubungi Support</a>
            </div>
            
            <p class="text-content" style="margin-top: 30px;">
                <strong>Tips Keamanan:</strong>
            </p>
            <ul style="color: #4b5563; font-size: 14px; margin-left: 20px;">
                <li>Gunakan password yang kuat dan unik</li>
                <li>Jangan bagikan password ke siapapun</li>
                <li>Aktifkan two-factor authentication jika tersedia</li>
                <li>Update password secara berkala</li>
            </ul>
        </div>
        
        <!-- Footer -->
        <div class="email-footer">
            <p><strong>Expose FC</strong></p>
            <p>Email otomatis dari sistem. Mohon tidak membalas email ini.</p>
            <p>Jika ada pertanyaan, hubungi kami di <a href="mailto:support@exposefc.com">support@exposefc.com</a></p>
            
            {{-- <div class="social-links">
                <a href="#" title="Facebook">📘</a>
                <a href="#" title="Instagram">📷</a>
                <a href="#" title="Twitter">🐦</a>
                <a href="#" title="YouTube">📺</a>
            </div> --}}
            
            <p style="margin-top: 20px; font-size: 12px; color: #9ca3af;">
                © {{ date('Y') }} Expose FC. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>