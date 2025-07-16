<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\Room; // Import Room model for assigning tenants to rooms
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TenantController extends Controller
{
    /**
     * Display a listing of the tenants.
     */
    public function index()
    {
        // Eager load the 'room' relationship to avoid N+1 problem
        $tenants = Tenant::with('room')->paginate(10);
        return view('admin.tenants.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new tenant.
     */
    public function create()
    {
        // Get available rooms for assignment (rooms not currently occupied)
        $availableRooms = Room::where('status', 'available')->get();
        return view('admin.tenants.create', compact('availableRooms'));
    }

    /**
     * Store a newly created tenant in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:tenants,email'],
            'phone' => ['required', 'string', 'max:20', 'unique:tenants,phone'],
            'address' => ['nullable', 'string', 'max:500'],
            'gender' => ['nullable', 'in:Male,Female,Other'],
            'room_id' => ['nullable', 'exists:rooms,id', Rule::unique('tenants')->ignore($request->tenant_id, 'id')], // Ensure room is not already assigned to another tenant
            'start_date' => ['required', 'date'],
        ]);

        // Create the tenant
        $tenant = Tenant::create($request->except('room_id')); // Create tenant first without room_id

        // If a room is selected, assign it and update room status
        if ($request->filled('room_id')) {
            $room = Room::find($request->room_id);
            if ($room && $room->status === 'available') {
                $tenant->room_id = $room->id;
                $tenant->save();
                $room->update(['status' => 'occupied']);
            } else {
                return back()->withInput()->with('error', 'Selected room is not available or does not exist.');
            }
        }

        return redirect()->route('admin.tenants.index')->with('success', 'Tenant created successfully!');
    }

    /**
     * Show the form for editing the specified tenant.
     */
    public function edit(Tenant $tenant) // Using route model binding
    {
        // Get all rooms, including the one currently assigned to this tenant
        // Also get other available rooms
        $availableRooms = Room::where('status', 'available')
                                ->orWhere('id', $tenant->room_id) // Include the tenant's current room
                                ->get();

        return view('admin.tenants.edit', compact('tenant', 'availableRooms'));
    }

    /**
     * Update the specified tenant in storage.
     */
    public function update(Request $request, Tenant $tenant) // Using route model binding
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', Rule::unique('tenants')->ignore($tenant->id)],
            'phone' => ['required', 'string', 'max:20', Rule::unique('tenants')->ignore($tenant->id)],
            'address' => ['nullable', 'string', 'max:500'],
            'gender' => ['nullable', 'in:Male,Female,Other'],
            'room_id' => ['nullable', 'exists:rooms,id'],
            'start_date' => ['required', 'date'],
        ]);

        $oldRoomId = $tenant->room_id;
        $newRoomId = $request->room_id;

        // Update tenant details first
        $tenant->update($request->except('room_id')); // Update all fields except room_id initially

        // Handle room assignment changes
        if ($oldRoomId != $newRoomId) {
            // If tenant is moving out of an old room
            if ($oldRoomId) {
                $oldRoom = Room::find($oldRoomId);
                if ($oldRoom) {
                    $oldRoom->update(['status' => 'available']); // Make old room available
                }
            }

            // If tenant is moving into a new room
            if ($newRoomId) {
                $newRoom = Room::find($newRoomId);
                if ($newRoom && ($newRoom->status === 'available' || $newRoom->id === $oldRoomId)) { // Allow re-assigning to current room
                    $tenant->room_id = $newRoom->id;
                    $newRoom->update(['status' => 'occupied']);
                } else {
                    // If the new room is not available, revert room_id and show error
                    $tenant->room_id = $oldRoomId; // Revert to old room
                    $tenant->save(); // Save the reverted room_id
                    return back()->withInput()->with('error', 'Selected new room is not available.');
                }
            } else {
                // If room_id is set to null (tenant is moving out without new assignment)
                $tenant->room_id = null;
            }
            $tenant->save(); // Save the tenant with the new room_id
        }

        return redirect()->route('admin.tenants.index')->with('success', 'Tenant updated successfully!');
    }

    /**
     * Remove the specified tenant from storage.
     */
    public function destroy(Tenant $tenant) // Using route model binding
    {
        // When a tenant is deleted, their room should become available
        if ($tenant->room_id) {
            $room = Room::find($tenant->room_id);
            if ($room) {
                $room->update(['status' => 'available']);
            }
        }

        $tenant->delete();

        return redirect()->route('admin.tenants.index')->with('success', 'Tenant deleted successfully!');
    }
}

