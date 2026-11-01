<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Default: Is mahine ki 1 tareekh se aaj tak
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        // Data fetch karna
        $sales = Sale::with('customer')->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->get();
        $expenses = Expense::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->get();

        // Summary calculate karna
        $totalSales = $sales->sum('total_amount');
        $totalExpenses = $expenses->sum('amount');
        $netProfit = $totalSales - $totalExpenses;

        return view('reports.index', compact(
            'sales', 'expenses', 'startDate', 'endDate', 
            'totalSales', 'totalExpenses', 'netProfit'
        ));
    }

    public function exportCsv(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $sales = Sale::with('customer')->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->get();
        $expenses = Expense::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->get();

        $fileName = 'report_' . $startDate . '_to_' . $endDate . '.csv';
        
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $callback = function() use($sales, $expenses) {
            $file = fopen('php://output', 'w');
            
            // Sales Section
            fputcsv($file, ['--- SALES REPORT ---']);
            fputcsv($file, ['Invoice No', 'Customer', 'Date', 'Total Amount (Rs)']);
            foreach ($sales as $sale) {
                fputcsv($file, [$sale->invoice_no, $sale->customer->name ?? 'Walk-in', $sale->created_at->format('d M Y, h:i A'), $sale->total_amount]);
            }
            
            fputcsv($file, []); // Empty line

            // Expenses Section
            fputcsv($file, ['--- EXPENSES REPORT ---']);
            fputcsv($file, ['Title', 'Date', 'Amount (Rs)', 'Note']);
            foreach ($expenses as $expense) {
                fputcsv($file, [$expense->title, $expense->expense_date, $expense->amount, $expense->note]);
            }

            fputcsv($file, []);
            fputcsv($file, ['--- SUMMARY ---']);
            fputcsv($file, ['Total Sales', $sales->sum('total_amount')]);
            fputcsv($file, ['Total Expenses', $expenses->sum('amount')]);
            fputcsv($file, ['Net Profit', $sales->sum('total_amount') - $expenses->sum('amount')]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}