<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    /** @return Collection<int, Product> */
    public function all(): Collection;

    public function find(int $id): ?Product;

    public function updateStock(int $id, int $quantity): bool;
}
