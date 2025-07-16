<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Use the User model for admin tenants
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Gate; // Import Gate facade (though not directly used in this file for middleware application)

class AdminTenantController extends Controller
{
    /**
     * The middleware that should be applied to the controller's actions.
     *
     * @var array
     */
    protected $middleware = [
        'can:manage-admin-tenants', // Apply the 'manage-admin-tenants' gate to all actions
    ];

    // Removed the __construct method entirely as middleware is now defined via property.

    /**
     * Display a listing of the admin tenants.
     */
    public function index()
    {
        // Only show users with 'admin_tenant' role
        $adminTenants = User::where('role', 'admin_tenant')->paginate(10);
        return view('admin.admin_tenants.index', compact('adminTenants'));
    }

    /**
     * Show the form for creating a new admin tenant.
     */
    public function create()
    {
        return view('admin.admin_tenants.create');
    }

    /**
     * Store a newly created admin tenant in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin_tenant', // Force the role to 'admin_tenant'
        ]);

        return redirect()->route('admin.admin-tenants.index')->with('success', 'Admin Tenant created successfully!');
    }

    /**
     * Show the form for editing the specified admin tenant.
     */
    public function edit(User $adminTenant) // Using route model binding
    {
        // Ensure only admin_tenant roles can be edited here, not super_admin
        if ($adminTenant->isSuperAdmin()) {
            return redirect()->route('admin.admin-tenants.index')->with('error', 'Cannot edit Super Admin accounts through this interface.');
        }
        return view('admin.admin_tenants.edit', compact('adminTenant'));
    }

    /**
     * Update the specified admin tenant in storage.
     */
    public function update(Request $request, User $adminTenant) // Using route model binding
    {
        // Ensure only admin_tenant roles can be updated here, not super_admin
        if ($adminTenant->isSuperAdmin()) {
            return redirect()->route('admin.admin-tenants.index')->with('error', 'Cannot update Super Admin accounts through this interface.');
        }

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',email,'.$adminTenant->id],
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['confirmed', Rules\Password::defaults()];
        }

        $request->validate($rules);

        $adminTenant->name = $request->name;
        $adminTenant->email = $request->email;
        if ($request->filled('password')) {
            $adminTenant->password = Hash::make($request->password);
        }
        $adminTenant->save();

        return redirect()->route('admin.admin-tenants.index')->with('success', 'Admin Tenant updated successfully!');
    }

    /**
     * Remove the specified admin tenant from storage.
     */
    public function destroy(User $adminTenant) // Using route model binding
    {
        // Prevent deleting Super Admins or the currently logged-in user
        if ($adminTenant->isSuperAdmin() || $adminTenant->id === auth()->id()) {
            return redirect()->route('admin.admin-tenants.index')->with('error', 'Cannot delete Super Admin accounts or your own account.');
        }

        $adminTenant->delete();

        return redirect()->route('admin.admin-tenants.index')->with('success', 'Admin Tenant deleted successfully!');
    }
}

