<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('sales', function (Blueprint $table) {
        $table->id();
        $table->string('invoice_no')->unique(); // INV-001
        $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
        $table->foreignId('user_id')->constrained(); // Kis cashier ne becha
        
        $table->decimal('subtotal', 15, 2)->default(0);
        $table->decimal('discount', 15, 2)->default(0);
        $table->decimal('tax', 15, 2)->default(0);
        $table->decimal('total_amount', 15, 2)->default(0);
        
        $table->decimal('paid_amount', 15, 2)->default(0);
        $table->decimal('due_amount', 15, 2)->default(0);
        $table->string('payment_method')->default('cash'); // cash, card, etc.
        
        $table->timestamps();
        $table->softDeletes();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
