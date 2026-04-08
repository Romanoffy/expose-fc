<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Verifikasi Email - Expose FC</title>
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

        @keyframes shimmer {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-up {
            animation: slideUp 0.6s ease-out;
        }

        .animate-slide-down {
            animation: slideDown 0.3s ease-out;
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

        .input-focus-animation {
            transition: all 0.3s ease;
        }

        .input-focus-animation:focus {
            transform: translateY(-2px);
        }

        .success-animation {
            animation: slideDown 0.4s ease-out;
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

    <!-- Verify Container -->
    <div class="relative z-10 flex min-h-screen items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">

            <!-- Verify Card -->
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

                <!-- Header Info -->
                <div class="mb-8 text-center">
                    <h2 class="mb-2 text-2xl font-bold text-white">Verifikasi Email</h2>
                    <p class="text-sm text-slate-400">Masukkan password untuk melanjutkan verifikasi email Anda</p>
                </div>

                <!-- Alert Error -->
                @if (session('error'))
                    <div class="mb-6 flex animate-slide-down items-start gap-3 rounded-xl border border-red-500/30 bg-red-500/10 p-4">
                        <i class="fas fa-exclamation-circle mt-0.5 text-lg text-red-500"></i>
                        <div>
                            <p class="font-semibold text-red-500">Verifikasi Gagal</p>
                            <p class="text-sm text-red-400">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Success Alert -->
                @if (session('success'))
                    <div class="mb-6 flex animate-slide-down items-start gap-3 rounded-xl border border-green-500/30 bg-green-500/10 p-4">
                        <i class="fas fa-check-circle mt-0.5 text-lg text-green-500"></i>
                        <div>
                            <p class="font-semibold text-green-500">Berhasil!</p>
                            <p class="text-sm text-green-400">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Email Display -->
                <div class="mb-6 rounded-xl bg-slate-900/50 p-4 border border-slate-700">
                    <label class="mb-2 block text-xs font-medium text-slate-400 uppercase tracking-wider">Email Terdaftar</label>
                    <div class="flex items-center gap-3">
                        <i class="fas fa-envelope text-blue-500"></i>
                        <p class="text-lg font-semibold text-white break-all">{{ $email }}</p>
                    </div>
                </div>

                <!-- Verify Form -->
                <form action="{{ route('verify.password.confirm', $userId) }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Password Input -->
                    <div class="group relative">
                        <label for="password" class="mb-2 block text-sm font-medium text-slate-300">
                            Masukkan Password
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <i class="fas fa-lock text-slate-500 transition-colors group-focus-within:text-blue-500"></i>
                            </div>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Masukkan password Anda"
                                required
                                class="input-focus-animation w-full rounded-xl border-2 border-slate-700 bg-slate-900/50 py-3.5 pl-12 pr-12 text-white placeholder-slate-500 transition-all focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-500/20"
                            >
                            <button
                                type="button"
                                onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-500 transition-colors hover:text-slate-300"
                            >
                                <i id="toggleIcon" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="btn-shimmer relative w-full overflow-hidden rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 py-3.5 font-semibold text-white shadow-lg shadow-blue-500/30 transition-all duration-300 hover:-translate-y-0.5 hover:from-blue-700 hover:to-blue-800 hover:shadow-blue-500/50 focus:outline-none focus:ring-4 focus:ring-blue-500/50"
                    >
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            <i class="fas fa-check"></i>
                            Verifikasi Sekarang
                        </span>
                    </button>

                    <!-- Back Link -->
                    <p class="pt-2 text-center text-sm text-slate-400">
                        Kembali ke
                        <a href="/login" class="font-medium text-blue-400 transition-colors hover:text-blue-300 hover:underline">
                            Login
                        </a>
                    </p>
                </form>
            </div>

            <!-- Footer -->
            <p class="mt-6 text-center text-xs text-slate-500">
                © 2024 Expose FC. All rights reserved.
            </p>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Input animation on focus
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('scale-[1.02]');
            });
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('scale-[1.02]');
            });
        });
    </script>
</body>

</html>