<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Room</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f6f8; }
        .sidebar { background-color: #1a202c; color: #cbd5e0; }
        .sidebar a { padding: 0.75rem 1.5rem; display: block; border-radius: 0.5rem; transition: background-color 0.2s ease-in-out; }
        .sidebar a:hover { background-color: #2d3748; }
        .sidebar a.active { background-color: #4a5568; color: #ffffff; }
        .card { background-color: #ffffff; border-radius: 0.75rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        .navbar { background-color: #ffffff; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); }
        /* Input and Select styling for consistency */
        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus {
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
        /* Dropdown specific styles (copied from dashboard) */
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
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
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
                        <a href="{{ route('admin.rooms.index') }}" class="flex items-center space-x-3 {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <span>Rooms</span>
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('admin.room-types.index') }}" class="flex items-center space-x-3 {{ request()->routeIs('admin.room-types.*') ? 'active' : '' }}">
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
                        <a href="{{ route('admin.rents.index') }}" class="flex items-center space-x-3 {{ request()->routeIs('admin.rents.*') ? 'active' : '' }}">
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
                        <a href="{{ route('admin.admin-tenants.index') }}" class="flex items-center space-x-3 {{ request()->routeIs('admin.admin-tenants.*') ? 'active' : '' }}">
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
            <h1 class="text-2xl font-semibold text-gray-800">Edit Room</h1> {{-- Dynamic title --}}
            
            <div class="relative">
                <button id="profileDropdownToggle" class="flex items-center space-x-2 focus:outline-none">
                    <img src="{{ Auth::user()->profile_image_url }}" alt="Profile Avatar" class="w-10 h-10 rounded-full object-cover">
                    <span class="text-gray-800 font-medium hidden md:block">{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                <div id="profileDropdownMenu" class="dropdown-menu">
                    <div class="px-4 py-2 text-sm text-gray-700 border-b border-gray-200">
                        <div class="font-medium">{{ Auth::user()->name }}</div>
                        <div class="text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                    <a href="{{ route('profile.edit') }}">Settings</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6 bg-gray-100">
            <div class="card p-6 max-w-2xl mx-auto">
                <form method="POST" action="{{ route('admin.rooms.update', $room) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="room_number" class="block text-sm font-medium text-gray-700">Room Number</label>
                        <input type="text" name="room_number" id="room_number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('room_number', $room->room_number) }}" required autofocus>
                        @error('room_number')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="room_type_id" class="block text-sm font-medium text-gray-700">Room Type</label>
                        <select name="room_type_id" id="room_type_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            <option value="">Select a Room Type</option>
                            @foreach ($roomTypes as $roomType)
                                <option value="{{ $roomType->id }}" {{ old('room_type_id', $room->room_type_id) == $roomType->id ? 'selected' : '' }}>
                                    {{ $roomType->name }} (${{ number_format($roomType->default_price, 2) }})
                                </option>
                            @endforeach
                        </select>
                        @error('room_type_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" name="price" id="price" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('price', $room->price) }}" required min="0" step="0.01">
                        @error('price')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            <option value="available" {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="occupied" {{ old('status', $room->status) == 'occupied' ? 'selected' : '' }}>Occupied</option>
                            <option value="under_maintenance" {{ old('status', $room->status) == 'under_maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end">
                        <a href="{{ route('admin.rooms.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                        <button type="submit" class="primary-button">
                            Update Room
                        </button>
                    </div>
                </form>
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
        });
    </script>
</body>
</html>
