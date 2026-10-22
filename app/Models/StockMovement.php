<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'user_id', 'type', 'quantity', 'unit_cost',
        'stock_before', 'stock_after', 'reference_type', 'reference_id', 'note',
    ];

    protected $casts = [
        'quantity'     => 'decimal:3',
        'unit_cost'    => 'decimal:2',
        'stock_before' => 'decimal:3',
        'stock_after'  => 'decimal:3',
    ];

    public function product() { return $this->belongsTo(Product::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function reference() { return $this->morphTo(); }

    public function getIsIncomingAttribute(): bool
    {
        return in_array($this->type, ['opening', 'purchase', 'return_in'], true);
    }
}