<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
            top: calc(100% + 0.5rem); /* Position below the avatar */
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
            <h1 class="text-2xl font-semibold text-gray-800">Dashboard</h1>
            
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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Rooms Card -->
                <div class="card p-6 flex flex-col items-center justify-center text-center">
                    <div class="text-4xl font-bold text-indigo-600">{{ $totalRooms }}</div>
                    <div class="text-lg text-gray-600 mt-2">Total Rooms</div>
                </div>

                <!-- Occupied Rooms Card -->
                <div class="card p-6 flex flex-col items-center justify-center text-center">
                    <div class="text-4xl font-bold text-red-600">{{ $occupiedRooms }}</div>
                    <div class="text-lg text-gray-600 mt-2">Occupied Rooms</div>
                </div>

                <!-- Available Rooms Card -->
                <div class="card p-6 flex flex-col items-center justify-center text-center">
                    <div class="text-4xl font-bold text-green-600">{{ $availableRooms }}</div>
                    <div class="text-lg text-gray-600 mt-2">Available Rooms</div>
                </div>

                <!-- Total Tenants Card -->
                <div class="card p-6 flex flex-col items-center justify-center text-center">
                    <div class="text-4xl font-bold text-purple-600">{{ $totalTenants }}</div>
                    <div class="text-lg text-gray-600 mt-2">Total Tenants</div>
                </div>
            </div>

            <!-- Monthly Revenue Chart -->
            <div class="card p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Monthly Revenue Last 12 Months</h2>
                <canvas id="monthlyRevenueChart" class="w-full h-80"></canvas>
            </div>
        </main>
    </div>

    <script>
        // Chart.js initialization
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('monthlyRevenueChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar', // You can change this to 'line' for a line chart
                data: {
                    labels: JSON.parse('<?php echo json_encode($months ?? []); ?>'),
                    datasets: [{
                        label: 'Revenue',
                        data: JSON.parse('<?php echo json_encode($revenueData ?? []); ?>'),
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        borderRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                font: {
                                    family: 'Inter',
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            },
                            titleFont: {
                                family: 'Inter',
                            },
                            bodyFont: {
                                family: 'Inter',
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Amount (USD)',
                                font: {
                                    family: 'Inter',
                                }
                            },
                            ticks: {
                                callback: function(value, index, values) {
                                    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(value);
                                },
                                font: {
                                    family: 'Inter',
                                }
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Month',
                                font: {
                                    family: 'Inter',
                                }
                            },
                            ticks: {
                                font: {
                                    family: 'Inter',
                                }
                            }
                        }
                    }
                }
            });

            // Profile Dropdown Logic
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
