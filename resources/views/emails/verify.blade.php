<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
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
            <div class="security-icon">✉️</div>
            <h1>Verifikasi Email Anda</h1>
            <p>Satu langkah lagi untuk menyelesaikan pendaftaran</p>
        </div>
        
        <!-- Body -->
        <div class="email-body">
            <p class="text-content">
                Halo <strong>{{ $user->name }}</strong>,
            </p>
            
            <p class="text-content">
                Terima kasih telah mendaftar di <strong>Expose FC</strong>. Untuk menyelesaikan proses pendaftaran, mohon verifikasi alamat email Anda terlebih dahulu.
            </p>
            
            <!-- Info Box -->
            <div class="info-box">
                <strong>ℹ️ Mengapa kami meminta ini?</strong>
                <p>Verifikasi email memastikan akun Anda aman dan dapat digunakan untuk menerima notifikasi penting.</p>
            </div>
            
            <!-- Button Section -->
            <div class="button-section">
                <a href="{{ $url }}" class="btn-verify" style="color: #ffffff !important; text-decoration: none !important;">Verifikasi Email Saya</a>
            </div>
            
            <p style="text-align: center; color: #6b7280; font-size: 13px; margin: 15px 0;">
                Atau salin dan tempel tautan di bawah ini ke browser Anda:
            </p>
            
            <!-- Link Section -->
            <div class="link-section">
                <p><a href="{{ $url }}">{{ $url }}</a></p>
            </div>
            
            <!-- Alert Box -->
            <div class="alert-box">
                <p><strong>⏰ Link verifikasi ini akan berlaku selama 24 jam.</strong> Jika Anda tidak melakukan pendaftaran ini, abaikan email ini.</p>
            </div>
            
            <p class="text-content" style="margin-top: 30px;">
                <strong>Tips Keamanan:</strong>
            </p>
            <ul style="color: #4b5563; font-size: 14px; margin-left: 20px;">
                <li>Jangan bagikan link verifikasi ini ke siapapun</li>
                <li>Pastikan Anda mengklik link dari email resmi kami</li>
                <li>Jika link kadaluarsa, Anda dapat meminta link baru</li>
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