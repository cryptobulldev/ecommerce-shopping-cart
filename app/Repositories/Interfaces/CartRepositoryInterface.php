<?php

namespace App\Repositories\Interfaces;

use App\Models\CartItem;
use Illuminate\Support\Collection;

interface CartRepositoryInterface
{
    /** @return Collection<int, CartItem> */
    public function all(): Collection;

    public function add(int $productId, int $quantity): CartItem;

    public function update(int $id, int $quantity): bool;

    public function remove(int $id): bool;

    public function clear(): void;
}
