<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Tenant; // Import Tenant model
use App\Models\Rent;   // Import Rent model (optional, if linking payments to specific rents)
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
        $query = Payment::with(['tenant', 'rent.room']) // Eager load tenant and rent (with its room)
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
        $tenants = Tenant::all(); // For filter dropdown
        $paymentMethods = ['Cash', 'Bank Transfer', 'Online Payment', 'Other']; // Define available methods

        return view('admin.payments.index', compact('payments', 'tenants', 'paymentMethods'));
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create()
    {
        $tenants = Tenant::all();
        $rents = Rent::all(); // Optional: if you want to link payments to existing rent records
        $paymentMethods = ['Cash', 'Bank Transfer', 'Online Payment', 'Other'];
        return view('admin.payments.create', compact('tenants', 'rents', 'paymentMethods'));
    }

    /**
     * Store a newly created payment in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tenant_id' => ['required', 'exists:tenants,id'],
            'rent_id' => ['nullable', 'exists:rents,id'], // Optional: link to a specific rent record
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_method' => ['required', 'in:Cash,Bank Transfer,Online Payment,Other'],
            'payment_date' => ['required', 'date_format:Y-m-d H:i'], // Expecting YYYY-MM-DD HH:MM
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        // Convert payment_date to a proper datetime format for database
        $request->merge(['payment_date' => Carbon::parse($request->payment_date)->format('Y-m-d H:i:s')]);

        $payment = Payment::create($request->all());

        // Optional: Update the status of the associated rent record if rent_id is provided
        if ($payment->rent_id) {
            $rent = Rent::find($payment->rent_id);
            if ($rent) {
                // Logic to update rent status (e.g., 'Partial' or 'Paid')
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

        return redirect()->route('admin.payments.index')->with('success', 'Payment recorded successfully!');
    }

    /**
     * Show the form for editing the specified payment.
     */
    public function edit(Payment $payment) // Using route model binding
    {
        $tenants = Tenant::all();
        $rents = Rent::all();
        $paymentMethods = ['Cash', 'Bank Transfer', 'Online Payment', 'Other'];
        return view('admin.payments.edit', compact('payment', 'tenants', 'rents', 'paymentMethods'));
    }

    /**
     * Update the specified payment in storage.
     */
    public function update(Request $request, Payment $payment) // Using route model binding
    {
        $request->validate([
            'tenant_id' => ['required', 'exists:tenants,id'],
            'rent_id' => ['nullable', 'exists:rents,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_method' => ['required', 'in:Cash,Bank Transfer,Online Payment,Other'],
            'payment_date' => ['required', 'date_format:Y-m-d H:i'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $oldRentId = $payment->rent_id; // Store old rent_id to potentially update its status later

        $request->merge(['payment_date' => Carbon::parse($request->payment_date)->format('Y-m-d H:i:s')]);

        $payment->update($request->all());

        // Optional: Update status of old and new associated rent records
        if ($oldRentId && $oldRentId != $payment->rent_id) {
            $this->updateRentStatus($oldRentId);
        }
        if ($payment->rent_id) {
            $this->updateRentStatus($payment->rent_id);
        }


        return redirect()->route('admin.payments.index')->with('success', 'Payment updated successfully!');
    }

    /**
     * Remove the specified payment from storage.
     */
    public function destroy(Payment $payment) // Using route model binding
    {
        $rentId = $payment->rent_id; // Store rent_id before deleting payment

        $payment->delete();

        // Optional: Update status of the associated rent record
        if ($rentId) {
            $this->updateRentStatus($rentId);
        }

        return redirect()->route('admin.payments.index')->with('success', 'Payment deleted successfully!');
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
}

