<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Order;
use App\Models\Product;
use App\Models\PaySalary;
use App\Models\AdvanceSalary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get current month's data
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        // Get daily revenue and cost data for chart
        $dailyData = DB::table('orders')
            ->whereBetween('created_at', [
                $startDate,
                $endDate
            ])
            ->where('order_status', 'complete')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as revenue'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

        // Get daily expenses
        $dailyExpenses = DB::table('pay_salaries')
            ->whereBetween('created_at', [
                $startDate,
                $endDate
            ])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(paid_amount) as cost'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

        // Merge revenue and cost data
        $chartData = [];
        foreach ($dailyData as $data) {
            $chartData[$data->date] = [
                'revenue' => $data->revenue,
                'cost' => 0
            ];
        }

        foreach ($dailyExpenses as $expense) {
            if (isset($chartData[$expense->date])) {
                $chartData[$expense->date]['cost'] = $expense->cost;
            } else {
                $chartData[$expense->date] = [
                    'revenue' => 0,
                    'cost' => $expense->cost
                ];
            }
        }

        ksort($chartData);

        return view('dashboard.index', [
            'total_paid' => Order::sum('pay'),
            'total_due' => Order::sum('due'),
            'complete_orders' => Order::where('order_status', 'complete')->get(),
            'products' => Product::orderBy('product_store')->take(5)->get(),
            'new_products' => Product::orderBy('buying_date')->take(2)->get(),
            'chartData' => $chartData
        ]);
    }
}
