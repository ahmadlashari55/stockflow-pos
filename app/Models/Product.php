<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id', 'unit_id', 'supplier_id', 'name', 'sku', 'barcode', 'description', 'image',
        'cost_price', 'selling_price', 'tax_rate', 'stock_quantity', 'low_stock_threshold',
        'track_stock', 'is_active',
    ];

    protected $casts = [
        'cost_price'          => 'decimal:2',
        'selling_price'       => 'decimal:2',
        'tax_rate'            => 'decimal:2',
        'stock_quantity'      => 'decimal:3',
        'low_stock_threshold' => 'decimal:3',
        'track_stock'         => 'boolean',
        'is_active'           => 'boolean',
    ];

    public function category() { return $this->belongsTo(Category::class); }
    public function unit() { return $this->belongsTo(Unit::class); }
    public function supplier() { return $this->belongsTo(Supplier::class); }
    public function stockMovements() { return $this->hasMany(StockMovement::class); }

    public function getProfitMarginAttribute(): float
    {
        if ((float) $this->selling_price <= 0) return 0;
        return round((((float) $this->selling_price - (float) $this->cost_price) / (float) $this->selling_price) * 100, 2);
    }

    public function getIsLowStockAttribute(): bool
    {
        if (! $this->track_stock) return false;
        return (float) $this->stock_quantity <= (float) $this->low_stock_threshold;
    }

    public function scopeActive(Builder $query): Builder { return $query->where('is_active', true); }

    public function scopeLowStock(Builder $query): Builder
    {
        return $query->where('track_stock', true)->whereColumn('stock_quantity', '<=', 'low_stock_threshold');
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (blank($term)) return $query;
        return $query->where(function (Builder $q) use ($term) {
            $q->where('name', 'like', "%{$term}%")->orWhere('sku', 'like', "%{$term}%")->orWhere('barcode', 'like', "%{$term}%");
        });
    }
}