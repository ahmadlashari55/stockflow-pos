<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    // POS Screen show karne ke liye
    public function index()
    {
        $products = Product::active()->where('stock_quantity', '>', 0)->get();
        $customers = Customer::active()->get();
        return view('pos.index', compact('products', 'customers'));
    }

    // Checkout / Sale Save karne ke liye
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'paid_amount' => 'required|numeric|min:0',
            'cart_items' => 'required|array|min:1'
        ]);

        try {
            DB::beginTransaction();

            // Total calculate karein backend par (Security ke liye)
            $subtotal = 0;
            foreach ($request->cart_items as $item) {
                $subtotal += ($item['price'] * $item['qty']);
            }

            $discount = $request->discount ?? 0;
            $total_amount = $subtotal - $discount;
            $due_amount = $total_amount - $request->paid_amount;

            // Invoice number generate karein (e.g. INV-0001)
            $lastSale = Sale::latest('id')->first();
            $nextId = $lastSale ? $lastSale->id + 1 : 1;
            $invoice_no = 'INV-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

            // 1. Sale Create karein
            $sale = Sale::create([
                'invoice_no' => $invoice_no,
                'customer_id' => $request->customer_id,
                'user_id' => auth()->id(),
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total_amount' => $total_amount,
                'paid_amount' => $request->paid_amount,
                'due_amount' => $due_amount,
                'payment_method' => 'cash'
            ]);

            // 2. Sale Items create karein aur Stock kam karein
            foreach ($request->cart_items as $item) {
                $product = Product::findOrFail($item['id']);
                
                // Check stock
                if ($product->stock_quantity < $item['qty']) {
                    throw new \Exception("Not enough stock for " . $product->name);
                }

                $itemSubtotal = $item['price'] * $item['qty'];

                // Sale Item save
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $item['qty'],
                    'unit_price' => $item['price'],
                    'subtotal' => $itemSubtotal
                ]);

                // Stock kam karein
                $stockBefore = $product->stock_quantity;
                $product->decrement('stock_quantity', $item['qty']);

                // Stock Movement Ledger mein entry
                StockMovement::create([
                    'product_id' => $product->id,
                    'user_id' => auth()->id(),
                    'type' => 'sale',
                    'quantity' => -$item['qty'], // Negative kyunke stock kam hua
                    'stock_before' => $stockBefore,
                    'stock_after' => $product->stock_quantity,
                    'reference_type' => Sale::class,
                    'reference_id' => $sale->id,
                    'note' => 'Sale via POS'
                ]);
            }

            DB::commit();

            // Redirect to invoice print page (hum agle phase mein banayenge)
            return response()->json([
                'success' => true, 
                'message' => 'Sale completed!',
                'sale_id' => $sale->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}