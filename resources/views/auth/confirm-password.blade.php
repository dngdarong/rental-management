<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Password - Rental Management</title>
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
        /* Custom styles for the confirm password card */
        .confirm-password-card {
            background-color: #ffffff;
            border-radius: 1.5rem; /* More rounded corners */
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); /* Deeper shadow */
            padding: 2.5rem; /* Increased padding */
            width: 100%;
            max-width: 28rem; /* Max width for the card */
            animation: fadeIn 0.5s ease-out; /* Simple fade-in animation */
            text-align: center; /* Center text within the card */
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Styling for messages */
        .confirm-password-card .message-box {
            background-color: #f3f4f6; /* Light gray background for messages */
            border-radius: 0.75rem;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            line-height: 1.5;
            color: #4b5563; /* Darker text for readability */
        }
        /* Adjust input focus styles for consistency */
        .confirm-password-card input[type="password"]:focus {
            border-color: #4f46e5; /* Indigo-600 */
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.5); /* Indigo-500 with transparency */
        }
        /* Primary button styling */
        .confirm-password-card .primary-button {
            background-color: #4f46e5; /* Indigo-600 */
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%; /* Make button full width */
            justify-content: center; /* Center text in button */
            padding-top: 0.75rem; /* Adjust padding for height */
            padding-bottom: 0.75rem;
        }
        .confirm-password-card .primary-button:hover {
            background-color: #4338ca; /* Darker indigo on hover */
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body>
    <div class="confirm-password-card">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Confirm Password</h1>
            <p class="text-gray-500">Rental Management System</p>
        </div>

        <div class="message-box">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div class="mb-6">
                <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
                <x-text-input id="password" class="block mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-center">
                <x-primary-button class="primary-button">
                    {{ __('Confirm') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</body>
</html>
