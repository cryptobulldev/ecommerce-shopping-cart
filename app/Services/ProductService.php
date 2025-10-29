<?php

namespace App\Services;

use App\Jobs\LowStockNotificationJob;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;

class ProductService
{
    public function __construct(
        protected ProductRepositoryInterface $products
    ) {}

    /** @return Collection<int, mixed> */
    public function getAll(): Collection
    {
        return $this->products->all();
    }

    public function reduceStock(int $productId, int $quantity): bool
    {
        $product = $this->products->find($productId);
        if (! $product) {
            return false;
        }

        $newStock = $product->stock_quantity - $quantity;
        $this->products->updateStock($productId, $newStock);

        if ($newStock < 5) { // threshold
            Bus::dispatch(new LowStockNotificationJob($product));
        }

        return true;
    }
}
