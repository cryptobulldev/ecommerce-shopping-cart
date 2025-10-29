<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderService
{
    public function __construct(
        protected OrderRepositoryInterface $orderRepo,
        protected CartRepositoryInterface $cartRepo,
        protected ProductService $productService
    ) {}

    public function checkout(): Order
    {
        $cartItems = $this->cartRepo->all();
        abort_if($cartItems->isEmpty(), 400, 'Cart is empty');

        $total = $cartItems->sum(fn ($i) => $i->product->price * $i->quantity);
        $order = $this->orderRepo->create(['total_price' => $total]);

        foreach ($cartItems as $item) {
            /** @var array{product_id:int,quantity:int,price:int|float} $attributes */
            $attributes = [
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->price,
            ];
            $order->items()->create($attributes);

            // Reduce stock and trigger low-stock job if needed
            $this->productService->reduceStock($item->product_id, $item->quantity);
        }

        $this->cartRepo->clear();

        return $order->load('items.product');
    }
}
