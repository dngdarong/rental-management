<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rent;
use App\Models\Tenant;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; // <-- Ensure this import is present

class RentController extends Controller
{
    /**
     * Display a listing of the rents.
     */
    public function index()
    {
        $rents = Rent::with(['tenant', 'room'])->orderBy('month', 'desc')->paginate(10);
        
        $tenants = Tenant::all();
        $paymentMethods = ['Cash', 'Bank Transfer', 'Online Payment', 'Other'];

        return view('admin.rents.index', compact('rents', 'tenants', 'paymentMethods'));
    }

    /**
     * Show the form for creating a new rent record.
     */
    public function create()
    {
        $tenants = Tenant::all();
        $rooms = Room::all();
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
            'month' => ['required', 'date_format:Y-m-d'],
            'amount' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:Paid,Due,Partial'],
            'due_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:month'],
            'paid_at' => ['nullable', 'date_format:Y-m-d H:i:s'],
        ]);

        $request->merge(['month' => Carbon::parse($request->month)->startOfMonth()->format('Y-m-d')]);

        $rent = Rent::create($request->all());

        return redirect()->route('admin.rents.index')->with('success', 'Rent record created successfully!');
    }

    /**
     * Show the form for editing the specified rent record.
     */
    public function edit(Rent $rent)
    {
        $tenants = Tenant::all();
        $rooms = Room::all();
        return view('admin.rents.edit', compact('rent', 'tenants', 'rooms'));
    }

    /**
     * Update the specified rent record in storage.
     */
    public function update(Request $request, Rent $rent)
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

        $request->merge(['month' => Carbon::parse($request->month)->startOfMonth()->format('Y-m-d')]);

        $rent->update($request->all());

        $this->updateRentStatus($rent->id);

        return redirect()->route('admin.rents.index')->with('success', 'Rent record updated successfully!');
    }

    /**
     * Remove the specified rent record from storage.
     */
    public function destroy(Rent $rent)
    {
        $rentId = $rent->id;

        $rent->delete();

        if ($rentId) {
            $this->updateRentStatus($rentId);
        }

        return redirect()->route('admin.rents.index')->with('success', 'Rent record deleted successfully!');
    }

    /**
     * Helper function to update rent status based on payments.
     */
    protected function updateRentStatus($rentId)
    {
        $rent = Rent::find($rentId);
        if ($rent) {
            $totalPaidForRent = $rent->payments()->sum('amount');
            if ($totalPaidForRent >= $rent->amount) {
                $rent->status = 'Paid';
            } elseif ($totalPaidForRent > 0) {
                $rent->status = 'Partial';
            } else {
                $rent->status = 'Due';
            }
            $rent->save();
        }
    }

    /**
     * Generate a PDF invoice for the specified rent record.
     *
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function generatePdf(Rent $rent)
    {
        // Eager load relationships needed for the invoice
        $rent->load('tenant', 'room.roomType');

        $data = [
            'rent' => $rent,
            'app_name' => config('app.name'),
            'current_date' => Carbon::now()->format('M d, Y'),
        ];

        $pdf = Pdf::loadView('admin.rents.invoice_pdf', $data);

        // Stream the PDF to the browser or download it
        return $pdf->stream('invoice_rent_' . $rent->id . '_' . $rent->month->format('Y-m') . '.pdf');
        // Or to download: return $pdf->download('invoice_rent_' . $rent->id . '_' . $rent->month->format('Y-m') . '.pdf');
    }
}

