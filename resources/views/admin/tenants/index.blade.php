<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tenants</title>
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
        .table-header { background-color: #edf2f7; }
        /* Pagination styling */
        .pagination-links nav { display: flex; justify-content: center; margin-top: 1.5rem; }
        .pagination-links nav div:first-child { display: none; } /* Hide "Showing 1 to X of Y results" */
        .pagination-links nav a, .pagination-links nav span {
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            border-radius: 0.5rem;
            border: 1px solid #e2e8f0; /* Gray-200 */
            color: #4a5568; /* Gray-700 */
            text-decoration: none;
            transition: all 0.2s ease-in-out;
        }
        .pagination-links nav a:hover {
            background-color: #e2e8f0; /* Gray-200 */
            color: #2d3748; /* Gray-800 */
        }
        .pagination-links nav span.relative.inline-flex.items-center {
            background-color: #4f46e5; /* Indigo-600 */
            color: white;
            border-color: #4f46e5;
            font-weight: 600;
        }
        .pagination-links nav span.relative.inline-flex.items-center:hover {
            background-color: #4f46e5; /* Keep same on hover for active */
            color: white;
        }
        .pagination-links nav span.text-gray-500 {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Custom Modal Styles (copied from login page for consistency) */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        .modal-overlay.show {
            opacity: 1;
            visibility: visible;
        }
        .modal-content {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            width: 90%;
            max-width: 400px;
            text-align: center;
            transform: translateY(-20px);
            transition: transform 0.3s ease;
        }
        .modal-overlay.show .modal-content {
            transform: translateY(0);
        }
        .modal-header {
            font-size: 1.5rem;
            font-weight: bold;
            color: #1a202c;
            margin-bottom: 1rem;
        }
        .modal-body {
            color: #4a5568;
            margin-bottom: 1.5rem;
        }
        .modal-footer button {
            background-color: #4f46e5;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .modal-footer button.cancel-btn {
            background-color: #6b7280; /* Gray for cancel */
            margin-right: 0.5rem;
        }
        .modal-footer button.cancel-btn:hover {
            background-color: #4b5563;
        }
        .modal-footer button:hover {
            background-color: #4338ca;
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
<body class="flex min-h-screen"
    data-session-success="{{ session('success') }}"
    data-session-error="{{ session('error') }}">

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
            <div class="flex justify-end mb-6">
                <a href="{{ route('admin.tenants.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Add New Tenant
                </a>
            </div>

            <div class="card p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="table-header">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-lg">Full Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tr-lg">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($tenants as $tenant)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $tenant->full_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $tenant->email ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $tenant->phone }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $tenant->room->room_number ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $tenant->start_date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.tenants.edit', $tenant) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <button type="button" onclick="confirmDelete('{{ $tenant->id }}')" class="text-red-600 hover:text-red-900">Delete</button>
                                        <form id="delete-form-{{ $tenant->id }}" action="{{ route('admin.tenants.destroy', $tenant) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No tenants found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 pagination-links">
                    {{ $tenants->links() }}
                </div>
            </div>
        </main>
    </div>

    <!-- Custom Alert Modal Structure -->
    <div id="customAlertModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header" id="modalTitle">Alert</div>
            <div class="modal-body" id="modalMessage"></div>
            <div class="modal-footer">
                <button id="closeModal">OK</button>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal for Delete -->
    <div id="confirmDeleteModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">Confirm Deletion</div>
            <div class="modal-body">Are you sure you want to delete this tenant? This action cannot be undone.</div>
            <div class="modal-footer flex justify-center">
                <button id="cancelDelete" class="cancel-btn">Cancel</button>
                <button id="confirmDelete" class="primary-button">Delete</button>
            </div>
        </div>
    </div>

    <script>
        // Custom Alert Modal Logic
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('customAlertModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalMessage = document.getElementById('modalMessage');
            const closeModalBtn = document.getElementById('closeModal');

            function showAlert(title, message) {
                modalTitle.textContent = title;
                modalMessage.textContent = message;
                modal.classList.add('show');
            }

            function hideAlert() {
                modal.classList.remove('show');
            }

            if (closeModalBtn) {
                closeModalBtn.addEventListener('click', hideAlert);
            }
            if (modal) {
                modal.addEventListener('click', function(event) {
                    if (event.target === modal) {
                        hideAlert();
                    }
                });
            }

            const bodyElement = document.body;
            const sessionSuccess = bodyElement.dataset.sessionSuccess;
            const sessionError = bodyElement.dataset.sessionError;

            if (sessionSuccess) {
                showAlert('Success!', sessionSuccess);
            } else if (sessionError) {
                showAlert('Error!', sessionError);
            }

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

            // Delete Confirmation Modal Logic
            const confirmDeleteModal = document.getElementById('confirmDeleteModal');
            const cancelDeleteBtn = document.getElementById('cancelDelete');
            const confirmDeleteBtn = document.getElementById('confirmDelete');
            let formToSubmit = null; // To store the form reference

            window.confirmDelete = function(tenantId) { // Changed parameter name to tenantId
                formToSubmit = document.getElementById('delete-form-' + tenantId);
                confirmDeleteModal.classList.add('show');
            }

            if (cancelDeleteBtn) {
                cancelDeleteBtn.addEventListener('click', function() {
                    confirmDeleteModal.classList.remove('show');
                    formToSubmit = null;
                });
            }

            if (confirmDeleteBtn) {
                confirmDeleteBtn.addEventListener('click', function() {
                    if (formToSubmit) {
                        formToSubmit.submit(); // Submit the form
                    }
                    confirmDeleteModal.classList.remove('show');
                    formToSubmit = null;
                });
            }

            if (confirmDeleteModal) {
                confirmDeleteModal.addEventListener('click', function(event) {
                    if (event.target === confirmDeleteModal) {
                        confirmDeleteModal.classList.remove('show');
                        formToSubmit = null;
                    }
                });
            }
        });
    </script>
</body>
</html>
