<?php

namespace Tests\Unit;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use App\Repositories\Eloquent\CartRepository;
use App\Repositories\Eloquent\OrderRepository;
use App\Repositories\Eloquent\ProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RepositoriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_repository_crud(): void
    {
        $repo    = new ProductRepository;
        $product = Product::factory()->create(['stock_quantity' => 10]);

        $this->assertNotNull($repo->find($product->id));
        $this->assertCount(1, $repo->all());

        $repo->updateStock($product->id, 4);
        $this->assertDatabaseHas('products', ['id' => $product->id, 'stock_quantity' => 4]);
    }

    public function test_cart_repository_crud(): void
    {
        $repo    = new CartRepository;
        $product = Product::factory()->create();

        $item = $repo->add($product->id, 2);
        $this->assertInstanceOf(CartItem::class, $item);
        $this->assertCount(1, $repo->all());

        $this->assertTrue($repo->update($item->id, 5));
        $this->assertDatabaseHas('cart_items', ['id' => $item->id, 'quantity' => 5]);

        $this->assertTrue($repo->remove($item->id));
        $this->assertDatabaseMissing('cart_items', ['id' => $item->id]);

        $repo->add($product->id, 1);
        $repo->clear();
        $this->assertDatabaseCount('cart_items', 0);
    }

    public function test_order_repository_create(): void
    {
        $repo  = new OrderRepository;
        $order = $repo->create(['total_price' => 1234]);
        $this->assertInstanceOf(Order::class, $order);
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'total_price' => 1234]);
    }
}
