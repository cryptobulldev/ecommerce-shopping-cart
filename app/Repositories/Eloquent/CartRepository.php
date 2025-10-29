<?php

namespace App\Repositories\Eloquent;

use App\Models\CartItem;
use App\Repositories\Interfaces\CartRepositoryInterface;
use Illuminate\Support\Collection;

class CartRepository implements CartRepositoryInterface
{
    /** @return Collection<int, CartItem> */
    public function all(): Collection
    {
        return CartItem::with('product')->get();
    }

    public function add(int $productId, int $quantity): CartItem
    {
        return CartItem::create(['product_id' => $productId, 'quantity' => $quantity]);
    }

    public function update(int $id, int $quantity): bool
    {
        return CartItem::where('id', $id)->update(['quantity' => $quantity]) > 0;
    }

    public function remove(int $id): bool
    {
        return CartItem::destroy($id) > 0;
    }

    public function clear(): void
    {
        CartItem::truncate();
    }
}
