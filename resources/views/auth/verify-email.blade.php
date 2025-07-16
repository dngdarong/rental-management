<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - Rental Management</title>
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
        /* Custom styles for the verification card */
        .verification-card {
            background-color: #ffffff;
            border-radius: 1.5rem; /* More rounded corners */
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); /* Deeper shadow */
            padding: 2.5rem; /* Increased padding */
            width: 100%;
            max-width: 32rem; /* Slightly wider card for text */
            animation: fadeIn 0.5s ease-out; /* Simple fade-in animation */
            text-align: center; /* Center text within the card */
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Styling for messages */
        .verification-card .message-box {
            background-color: #f3f4f6; /* Light gray background for messages */
            border-radius: 0.75rem;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            line-height: 1.5;
            color: #4b5563; /* Darker text for readability */
        }
        .verification-card .success-message {
            background-color: #d1fae5; /* Light green for success */
            color: #065f46; /* Dark green text */
        }
        /* Primary button styling */
        .verification-card .primary-button {
            background-color: #4f46e5; /* Indigo-600 */
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: inline-flex; /* To center content within the button */
            justify-content: center;
            align-items: center;
            width: auto; /* Allow button to size based on content */
        }
        .verification-card .primary-button:hover {
            background-color: #4338ca; /* Darker indigo on hover */
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }
        /* Logout link styling */
        .verification-card .logout-link {
            color: #6366f1; /* Indigo-500 */
            text-decoration: underline;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }
        .verification-card .logout-link:hover {
            color: #4f46e5; /* Indigo-600 */
        }
    </style>
</head>
<body>
    <div class="verification-card">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Email Verification</h1>
            <p class="text-gray-500">Rental Management System</p>
        </div>

        <div class="message-box">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="message-box success-message">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
                @csrf
                <button type="submit" class="primary-button w-full">
                    {{ __('Resend Verification Email') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                @csrf
                <button type="submit" class="logout-link">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</body>
</html>
