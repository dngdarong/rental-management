<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Rental Management</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            /* Gradient background for a more modern feel */
            background: linear-gradient(to right, #6a11cb 0%, #2575fc 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        /* Custom styles for the login card */
        .login-card {
            background-color: #ffffff;
            border-radius: 1.5rem; /* More rounded corners */
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); /* Deeper shadow */
            padding: 2.5rem; /* Increased padding */
            width: 100%;
            max-width: 28rem; /* Max width for the card */
            animation: fadeIn 0.5s ease-out; /* Simple fade-in animation */
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Custom styling for Breeze components to override defaults if needed */
        .login-card .block {
            margin-top: 1rem;
        }
        .login-card .mt-4 {
            margin-top: 1.5rem;
        }
        .login-card .ms-3 {
            margin-left: 0.75rem;
        }
        .login-card .text-sm {
            font-size: 0.9rem;
        }
        /* Adjust input focus styles for consistency */
        .login-card input[type="email"]:focus,
        .login-card input[type="password"]:focus {
            border-color: #4f46e5; /* Indigo-600 */
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.5); /* Indigo-500 with transparency */
        }
        /* Primary button styling */
        .login-card .ms-3 {
            background-color: #4f46e5; /* Indigo-600 */
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .login-card .ms-3:hover {
            background-color: #4338ca; /* Darker indigo on hover */
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }
        /* Forgot password and Register links */
        .login-card .underline {
            color: #6366f1; /* Indigo-500 */
        }
        .login-card .underline:hover {
            color: #4f46e5; /* Indigo-600 */
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Admin Login</h1>
            <p class="text-gray-500">Rental Management System</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
                <x-text-input id="email" class="block mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-6">
                <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
                <x-text-input id="password" class="block mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex justify-between items-center mb-6">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="underline text-sm text-indigo-600 hover:text-indigo-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <div class="flex items-center justify-center">
                <x-primary-button class="w-full justify-center py-3">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>

            <!-- Register Link -->
            @if (Route::has('register'))
                <div class="flex items-center justify-center mt-4">
                    <p class="text-sm text-gray-600">Don't have an account?</p>
                    <a class="underline text-sm text-indigo-600 hover:text-indigo-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ms-2" href="{{ route('register') }}">
                        {{ __('Register now') }}
                    </a>
                </div>
            @endif
        </form>
    </div>
</body>
</html>
