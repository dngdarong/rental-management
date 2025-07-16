<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register - Rental Management</title>
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
        /* Custom styles for the register card */
        .register-card {
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
        .register-card .block {
            margin-top: 1rem;
        }
        .register-card .mt-4 {
            margin-top: 1.5rem;
        }
        .register-card .ms-4 {
            margin-left: 1rem;
        }
        .register-card .text-sm {
            font-size: 0.9rem;
        }
        /* Adjust input focus styles for consistency */
        .register-card input[type="text"]:focus,
        .register-card input[type="email"]:focus,
        .register-card input[type="password"]:focus {
            border-color: #4f46e5; /* Indigo-600 */
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.5); /* Indigo-500 with transparency */
        }
        /* Primary button styling */
        .register-card .ms-4 {
            background-color: #4f46e5; /* Indigo-600 */
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .register-card .ms-4:hover {
            background-color: #4338ca; /* Darker indigo on hover */
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }
        /* Already registered link */
        .register-card .underline {
            color: #6366f1; /* Indigo-500 */
        }
        .register-card .underline:hover {
            color: #4f46e5; /* Indigo-600 */
        }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Admin Registration</h1>
            <p class="text-gray-500">Create your account for Rental Management</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Name')" class="text-gray-700" />
                <x-text-input id="name" class="block mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
                <x-text-input id="email" class="block mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
                <x-text-input id="password" class="block mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700" />
                <x-text-input id="password_confirmation" class="block mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-center">
                <x-primary-button class="w-full justify-center py-3">
                    {{ __('Register') }}
                </x-primary-button>
            </div>

            <div class="flex items-center justify-center mt-4">
                <a class="underline text-sm text-indigo-600 hover:text-indigo-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
            </div>
        </form>
    </div>
</body>
</html>
