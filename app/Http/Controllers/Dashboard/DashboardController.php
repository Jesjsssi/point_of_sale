<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){
        $orderQuery = Order::query();
        $productQuery = Product::query();

        if (!auth()->user()->roles->contains('name', 'superadmin')) {
            $orderQuery->where('koperasi_id', auth()->user()->koperasi_id);
            $productQuery->where('koperasi_id', auth()->user()->koperasi_id);
        }

        return view('dashboard.index', [
            'total_paid' => $orderQuery->sum('pay'),
            'total_due' => $orderQuery->sum('due'),
            'complete_orders' => $orderQuery->where('order_status', 'complete')->get(),
            'products' => $productQuery->orderBy('product_store')->take(5)->get(),
            'new_products' => $productQuery->orderBy('buying_date')->take(2)->get(),
        ]);
    }
}
