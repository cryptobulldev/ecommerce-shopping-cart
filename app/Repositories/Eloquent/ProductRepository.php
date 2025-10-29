<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    /** @return Collection<int, Product> */
    public function all(): Collection
    {
        return Product::all();
    }

    public function find(int $id): ?Product
    {
        return Product::find($id);
    }

    public function updateStock(int $id, int $quantity): bool
    {
        return Product::where('id', $id)->update(['stock_quantity' => $quantity]) > 0;
    }
}
