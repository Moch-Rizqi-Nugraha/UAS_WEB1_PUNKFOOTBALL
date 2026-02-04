<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - Punk Football</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-slide-in-left {
            animation: slideInLeft 0.6s ease-out;
        }

        .animate-slide-in-right {
            animation: slideInRight 0.6s ease-out;
        }

        .animate-pulse {
            animation: pulse 2s ease-in-out infinite;
        }

        .dashboard-gradient {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .input-focus {
            transition: all 0.3s ease;
        }

        .input-focus:focus {
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }

        .btn-primary-hover {
            transition: all 0.3s ease;
        }

        .btn-primary-hover:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(220, 38, 38, 0.3);
        }

        .football-icon {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 6px -1px rgba(220, 38, 38, 0.3);
        }
    </style>
</head>
<body class="dashboard-gradient min-h-screen font-['Roboto']">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="football-pattern absolute inset-0"></div>
    </div>

    <div class="relative min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Side - Branding -->
                <div class="hidden lg:block animate-slide-in-left">
                    <div class="text-center lg:text-left">
                        <div class="football-icon w-20 h-20 mx-auto lg:mx-0 mb-6">
                            <span class="text-3xl text-white">⚽</span>
                        </div>
                        <h1 class="text-5xl font-['Bebas_Neue'] text-gray-900 mb-4 tracking-wider">
                            PUNK FOOTBALL
                        </h1>
                        <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                            Join our community and start managing your football events today. Connect with players, coaches, and fans in one powerful platform.
                        </p>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-red-600 mb-2">{{ number_format(1500) }}+</div>
                                <div class="text-sm text-gray-500 uppercase tracking-wide">Active Players</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-blue-600 mb-2">{{ number_format(50) }}+</div>
                                <div class="text-sm text-gray-500 uppercase tracking-wide">Events Monthly</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Register Form -->
                <div class="animate-slide-in-right">
                    <div class="card card-hover max-w-md mx-auto lg:mx-0">
                        <!-- Mobile Logo -->
                        <div class="lg:hidden text-center mb-8">
                            <div class="football-icon w-16 h-16 mx-auto mb-4">
                                <span class="text-2xl text-white">⚽</span>
                            </div>
                            <h2 class="text-2xl font-['Bebas_Neue'] text-gray-900 tracking-wider">
                                PUNK FOOTBALL
                            </h2>
                        </div>

                        <!-- Form Header -->
                        <div class="text-center mb-8">
                            <h2 class="text-3xl font-bold text-gray-900 mb-2">Create Account</h2>
                            <p class="text-gray-600">Join our football community today</p>
                        </div>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg animate-fade-in-up">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-green-800 text-sm">{{ session('status') }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Register Form -->
                        <form method="POST" action="{{ route('register') }}" class="space-y-6">
                            @csrf

                            <!-- Name -->
                            <div class="animate-fade-in-up" style="animation-delay: 0.1s;">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Full Name
                                </label>
                                <div class="relative">
                                    <input id="name"
                                           type="text"
                                           name="name"
                                           value="{{ old('name') }}"
                                           required
                                           autofocus
                                           autocomplete="name"
                                           class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-0 text-gray-900 placeholder-gray-500"
                                           placeholder="Enter your full name">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600 animate-fade-in-up">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email Address -->
                            <div class="animate-fade-in-up" style="animation-delay: 0.2s;">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email Address
                                </label>
                                <div class="relative">
                                    <input id="email"
                                           type="email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           required
                                           autocomplete="username"
                                           class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-0 text-gray-900 placeholder-gray-500"
                                           placeholder="Enter your email address">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600 animate-fade-in-up">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="animate-fade-in-up" style="animation-delay: 0.3s;">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Password
                                </label>
                                <div class="relative">
                                    <input id="password"
                                           type="password"
                                           name="password"
                                           required
                                           autocomplete="new-password"
                                           class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-0 text-gray-900 placeholder-gray-500"
                                           placeholder="Create a strong password">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600 animate-fade-in-up">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="animate-fade-in-up" style="animation-delay: 0.4s;">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    Confirm Password
                                </label>
                                <div class="relative">
                                    <input id="password_confirmation"
                                           type="password"
                                           name="password_confirmation"
                                           required
                                           autocomplete="new-password"
                                           class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-0 text-gray-900 placeholder-gray-500"
                                           placeholder="Confirm your password">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('password_confirmation')
                                    <p class="mt-2 text-sm text-red-600 animate-fade-in-up">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Register Button -->
                            <div class="animate-fade-in-up" style="animation-delay: 0.5s;">
                                <button type="submit"
                                        class="btn-primary-hover w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-300">
                                    <span class="flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                        </svg>
                                        Create Account
                                    </span>
                                </button>
                            </div>

                        </form>

                        <!-- Google Login Button -->
                        <div class="mt-6 text-center animate-fade-in-up" style="animation-delay: 0.55s;">
                            <a href="{{ route('auth.google') }}"
                               class="w-full inline-flex items-center justify-center px-4 py-3 bg-white border border-gray-300 rounded-lg shadow-md hover:bg-gray-50 transition-all duration-300 font-bold text-gray-700">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/4/4a/Logo_2013_Google.png" alt="Google" class="w-5 h-5 mr-2">
                                Sign up with Google
                            </a>
                        </div>

                        <!-- Login Link -->
                        <div class="mt-8 text-center animate-fade-in-up" style="animation-delay: 0.6s;">
                            <p class="text-gray-600 text-sm">
                                Already have an account?
                                <a href="{{ route('login') }}"
                                   class="font-medium text-red-600 hover:text-red-700 transition-colors duration-200">
                                    Sign in here
                                </a>
                            </p>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="text-center mt-8 animate-fade-in-up" style="animation-delay: 0.65s;">
                        <p class="text-gray-500 text-xs">
                            © 2026 Punk Football. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add loading animation to button on submit
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitBtn = document.querySelector('button[type="submit"]');

            form.addEventListener('submit', function() {
                submitBtn.innerHTML = `
                    <span class="flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Creating Account...
                    </span>
                `;
                submitBtn.disabled = true;
            });

            // Add focus effects to inputs
            const inputs = document.querySelectorAll('input[type="email"], input[type="password"], input[type="text"]');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('ring-2', 'ring-red-100');
                });

                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('ring-2', 'ring-red-100');
                });
            });
        });
    </script>
</body>
</html>
