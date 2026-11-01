<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        
        $todayExpenses = Expense::whereDate('created_at', Carbon::today())->sum('amount');

        // 4. Recent 5 Sales
        $recentSales = Sale::with('customer', 'user')->latest()->take(5)->get();

               // Pichle 7 dinon ki sales ka data nikalna
        $chartData = Sale::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_amount) as total')
        )
        ->where('created_at', '>=', Carbon::now()->subDays(7))
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get();

        $dates = [];
        $totals = [];
        
        foreach($chartData as $data) {
            $dates[] = Carbon::parse($data->date)->format('d M'); // e.g. 22 Oct
            $totals[] = $data->total;
        }

        return view('dashboard', compact(
            'totalProducts', 
            'totalCustomers', 
            'lowStockCount', 
            'todaySales',
            'todayExpenses',
            'recentSales',
            'dates',    // Yeh naya data hai
            'totals'    // Yeh naya data hai
        ));
       
        
    }
}