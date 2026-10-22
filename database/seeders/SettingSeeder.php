<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'business_name'    => 'StockFlow Store',
            'business_phone'   => '0300-0000000',
            'business_email'   => 'hello@stockflow.test',
            'business_address' => '123 Main Street, Lahore',
            'currency_symbol'  => 'Rs',
            'currency_code'    => 'PKR',
            'default_tax_rate' => '0',
            'invoice_prefix'   => 'INV-',
            'low_stock_alert'  => '1',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}