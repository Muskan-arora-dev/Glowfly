<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PaymentDashboardController extends Controller
{
    public function index()
    {
        // ===== TOTAL PAYMENTS =====
        $totalPayment = DB::table('orders')->sum('total');

        $successPayment = DB::table('orders')
            ->where('status', 'delivered')
            ->sum('total');

        $pendingPayment = DB::table('orders')
            ->where('status', 'pending')
            ->sum('total');

        $failedPayment = DB::table('orders')
            ->where('status', 'cancelled')
            ->sum('total');

        // ===== MONTHLY GRAPH (PostgreSQL SAFE) =====
        $monthlyData = DB::table('orders')
            ->selectRaw("EXTRACT(MONTH FROM orders.created_at) as month, SUM(total) as total")
            ->whereYear('orders.created_at', date('Y'))
            ->groupByRaw("EXTRACT(MONTH FROM orders.created_at)")
            ->orderByRaw("EXTRACT(MONTH FROM orders.created_at)")
            ->get();

        $months = [];
        $monthlyPayments = [];

        foreach ($monthlyData as $row) {
            $months[] = date("M", mktime(0, 0, 0, $row->month, 1));
            $monthlyPayments[] = $row->total;
        }

        // ===== RECENT ORDERS / PAYMENTS =====
        $payments = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'orders.id',
                'users.name as user_name',
                'orders.total as amount',
                'orders.status',
                'orders.created_at'
            )
            ->orderBy('orders.created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.payment-dashboard', compact(
            'totalPayment',
            'successPayment',
            'pendingPayment',
            'failedPayment',
            'months',
            'monthlyPayments',
            'payments'
        ));
    }
}
