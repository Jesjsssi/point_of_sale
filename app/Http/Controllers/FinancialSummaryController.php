<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\PaySalary;
use App\Models\AdvanceSalary;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FinancialSummaryController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Get total sales
        $totalSales = Order::whereBetween('created_at', [
            Carbon::parse($startDate)->startOfDay(),
            Carbon::parse($endDate)->endOfDay()
        ])
            ->where('order_status', 'complete')
            ->sum('total');

        // Get total expenses (salaries)
        $totalSalaries = PaySalary::whereBetween('created_at', [
            Carbon::parse($startDate)->startOfDay(),
            Carbon::parse($endDate)->endOfDay()
        ])
            ->sum('paid_amount');

        $totalAdvanceSalaries = AdvanceSalary::whereBetween('created_at', [
            Carbon::parse($startDate)->startOfDay(),
            Carbon::parse($endDate)->endOfDay()
        ])
            ->sum('advance_salary');

        $totalExpenses = $totalSalaries + $totalAdvanceSalaries;

        // Calculate net income
        $netIncome = $totalSales - $totalExpenses;

        // Get daily revenue and cost data for chart
        $dailyData = DB::table('orders')
            ->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ])
            ->where('order_status', 'complete')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as revenue'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

        // Get daily expenses
        $dailyExpenses = DB::table('pay_salaries')
            ->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
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

        return view('financial.summary', compact(
            'totalSales',
            'totalExpenses',
            'netIncome',
            'chartData',
            'startDate',
            'endDate'
        ));
    }
}