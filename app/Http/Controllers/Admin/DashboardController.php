<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Data Points
        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $availableRooms = Room::where('status', 'available')->count();
        $totalTenants = Tenant::count();

        // Monthly Revenue Chart Data
        // Get the last 12 months
        $months = [];
        $revenueData = [];
        $currentMonth = Carbon::now()->startOfMonth();

        for ($i = 11; $i >= 0; $i--) {
            $month = $currentMonth->copy()->subMonths($i);
            $months[] = $month->format('M Y'); // e.g., Jan 2023

            // Calculate revenue for the current month
            $monthlyRevenue = Payment::whereYear('payment_date', $month->year)
                                    ->whereMonth('payment_date', $month->month)
                                    ->sum('amount');
            $revenueData[] = $monthlyRevenue;
        }

        return view('admin.dashboard.index', compact(
            'totalRooms',
            'occupiedRooms',
            'availableRooms',
            'totalTenants',
            'months',
            'revenueData'
        ));
    }
}

