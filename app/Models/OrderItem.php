<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\OrderItemFactory>
 * @method static \Database\Factories\OrderItemFactory factory($count = null, $state = [])
 */
class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    /**
     * @phpstan-return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Product, \App\Models\OrderItem>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
