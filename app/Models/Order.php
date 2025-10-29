<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @use \Illuminate\Database\Eloquent\Factories\HasFactory<\Database\Factories\OrderFactory>
 * @method static \Database\Factories\OrderFactory factory($count = null, $state = [])
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = ['total_price'];

    /**
     * @phpstan-return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\OrderItem, \App\Models\Order>
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
