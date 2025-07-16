<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomType; // Import RoomType model
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Import Rule for unique validation

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the room types.
     */
    public function index()
    {
        $roomTypes = RoomType::paginate(10);
        return view('admin.room_types.index', compact('roomTypes'));
    }

    /**
     * Show the form for creating a new room type.
     */
    public function create()
    {
        return view('admin.room_types.create');
    }

    /**
     * Store a newly created room type in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:room_types,name'],
            'description' => ['nullable', 'string', 'max:1000'],
            'default_price' => ['required', 'numeric', 'min:0'],
        ]);

        RoomType::create($request->all());

        return redirect()->route('admin.room-types.index')->with('success', 'Room Type created successfully!');
    }

    /**
     * Show the form for editing the specified room type.
     */
    public function edit(RoomType $roomType) // Using route model binding
    {
        return view('admin.room_types.edit', compact('roomType'));
    }

    /**
     * Update the specified room type in storage.
     */
    public function update(Request $request, RoomType $roomType) // Using route model binding
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('room_types')->ignore($roomType->id)],
            'description' => ['nullable', 'string', 'max:1000'],
            'default_price' => ['required', 'numeric', 'min:0'],
        ]);

        $roomType->update($request->all());

        return redirect()->route('admin.room-types.index')->with('success', 'Room Type updated successfully!');
    }

    /**
     * Remove the specified room type from storage.
     */
    public function destroy(RoomType $roomType) // Using route model binding
    {
        // Optional: Add logic to prevent deletion if rooms are associated with this room type
        // e.g., if ($roomType->rooms()->count() > 0) { return back()->with('error', 'Cannot delete room type with associated rooms.'); }

        $roomType->delete();

        return redirect()->route('admin.room-types.index')->with('success', 'Room Type deleted successfully!');
    }
}

