<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            ['name' => 'Piece',    'short_name' => 'pcs', 'allow_decimal' => false],
            ['name' => 'Kilogram', 'short_name' => 'kg',  'allow_decimal' => true],
            ['name' => 'Litre',    'short_name' => 'L',   'allow_decimal' => true],
        ];
        foreach ($units as $unit) { Unit::updateOrCreate(['short_name' => $unit['short_name']], $unit); }

        foreach (['Beverages', 'Snacks', 'Dairy', 'Stationery', 'Household'] as $name) {
            Category::updateOrCreate(['name' => $name], ['is_active' => true]);
        }

        Supplier::updateOrCreate(['name' => 'Rahim Traders'], ['company_name' => 'Rahim Traders Ltd', 'phone' => '03001234567']);
        Customer::updateOrCreate(['phone' => '03009998887'], ['name' => 'Walk-in Customer']);

        $pcs = Unit::where('short_name', 'pcs')->first();
        $kg  = Unit::where('short_name', 'kg')->first();

        $products = [
            ['name' => 'Coca Cola 500ml', 'sku' => 'BEV-001', 'category' => 'Beverages',  'unit' => $pcs, 'cost' => 60,  'price' => 90,  'stock' => 120,  'low' => 20],
            ['name' => 'Lays Chips 40g',  'sku' => 'SNK-001', 'category' => 'Snacks',     'unit' => $pcs, 'cost' => 40,  'price' => 60,  'stock' => 80,   'low' => 15],
            ['name' => 'Fresh Milk',      'sku' => 'DRY-001', 'category' => 'Dairy',      'unit' => $kg,  'cost' => 150, 'price' => 200, 'stock' => 45.5, 'low' => 10],
            ['name' => 'A4 Notebook',     'sku' => 'STA-001', 'category' => 'Stationery', 'unit' => $pcs, 'cost' => 80,  'price' => 120, 'stock' => 8,    'low' => 10],
            ['name' => 'Dishwash Liquid', 'sku' => 'HSH-001', 'category' => 'Household',  'unit' => $pcs, 'cost' => 180, 'price' => 250, 'stock' => 3,    'low' => 5],
        ];

        foreach ($products as $item) {
            Product::updateOrCreate(
                ['sku' => $item['sku']],
                [
                    'name' => $item['name'], 'category_id' => Category::where('name', $item['category'])->value('id'),
                    'unit_id' => $item['unit']?->id, 'supplier_id' => Supplier::inRandomOrder()->value('id'),
                    'cost_price' => $item['cost'], 'selling_price' => $item['price'],
                    'stock_quantity' => $item['stock'], 'low_stock_threshold' => $item['low'],
                    'track_stock' => true, 'is_active' => true,
                ]
            );
        }
    }
}