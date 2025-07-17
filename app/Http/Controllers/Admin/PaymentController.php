<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Tenant; // Import Tenant model
use App\Models\Rent;   // Import Rent model
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class PaymentController extends Controller
{
    /**
     * Display a listing of the payments.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['tenant', 'rent.room'])
                        ->orderBy('payment_date', 'desc');

        // Filter by tenant
        if ($request->filled('tenant_id')) {
            $query->where('tenant_id', $request->tenant_id);
        }

        // Filter by month (assuming 'YYYY-MM' format from input)
        if ($request->filled('month')) {
            $month = Carbon::parse($request->month);
            $query->whereYear('payment_date', $month->year)
                  ->whereMonth('payment_date', $month->month);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $payments = $query->paginate(10);
        
        // Ensure $tenants and $paymentMethods are passed to the view
        $tenants = Tenant::all(); // <-- This line fetches all tenants
        $paymentMethods = ['Cash', 'Bank Transfer', 'Online Payment', 'Other']; // Define available methods

        return view('admin.payments.index', compact('payments', 'tenants', 'paymentMethods'));
    }

    // ... (other methods like create, store, edit, update, destroy, updateRentStatus)
}

