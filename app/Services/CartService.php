<?php

namespace App\Services;

use App\Models\CartItem;
use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;

class CartService
{
    public function __construct(
        protected CartRepositoryInterface $cartRepo,
        protected ProductRepositoryInterface $productRepo
    ) {}

    /** @return Collection<int, CartItem> */
    public function getAll(): Collection
    {
        return $this->cartRepo->all();
    }

    public function add(int $productId, int $quantity): CartItem
    {
        $product = $this->productRepo->find($productId);
        if (! $product) {
            throw new Exception('Product not found.');
        }

        if ($quantity > $product->stock_quantity) {
            throw new Exception('Insufficient stock.');
        }

        return $this->cartRepo->add($productId, $quantity);
    }

    public function update(int $cartId, int $quantity): bool
    {
        return $this->cartRepo->update($cartId, $quantity);
    }

    public function remove(int $cartId): bool
    {
        return $this->cartRepo->remove($cartId);
    }

    public function clear(): void
    {
        $this->cartRepo->clear();
    }
}
