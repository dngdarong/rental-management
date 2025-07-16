<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use App\Models\Tenant; // Import Tenant model
use App\Models\Room;   // Import Room model
use Illuminate\Http\Request;
use Carbon\Carbon; // For date manipulation

class MaintenanceRequestController extends Controller
{
    /**
     * Display a listing of the maintenance requests.
     */
    public function index(Request $request)
    {
        $query = MaintenanceRequest::with(['tenant', 'room'])
                                    ->orderBy('reported_at', 'desc');

        // Optional: Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Optional: Filter by room
        if ($request->filled('room_id')) {
            $query->where('room_id', $request->room_id);
        }

        // Optional: Filter by tenant
        if ($request->filled('tenant_id')) {
            $query->where('tenant_id', $request->tenant_id);
        }

        $maintenanceRequests = $query->paginate(10);
        $tenants = Tenant::all(); // For filter dropdown
        $rooms = Room::all();     // For filter dropdown
        $statuses = ['Pending', 'In Progress', 'Completed', 'Cancelled']; // Define possible statuses

        return view('admin.maintenance_requests.index', compact('maintenanceRequests', 'tenants', 'rooms', 'statuses'));
    }

    /**
     * Show the form for creating a new maintenance request.
     * Admin can create requests on behalf of tenants.
     */
    public function create()
    {
        $tenants = Tenant::all();
        $rooms = Room::all();
        return view('admin.maintenance_requests.create', compact('tenants', 'rooms'));
    }

    /**
     * Store a newly created maintenance request in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tenant_id' => ['nullable', 'exists:tenants,id'],
            'room_id' => ['required', 'exists:rooms,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'status' => ['required', 'in:Pending,In Progress,Completed,Cancelled'],
            'reported_at' => ['nullable', 'date_format:Y-m-d H:i'], // Admin can set this
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        // Set reported_at if not provided
        $request->merge(['reported_at' => $request->reported_at ? Carbon::parse($request->reported_at)->format('Y-m-d H:i:s') : Carbon::now()->format('Y-m-d H:i:s')]);
        
        // Ensure completed_at is null if status is not 'Completed'
        if ($request->status !== 'Completed') {
            $request->merge(['completed_at' => null]);
        } elseif ($request->status === 'Completed' && !$request->filled('completed_at')) {
            // If status is completed but completed_at is not provided, set it to now
            $request->merge(['completed_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        } else {
            $request->merge(['completed_at' => Carbon::parse($request->completed_at)->format('Y-m-d H:i:s')]);
        }

        MaintenanceRequest::create($request->all());

        return redirect()->route('admin.maintenance-requests.index')->with('success', 'Maintenance request created successfully!');
    }

    /**
     * Show the form for editing the specified maintenance request.
     */
    public function edit(MaintenanceRequest $maintenanceRequest) // Using route model binding
    {
        $tenants = Tenant::all();
        $rooms = Room::all();
        $statuses = ['Pending', 'In Progress', 'Completed', 'Cancelled'];
        return view('admin.maintenance_requests.edit', compact('maintenanceRequest', 'tenants', 'rooms', 'statuses'));
    }

    /**
     * Update the specified maintenance request in storage.
     */
    public function update(Request $request, MaintenanceRequest $maintenanceRequest) // Using route model binding
    {
        $request->validate([
            'tenant_id' => ['nullable', 'exists:tenants,id'],
            'room_id' => ['required', 'exists:rooms,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'status' => ['required', 'in:Pending,In Progress,Completed,Cancelled'],
            'reported_at' => ['nullable', 'date_format:Y-m-d H:i'],
            'completed_at' => ['nullable', 'date_format:Y-m-d H:i'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $request->merge(['reported_at' => $request->reported_at ? Carbon::parse($request->reported_at)->format('Y-m-d H:i:s') : $maintenanceRequest->reported_at]);
        
        // Handle completed_at based on status change
        if ($request->status === 'Completed' && !$request->filled('completed_at')) {
            $request->merge(['completed_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        } elseif ($request->status !== 'Completed') {
            $request->merge(['completed_at' => null]);
        } else {
            $request->merge(['completed_at' => Carbon::parse($request->completed_at)->format('Y-m-d H:i:s')]);
        }

        $maintenanceRequest->update($request->all());

        return redirect()->route('admin.maintenance-requests.index')->with('success', 'Maintenance request updated successfully!');
    }

    /**
     * Remove the specified maintenance request from storage.
     */
    public function destroy(MaintenanceRequest $maintenanceRequest) // Using route model binding
    {
        $maintenanceRequest->delete();

        return redirect()->route('admin.maintenance-requests.index')->with('success', 'Maintenance request deleted successfully!');
    }
}

