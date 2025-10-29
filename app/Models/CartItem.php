<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\CartItemFactory>
 * @method static \Database\Factories\CartItemFactory factory($count = null, $state = [])
 */
class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'quantity'];

    /**
     * @phpstan-return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Product, \App\Models\CartItem>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
