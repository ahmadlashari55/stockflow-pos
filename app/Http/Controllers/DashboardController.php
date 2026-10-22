<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Basic Stats
        $totalProducts = Product::count();
        $totalCustomers = Customer::count();
        
        // 2. Low Stock Products
        $lowStockCount = Product::lowStock()->count();
        
        // 3. Today's Sales
        $todaySales = Sale::whereDate('created_at', Carbon::today())->sum('total_amount');
        
        // 4. Recent 5 Sales
        $recentSales = Sale::with('customer', 'user')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalProducts', 
            'totalCustomers', 
            'lowStockCount', 
            'todaySales',
            'recentSales'
        ));
    }
}