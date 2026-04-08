<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Email Sudah Terverifikasi - Expose FC</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'expose-blue': '#0d6efd',
                        'expose-dark': '#0a58ca',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
                opacity: 0.3;
            }

            50% {
                transform: translateY(-100px) rotate(180deg);
                opacity: 0.6;
            }
        }

        @keyframes checkmark {
            0% {
                transform: scale(0) rotate(-45deg);
                opacity: 0;
            }

            50% {
                transform: scale(1.2) rotate(10deg);
            }

            100% {
                transform: scale(1) rotate(0);
                opacity: 1;
            }
        }

        .animate-slide-up {
            animation: slideUp 0.6s ease-out;
        }

        .animate-checkmark {
            animation: checkmark 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55) 0.3s both;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 15s infinite;
        }

        .particle:nth-child(1) {
            width: 80px;
            height: 80px;
            left: 10%;
            animation-delay: 0s;
        }

        .particle:nth-child(2) {
            width: 60px;
            height: 60px;
            left: 20%;
            animation-delay: 2s;
        }

        .particle:nth-child(3) {
            width: 40px;
            height: 40px;
            left: 70%;
            animation-delay: 4s;
        }

        .particle:nth-child(4) {
            width: 50px;
            height: 50px;
            left: 80%;
            animation-delay: 6s;
        }

        .particle:nth-child(5) {
            width: 70px;
            height: 70px;
            left: 50%;
            animation-delay: 3s;
        }

        .btn-shimmer::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-shimmer:hover::before {
            animation: shimmer 0.8s ease;
        }

        @keyframes shimmer {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }

        .success-icon i {
            font-size: 40px;
            color: white;
        }
    </style>
</head>

<body class="min-h-screen overflow-x-hidden bg-gradient-to-br from-blue-700 via-blue-900 to-slate-900">

    <!-- Particles Background -->
    <div class="pointer-events-none fixed inset-0 z-0 overflow-hidden">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <!-- Success Container -->
    <div class="relative z-10 flex min-h-screen items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">

            <!-- Success Card -->
            <div class="animate-slide-up rounded-3xl border border-white/10 bg-slate-800/95 p-8 shadow-2xl backdrop-blur-xl md:p-10">

                <!-- Logo Section -->
                <div class="mb-8 text-center">
                    <a href="/">
                        <div class="mb-3 flex items-center justify-center gap-3">
                            <i class="fas fa-futbol text-4xl text-blue-500"></i>
                            <h1 class="text-3xl font-bold text-white md:text-4xl">Expose FC</h1>
                        </div>
                    </a>
                </div>

                <!-- Success Icon -->
                <div class="success-icon animate-checkmark">
                    <i class="fas fa-check"></i>
                </div>

                <!-- Success Message -->
                <div class="mb-8 text-center">
                    <h2 class="mb-3 text-2xl font-bold text-green-400">Email Sudah Terverifikasi</h2>
                    <p class="text-slate-400">
                        Email Anda telah terverifikasi sebelumnya. Akun Anda sudah aktif dan siap digunakan.
                    </p>
                </div>

                <!-- Info Box -->
                <div class="mb-8 rounded-xl border border-green-500/20 bg-green-500/5 p-4">
                    <div class="flex items-center gap-3 mb-3">
                        <i class="fas fa-info-circle text-green-500"></i>
                        <span class="text-sm font-semibold text-green-400">Status Akun</span>
                    </div>
                    <p class="text-sm text-slate-300">
                        Anda dapat langsung melakukan login dengan email dan password Anda.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <a href="/login" class="btn-shimmer relative block w-full overflow-hidden rounded-xl bg-gradient-to-r from-green-600 to-green-700 py-3.5 font-semibold text-white shadow-lg shadow-green-500/30 transition-all duration-300 hover:-translate-y-0.5 hover:from-green-700 hover:to-green-800 hover:shadow-green-500/50 focus:outline-none focus:ring-4 focus:ring-green-500/50 text-center">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            <i class="fas fa-sign-in-alt"></i>
                            Kembali ke Login
                        </span>
                    </a>
                    <a href="/" class="block w-full rounded-xl border-2 border-slate-600 py-3.5 font-semibold text-white transition-all duration-300 hover:border-blue-500 hover:bg-blue-500/10 text-center">
                        <span class="flex items-center justify-center gap-2">
                            <i class="fas fa-home"></i>
                            Kembali ke Beranda
                        </span>
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <p class="mt-6 text-center text-xs text-slate-500">
                © 2024 Expose FC. All rights reserved.
            </p>
        </div>
    </div>

</body>

</html>