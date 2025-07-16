<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType; // Import RoomType model
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Import Rule for unique validation

class RoomController extends Controller
{
    /**
     * Display a listing of the rooms.
     */
    public function index()
    {
        // Paginate rooms and eager load their roomType to avoid N+1 query problem
        $rooms = Room::with('roomType')->paginate(10);
        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new room.
     */
    public function create()
    {
        // Get all room types for the dropdown
        $roomTypes = RoomType::all();
        return view('admin.rooms.create', compact('roomTypes'));
    }

    /**
     * Store a newly created room in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_number' => ['required', 'string', 'max:255', 'unique:rooms,room_number'],
            'room_type_id' => ['required', 'exists:room_types,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:available,occupied,under_maintenance'],
        ]);

        Room::create($request->all());

        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully!');
    }

    /**
     * Show the form for editing the specified room.
     */
    public function edit(Room $room) // Using route model binding
    {
        $roomTypes = RoomType::all();
        return view('admin.rooms.edit', compact('room', 'roomTypes'));
    }

    /**
     * Update the specified room in storage.
     */
    public function update(Request $request, Room $room) // Using route model binding
    {
        $request->validate([
            'room_number' => ['required', 'string', 'max:255', Rule::unique('rooms')->ignore($room->id)],
            'room_type_id' => ['required', 'exists:room_types,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:available,occupied,under_maintenance'],
        ]);

        $room->update($request->all());

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully!');
    }

    /**
     * Remove the specified room from storage.
     */
    public function destroy(Room $room) // Using route model binding
    {
        // Optional: Add logic to prevent deletion if room is occupied by a tenant
        // e.g., if ($room->status == 'occupied') { return back()->with('error', 'Cannot delete an occupied room.'); }

        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully!');
    }
}

