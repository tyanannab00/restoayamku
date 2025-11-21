<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Product;

class AdminController extends Controller
{
    public function dashboard()
    {
        $orders = Order::with('product')->latest()->get();
        $products = Product::latest()->get();
        
        return view('admin.dashboard', compact('orders', 'products'));
    }
    public function destroyOrder($id)
    {
        try {
            $order = \App\Models\Order::findOrFail($id);
            $order->delete();
            
            return back()->with('success', 'Order berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus order');
        }
    }

}