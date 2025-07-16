<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rent;
use App\Models\Tenant; // Import Tenant model
use App\Models\Room;   // Import Room model
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon; // For date manipulation

class RentController extends Controller
{
    /**
     * Display a listing of the rents.
     */
    public function index()
    {
        // Eager load tenant and room relationships
        $rents = Rent::with(['tenant', 'room'])->orderBy('month', 'desc')->paginate(10);
        return view('admin.rents.index', compact('rents'));
    }

    /**
     * Show the form for creating a new rent record.
     */
    public function create()
    {
        $tenants = Tenant::all(); // Get all tenants for dropdown
        $rooms = Room::all();     // Get all rooms for dropdown
        return view('admin.rents.create', compact('tenants', 'rooms'));
    }

    /**
     * Store a newly created rent record in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tenant_id' => ['required', 'exists:tenants,id'],
            'room_id' => ['required', 'exists:rooms,id'],
            'month' => ['required', 'date_format:Y-m-d'], // Expecting YYYY-MM-DD
            'amount' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:Paid,Due,Partial'],
            'due_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:month'],
            'paid_at' => ['nullable', 'date_format:Y-m-d H:i:s'], // Optional timestamp
        ]);

        // Ensure 'month' is stored as the first day of the month
        $request->merge(['month' => Carbon::parse($request->month)->startOfMonth()->format('Y-m-d')]);

        Rent::create($request->all());

        return redirect()->route('admin.rents.index')->with('success', 'Rent record created successfully!');
    }

    /**
     * Show the form for editing the specified rent record.
     */
    public function edit(Rent $rent) // Using route model binding
    {
        $tenants = Tenant::all();
        $rooms = Room::all();
        return view('admin.rents.edit', compact('rent', 'tenants', 'rooms'));
    }

    /**
     * Update the specified rent record in storage.
     */
    public function update(Request $request, Rent $rent) // Using route model binding
    {
        $request->validate([
            'tenant_id' => ['required', 'exists:tenants,id'],
            'room_id' => ['required', 'exists:rooms,id'],
            'month' => ['required', 'date_format:Y-m-d'],
            'amount' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:Paid,Due,Partial'],
            'due_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:month'],
            'paid_at' => ['nullable', 'date_format:Y-m-d H:i:s'],
        ]);

        // Ensure 'month' is stored as the first day of the month
        $request->merge(['month' => Carbon::parse($request->month)->startOfMonth()->format('Y-m-d')]);

        $rent->update($request->all());

        return redirect()->route('admin.rents.index')->with('success', 'Rent record updated successfully!');
    }

    /**
     * Remove the specified rent record from storage.
     */
    public function destroy(Rent $rent) // Using route model binding
    {
        $rent->delete();

        return redirect()->route('admin.rents.index')->with('success', 'Rent record deleted successfully!');
    }
}

