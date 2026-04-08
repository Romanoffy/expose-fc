<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Registrasi - Expose FC</title>
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
            0%, 100% {
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

        @keyframes progressGrow {
            from {
                width: 0%;
            }
            to {
                width: var(--progress-width);
            }
        }

        .animate-slide-up {
            animation: slideUp 0.6s ease-out;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 15s infinite;
        }

        .particle:nth-child(1) { width: 80px; height: 80px; left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 60px; height: 60px; left: 20%; animation-delay: 2s; }
        .particle:nth-child(3) { width: 40px; height: 40px; left: 70%; animation-delay: 4s; }
        .particle:nth-child(4) { width: 50px; height: 50px; left: 80%; animation-delay: 6s; }
        .particle:nth-child(5) { width: 70px; height: 70px; left: 50%; animation-delay: 3s; }

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

        .password-strength-bar {
            transition: all 0.4s ease;
            animation: progressGrow 0.4s ease-out;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(148, 163, 184, 0.3), transparent);
        }

        .divider span {
            padding: 0 12px;
            color: rgba(148, 163, 184, 0.7);
            font-size: 13px;
            font-weight: 500;
        }

        .social-btn {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }

        .social-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transition: left 0.5s ease;
        }

        .social-btn:hover::before {
            left: 100%;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-700 via-blue-900 to-slate-900 min-h-screen overflow-x-hidden">
    
    <!-- Particles Background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <!-- Register Container -->
    <div class="relative z-10 min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            
            <!-- Register Card -->
            <div class="bg-slate-800/95 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/10 p-8 md:p-10 animate-slide-up">
                
                <!-- Logo Section -->
                <div class="text-center mb-8">
                    <a href="/">
                        <div class="flex items-center justify-center gap-3 mb-3">
                            <i class="fas fa-futbol text-4xl text-blue-500"></i>
                            <h1 class="text-3xl md:text-4xl font-bold text-white">Expose FC</h1>
                        </div>
                    </a>
                </div>

                <!-- Register Form -->
                <form action="/user/regular" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <!-- Name Input -->
                    <div class="relative group">
                        <label for="name" class="block text-sm font-medium text-slate-300 mb-2">
                            Full Name
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-user text-slate-500 group-focus-within:text-blue-500 transition-colors"></i>
                            </div>
                            <input 
                                type="text" 
                                id="name"
                                name="name" 
                                value="{{old('name')}}"
                                placeholder="Enter your full name"
                                required
                                class="input-focus-animation w-full pl-12 pr-4 py-3.5 bg-slate-900/50 border-2 border-slate-700 rounded-xl text-white placeholder-slate-500 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 focus:outline-none transition-all"
                            >
                        </div>
                    </div>

                    <!-- Email Input -->
                    <div class="relative group">
                        <label for="email" class="block text-sm font-medium text-slate-300 mb-2">
                            Email Address
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-slate-500 group-focus-within:text-blue-500 transition-colors"></i>
                            </div>
                            <input 
                                type="email" 
                                id="email"
                                name="email" 
                                value="{{old('email')}}"
                                placeholder="name@example.com"
                                required
                                class="input-focus-animation w-full pl-12 pr-4 py-3.5 bg-slate-900/50 border-2 border-slate-700 rounded-xl text-white placeholder-slate-500 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 focus:outline-none transition-all"
                            >
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="relative group">
                        <label for="password" class="block text-sm font-medium text-slate-300 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-slate-500 group-focus-within:text-blue-500 transition-colors"></i>
                            </div>
                            <input 
                                type="password" 
                                id="password"
                                name="password" 
                                placeholder="Min. 8 characters"
                                minlength="8"
                                required
                                class="input-focus-animation w-full pl-12 pr-12 py-3.5 bg-slate-900/50 border-2 border-slate-700 rounded-xl text-white placeholder-slate-500 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 focus:outline-none transition-all"
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-500 hover:text-slate-300 transition-colors"
                            >
                                <i id="toggleIcon" class="fas fa-eye"></i>
                            </button>
                        </div>
                        
                        <!-- Password Strength Indicator -->
                        <div class="mt-2">
                            <div class="h-1.5 bg-slate-700/50 rounded-full overflow-hidden">
                                <div id="strengthBar" class="h-full password-strength-bar rounded-full" style="width: 0%; --progress-width: 0%;"></div>
                            </div>
                            <p id="strengthText" class="text-xs text-slate-500 mt-1.5"></p>
                        </div>
                    </div>

                    <!-- Terms & Privacy -->
                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-start gap-2 cursor-pointer group flex-1">
                            <input 
                                type="checkbox" 
                                id="terms"
                                required
                                class="mt-0.5 w-4 h-4 rounded border-2 border-slate-600 bg-slate-900/50 text-blue-600 focus:ring-2 focus:ring-blue-500/50 focus:ring-offset-0 cursor-pointer transition-all"
                            >
                            <span class="text-slate-400 group-hover:text-slate-300 transition-colors">
                                I agree to the <a href="#" class="text-blue-400 hover:underline">Terms & Conditions</a>
                            </span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="relative w-full py-3.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-blue-500/50 transition-all duration-300 overflow-hidden btn-shimmer"
                    >
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            <i class="fas fa-user-plus"></i>
                            Create Account
                        </span>
                    </button>
                </form>

                <!-- Divider -->
                <div class="divider">
                    <span>Or sign up with</span>
                </div>

                <!-- Social Registration Buttons -->
                <div class="space-y-3">
                    <!-- Google Registration -->
                    <a href="/auth/google" class="social-btn relative block w-full overflow-hidden rounded-xl border-2 border-slate-600 bg-slate-900/50 py-3.5 text-center font-semibold text-white transition-all hover:border-blue-500 hover:bg-slate-800">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                            </svg>
                            Daftar dengan Google
                        </span>
                    </a>

                    {{-- <!-- GitHub Registration (Optional) -->
                    <a href="/auth/github" class="social-btn relative block w-full overflow-hidden rounded-xl border-2 border-slate-600 bg-slate-900/50 py-3.5 text-center font-semibold text-white transition-all hover:border-slate-400 hover:bg-slate-800">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            <i class="fab fa-github"></i>
                            Daftar dengan GitHub
                        </span>
                    </a> --}}
                </div>

                <!-- Sign In Link -->
                <p class="text-center text-sm text-slate-400 pt-6">
                    Already have an account? 
                    <a href="/login" class="text-blue-400 hover:text-blue-300 font-medium hover:underline transition-colors">
                        Sign In
                    </a>
                </p>
            </div>

            <!-- Footer -->
            <p class="text-center text-slate-500 text-xs mt-6">
                © 2024 Expose FC. All rights reserved.
            </p>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Toggle Password Visibility
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

        // Password Strength Checker
        const passwordInput = document.getElementById('password');
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            let strengthLabel = '';
            let color = '';

            // Calculate strength
            if (password.length >= 5) strength++;
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/\d/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;

            // Determine strength level
            if (password.length === 0) {
                strengthLabel = '';
                color = '';
                strengthBar.style.setProperty('--progress-width', '0%');
            } else if (strength <= 2) {
                strengthLabel = 'Weak password';
                color = 'bg-red-500';
                strengthBar.style.setProperty('--progress-width', '33%');
            } else if (strength <= 3) {
                strengthLabel = 'Medium password';
                color = 'bg-yellow-500';
                strengthBar.style.setProperty('--progress-width', '66%');
            } else {
                strengthLabel = 'Strong password';
                color = 'bg-green-500';
                strengthBar.style.setProperty('--progress-width', '100%');
            }

            // Update UI
            strengthBar.className = `h-full password-strength-bar rounded-full ${color}`;
            strengthText.textContent = strengthLabel;
            strengthText.className = `text-xs mt-1.5 ${color.replace('bg-', 'text-')}`;
        });

        // Input animation on focus
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('scale-[1.01]');
            });
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('scale-[1.01]');
            });
        });
    </script>
</body>

</html>