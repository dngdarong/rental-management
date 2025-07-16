<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Gate;

class AdminTenantController extends Controller
{
    /**
     * The middleware that should be applied to the controller's actions.
     *
     * @var array
     */
    protected $middleware = [
        'can:manage-admin-tenants',
    ];

    /**
     * Display a listing of the admin tenants.
     */
    public function index()
    {
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
            'role' => 'admin_tenant',
        ]);

        return redirect()->route('admin.admin-tenants.index')->with('success', 'Admin Tenant created successfully!');
    }

    /**
     * Show the form for editing the specified admin tenant.
     */
    public function edit(User $adminTenant)
    {
        if ($adminTenant->isSuperAdmin()) {
            return redirect()->route('admin.admin-tenants.index')->with('error', 'Cannot edit Super Admin accounts through this interface.');
        }
        return view('admin.admin_tenants.edit', compact('adminTenant'));
    }

    /**
     * Update the specified admin tenant in storage.
     */
    public function update(Request $request, User $adminTenant)
    {
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
    public function destroy(User $adminTenant)
    {
        // This is the line that Intelephense flags, but it's correct for Eloquent models.
        if ($adminTenant->isSuperAdmin() || $adminTenant->id === auth()->id()) {
            return redirect()->route('admin.admin-tenants.index')->with('error', 'Cannot delete Super Admin accounts or your own account.');
        }

        $adminTenant->delete();

        return redirect()->route('admin.admin-tenants.index')->with('success', 'Admin Tenant deleted successfully!');
    }
}

