<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rent;
use App\Models\Tenant;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class RentController extends Controller
{
    /**
     * Display a listing of the rents.
     */
    public function index()
    {
        // Eager load tenant and room relationships
        $rents = Rent::with(['tenant', 'room'])->orderBy('month', 'desc')->paginate(10);
        
        // Ensure $tenants and $paymentMethods are passed to the view for the filter dropdowns
        $tenants = Tenant::all(); // Fetches all tenants
        $paymentMethods = ['Cash', 'Bank Transfer', 'Online Payment', 'Other']; // Define available payment methods

        return view('admin.rents.index', compact('rents', 'tenants', 'paymentMethods')); // <-- Make sure 'paymentMethods' is included here
    }

    // ... (rest of the controller methods)

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
    }
}

