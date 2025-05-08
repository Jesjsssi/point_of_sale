<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class StockController extends Controller
{
    public function edit(Product $product)
    {
        return view('stock.edit', [
            'product' => $product
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $rules = [
            'stock_change' => 'required|integer|min:1',
            'operation' => 'required|in:add,subtract',
        ];

        $validatedData = $request->validate($rules);

        // Update stock berdasarkan operasi yang dipilih
        if ($validatedData['operation'] === 'add') {
            $product->product_store += $validatedData['stock_change'];
        } else {
            // Cek apakah pengurangan valid
            if ($product->product_store < $validatedData['stock_change']) {
                return Redirect::back()->with('error', 'Stock tidak mencukupi untuk pengurangan!');
            }
            $product->product_store -= $validatedData['stock_change'];
        }

        $product->save();

        return Redirect::route('order.stockManage')->with('success', 'Stock berhasil diupdate!');
    }
} 