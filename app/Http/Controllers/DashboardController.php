<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Outlet;
use App\Models\Staff;
use App\Models\Owner;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {
    public function index() {
        $user = auth()->user();

        if ($user->hasRole('staff')) {
            return $this->staffDashboard();
        } elseif ($user->hasRole('owner')) {
            return $this->ownerDashboard();
        } elseif ($user->hasRole('customer')) {
            return $this->customerDashboard();
        }

        return view('dashboard');
    }

    protected function staffDashboard() {
        $staff = Staff::where('user_id', auth()->id())->first();

        if (!$staff) {
            return view('dashboard');
        }

        // order by status
        $ordersByStatus = Order::where('outlet_id', $staff->outlet_id)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // fill missing status with 0
        $statuses = ['ordered', 'accepted', 'being_washed', 'ready_for_pickup', 'done'];
        $ordersByStatus = collect($statuses)->mapWithKeys(function ($status) use ($ordersByStatus) {
            return [$status => $ordersByStatus[$status] ?? 0];
        })->toArray();

        // order today
        $todayOrders = Order::where('outlet_id', $staff->outlet_id)
            ->whereDate('created_at', today())
            ->count();

        // pending order
        $pendingOrders = Order::where('outlet_id', $staff->outlet_id)
            ->whereIn('status', ['ordered', 'accepted', 'being_washed', 'ready_for_pickup'])
            ->count();

        // monthly revenue
        $monthlyRevenue = Order::where('outlet_id', $staff->outlet_id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        // recent order
        $recentOrders = Order::with(['customer.profile'])
            ->where('outlet_id', $staff->outlet_id)
            ->latest()
            ->take(5)
            ->get();

        // weekly, daily order 
        $dailyOrdersThisWeek = Order::where('outlet_id', $staff->outlet_id)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        return view('dashboard.staff', compact(
            'ordersByStatus',
            'todayOrders',
            'pendingOrders',
            'monthlyRevenue',
            'recentOrders',
            'dailyOrdersThisWeek'
        ));
    }

    protected function ownerDashboard() {
        $owner = Owner::where('user_id', auth()->id())->first();

        if (!$owner) {
            return view('dashboard');
        }

        $outlets = Outlet::where('owner_id', $owner->id)->get();
        $outletIds = $outlets->pluck('id');

        // total sales per oulet
        $salesByOutlet = Order::whereIn('outlet_id', $outletIds)
            ->select('outlet_id', DB::raw('SUM(total) as total_sales'))
            ->groupBy('outlet_id')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->outlet->name => $item->total_sales];
            })
            ->toArray();

        // total revenue
        $totalRevenue = Order::whereIn('outlet_id', $outletIds)
            ->sum('total');

        // monthly revenue
        $monthlyRevenue = Order::whereIn('outlet_id', $outletIds)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        // total orders
        $totalOrders = Order::whereIn('outlet_id', $outletIds)->count();

        // orders by status on all outlets
        $ordersByStatus = Order::whereIn('outlet_id', $outletIds)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $statuses = ['ordered', 'accepted', 'being_washed', 'ready_for_pickup', 'done'];
        $ordersByStatus = collect($statuses)->mapWithKeys(function ($status) use ($ordersByStatus) {
            return [$status => $ordersByStatus[$status] ?? 0];
        })->toArray();

        // monthly sales trajectory
        $monthlySalesTrend = Order::whereIn('outlet_id', $outletIds)
            ->where('created_at', '>=', now()->subMonths(6))
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(total) as total_sales')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total_sales', 'month')
            ->toArray();

        // orders by outlet
        $ordersByOutlet = Order::whereIn('outlet_id', $outletIds)
            ->select('outlet_id', DB::raw('count(*) as count'))
            ->groupBy('outlet_id')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->outlet->name => $item->count];
            })
            ->toArray();

        // top performing outlets (by revenue)
        $topOutlets = Order::whereIn('outlet_id', $outletIds)
            ->select('outlet_id', DB::raw('SUM(total) as revenue'), DB::raw('count(*) as orders'))
            ->groupBy('outlet_id')
            ->orderByDesc('revenue')
            ->take(5)
            ->get();

        return view('dashboard.owner', compact(
            'outlets',
            'salesByOutlet',
            'totalRevenue',
            'monthlyRevenue',
            'totalOrders',
            'ordersByStatus',
            'monthlySalesTrend',
            'ordersByOutlet',
            'topOutlets'
        ));
    }

    protected function customerDashboard() {
        return view('dashboard.customer');
    }
}
