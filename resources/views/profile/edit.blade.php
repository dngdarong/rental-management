<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile - Rental Management</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Alpine.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f8;
        }
        .sidebar {
            background-color: #1a202c; /* Darker background for sidebar */
            color: #cbd5e0; /* Light text color */
        }
        .sidebar a {
            padding: 0.75rem 1.5rem;
            display: block;
            border-radius: 0.5rem;
            transition: background-color 0.2s ease-in-out;
        }
        .sidebar a:hover {
            background-color: #2d3748; /* Slightly lighter on hover */
        }
        .sidebar a.active {
            background-color: #4a5568; /* Active link background */
            color: #ffffff; /* Active link text color */
        }
        .card {
            background-color: #ffffff;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        /* Dropdown specific styles */
        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            background-color: #ffffff;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 0.5rem;
            overflow: hidden;
            top: calc(100% + 0.5rem);
        }
        .dropdown-menu.show {
            display: block;
        }
        .dropdown-menu a, .dropdown-menu button {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
            width: 100%;
            border: none;
            background: none;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }
        .dropdown-menu a:hover, .dropdown-menu button:hover {
            background-color: #f1f1f1;
        }
        /* Form specific styles */
        .form-section-card {
            padding: 2rem;
            background-color: #ffffff;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }
        .form-section-header {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 1rem;
        }
        .form-section-description {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 1.5rem;
        }
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="file"]:focus { /* Added file input focus */
            border-color: #4f46e5; /* Indigo-600 */
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.5); /* Indigo-500 with transparency */
        }
        .primary-button {
            background-color: #4f46e5; /* Indigo-600 */
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .primary-button:hover {
            background-color: #4338ca; /* Darker indigo on hover */
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }
        .danger-button {
            background-color: #dc2626; /* Red-600 */
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .danger-button:hover {
            background-color: #b91c1c; /* Darker red on hover */
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }
        .secondary-button {
            background-color: #e5e7eb; /* Gray-200 */
            color: #374151; /* Gray-700 */
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .secondary-button:hover {
            background-color: #d1d5db; /* Gray-300 */
        }
    </style>
</head>
<body class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="sidebar w-64 p-6 flex flex-col justify-between">
        <div>
            <div class="text-2xl font-bold text-white mb-8">Admin Panel</div>
            <nav>
                <ul>
                    <li class="mb-2">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001 1h3v-3m-3 3h3v-3m-3 0V9m0 3h3"></path></svg>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('admin.admin-tenants.index') }}" class="flex items-center space-x-3 {{ request()->routeIs('admin.admin-tenants.*') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a4 4 0 00-4-4H9a4 4 0 00-4 4v1h10zm-9-9a4 4 0 110 5.292"></path></svg>
                            <span>Add Admins</span> 
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('admin.rooms.index') }}" class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <span>Rooms</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('admin.room-types.index') }}" class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            <span>Room Types</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('admin.tenants.index') }}" class="flex items-center space-x-3 {{ request()->routeIs('admin.tenants.*') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h2a2 2 0 002-2V8a2 2 0 00-2-2h-2M17 20v-2a2 2 0 00-2-2H9a2 2 0 00-2 2v2M17 20h-2M7 20H5a2 2 0 01-2-2V8a2 2 0 012-2h2m0 0V5a2 2 0 012-2h4a2 2 0 012 2v1M7 6h10"></path></svg>
                            <span>Tenants</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span>Rents</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8h6m-5 0h.01M9 12h6m-5 0h.01M9 16h6m-5 0h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Payments</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            <span>Maintenance</span>
                        </a>
                    </li>
                    @can('manage-admin-tenants')
                    <li class="mb-2">
                        <a href="{{ route('admin.admin-tenants.index') }}" class="flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a4 4 0 00-4-4H9a4 4 0 00-4 4v1h10zm-9-9a4 4 0 110 5.292"></path></svg>
                            <span>Manage Admins</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col">
        <!-- Top Navbar -->
        <header class="navbar p-4 flex justify-between items-center relative">
            <h1 class="text-2xl font-semibold text-gray-800">Profile</h1>
            
            <div class="relative">
                <button id="profileDropdownToggle" class="flex items-center space-x-2 focus:outline-none">
                    {{-- Display actual profile image or fallback avatar --}}
                    <img src="{{ Auth::user()->profile_image_url }}" alt="Profile Avatar" class="w-10 h-10 rounded-full object-cover">
                    <span class="text-gray-800 font-medium hidden md:block">{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                <div id="profileDropdownMenu" class="dropdown-menu">
                    <div class="px-4 py-2 text-sm text-gray-700 border-b border-gray-200">
                        <div class="font-medium">{{ Auth::user()->name }}</div>
                        <div class="text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="active">Settings</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6 bg-gray-100">
            <div class="max-w-4xl mx-auto">
                {{-- Update Profile Information Form --}}
                <div class="form-section-card">
                    <div class="form-section-header">Profile Information</div>
                    <p class="form-section-description">Update your account's profile information and email address.</p>

                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                        @csrf
                    </form>

                    {{-- IMPORTANT: Add enctype="multipart/form-data" for file uploads --}}
                    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        {{-- Profile Image Section --}}
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="flex-shrink-0">
                                <img src="{{ $user->profile_image_url }}" alt="Profile Avatar" class="w-24 h-24 rounded-full object-cover border-2 border-gray-300">
                            </div>
                            <div>
                                <label for="profile_image" class="block text-sm font-medium text-gray-700 mb-2">Change Profile Image</label>
                                <input type="file" name="profile_image" id="profile_image" class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-indigo-50 file:text-indigo-700
                                    hover:file:bg-indigo-100"
                                    accept="image/*">
                                @error('profile_image')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror

                                @if ($user->profile_image_path)
                                    <button type="button" onclick="document.getElementById('remove_profile_image').value = '1'; this.form.submit();" class="text-red-600 hover:text-red-900 text-sm mt-2 underline">Remove Profile Image</button>
                                    <input type="hidden" name="remove_profile_image" id="remove_profile_image" value="0">
                                @endif
                            </div>
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input id="name" name="name" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input id="email" name="email" type="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div class="mt-2 text-sm text-gray-800">
                                    Your email address is unverified.
                                    <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Click here to re-send the verification email.
                                    </button>
                                </div>
                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 font-medium text-sm text-green-600">
                                        A new verification link has been sent to your email address.
                                    </p>
                                @endif
                            @endif
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="primary-button">Save</button>
                            @if (session('status') === 'profile-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">Saved.</p>
                            @endif
                        </div>
                    </form>
                </div>

                {{-- Update Password Form --}}
                <div class="form-section-card">
                    <div class="form-section-header">Update Password</div>
                    <p class="form-section-description">Ensure your account is using a long, random password to stay secure.</p>

                    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('put')

                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                            <input id="current_password" name="current_password" type="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" autocomplete="current-password" />
                            @error('current_password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                            <input id="password" name="password" type="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" autocomplete="new-password" />
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" autocomplete="new-password" />
                            @error('password_confirmation')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="primary-button">Save</button>
                            @if (session('status') === 'password-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">Saved.</p>
                            @endif
                        </div>
                    </form>
                </div>

                {{-- Delete User Form --}}
                <div class="form-section-card">
                    <div class="form-section-header">Delete Account</div>
                    <p class="form-section-description">Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.</p>

                    <button type="button" onclick="showConfirmDeleteAccountModal()" class="danger-button">Delete Account</button>

                    <div id="confirmDeleteAccountModal" class="modal-overlay">
                        <div class="modal-content">
                            <div class="modal-header">Confirm Account Deletion</div>
                            <div class="modal-body">
                                Are you sure you want to delete your account? This action cannot be undone.
                                <div class="mt-4">
                                    <label for="password_delete" class="sr-only">Password</label>
                                    <input type="password" name="password_delete" id="password_delete" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Password" />
                                    <p id="password_delete_error" class="text-red-500 text-xs mt-1 text-left hidden"></p>
                                </div>
                            </div>
                            <div class="modal-footer flex justify-center">
                                <button id="cancelAccountDelete" class="secondary-button">Cancel</button>
                                <button id="confirmAccountDelete" class="danger-button ml-3">Delete Account</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Profile Dropdown Logic (from dashboard)
        document.addEventListener('DOMContentLoaded', function() {
            const profileDropdownToggle = document.getElementById('profileDropdownToggle');
            const profileDropdownMenu = document.getElementById('profileDropdownMenu');

            if (profileDropdownToggle && profileDropdownMenu) {
                profileDropdownToggle.addEventListener('click', function() {
                    profileDropdownMenu.classList.toggle('show');
                });

                window.addEventListener('click', function(event) {
                    if (!profileDropdownToggle.contains(event.target) && !profileDropdownMenu.contains(event.target)) {
                        if (profileDropdownMenu.classList.contains('show')) {
                            profileDropdownMenu.classList.remove('show');
                        }
                    }
                });
            }

            // Delete Account Modal Logic
            const confirmDeleteAccountModal = document.getElementById('confirmDeleteAccountModal');
            const cancelAccountDeleteBtn = document.getElementById('cancelAccountDelete');
            const confirmAccountDeleteBtn = document.getElementById('confirmAccountDelete');
            const passwordDeleteInput = document.getElementById('password_delete');
            const passwordDeleteError = document.getElementById('password_delete_error');

            window.showConfirmDeleteAccountModal = function() {
                confirmDeleteAccountModal.classList.add('show');
                passwordDeleteInput.value = ''; // Clear password field
                passwordDeleteError.textContent = ''; // Clear error message
                passwordDeleteError.classList.add('hidden');
            }

            if (cancelAccountDeleteBtn) {
                cancelAccountDeleteBtn.addEventListener('click', function() {
                    confirmDeleteAccountModal.classList.remove('show');
                });
            }

            if (confirmDeleteAccountModal) {
                confirmDeleteAccountModal.addEventListener('click', function(event) {
                    if (event.target === confirmDeleteAccountModal) {
                        confirmDeleteAccountModal.classList.remove('show');
                    }
                });
            }

            if (confirmAccountDeleteBtn) {
                confirmAccountDeleteBtn.addEventListener('click', function() {
                    const password = passwordDeleteInput.value;
                    // Create a temporary form to submit the delete request
                    const tempForm = document.createElement('form');
                    tempForm.method = 'POST';
                    tempForm.action = "{{ route('profile.destroy') }}"; // Use the profile destroy route
                    tempForm.style.display = 'none';

                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';
                    tempForm.appendChild(csrfInput);

                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    tempForm.appendChild(methodInput);

                    const passwordInput = document.createElement('input');
                    passwordInput.type = 'hidden';
                    passwordInput.name = 'password';
                    passwordInput.value = password;
                    tempForm.appendChild(passwordInput);

                    document.body.appendChild(tempForm);
                    tempForm.submit();

                    // Note: Laravel will handle the actual password validation and deletion.
                    // If validation fails, it will redirect back with errors.
                    // This client-side JS only submits the form.
                });
            }
        });
    </script>
</body>
</html>
