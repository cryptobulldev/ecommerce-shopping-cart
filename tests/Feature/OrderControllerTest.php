<?php

namespace Tests\Feature;

use App\Jobs\LowStockNotificationJob;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_requires_authentication(): void
    {
        $response = $this->post(route('shop.checkout.store'));
        $response->assertRedirect(route('login'));
    }

    public function test_checkout_creates_order_and_clears_cart_and_reduces_stock(): void
    {
        Bus::fake();

        $user    = User::factory()->create();
        $product = Product::factory()->create([
            'price'          => 1000,
            'stock_quantity' => 5,
        ]);
        CartItem::factory()->create([
            'product_id' => $product->id,
            'quantity'   => 3,
        ]);

        $response = $this->actingAs($user)->post(route('shop.checkout.store'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('orders', [
            'total_price' => 3000,
        ]);
        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'quantity'   => 3,
            'price'      => 1000,
        ]);
        $this->assertDatabaseMissing('cart_items', []); // truncated table

        $this->assertDatabaseHas('products', [
            'id'             => $product->id,
            'stock_quantity' => 2,
        ]);

        Bus::assertDispatched(LowStockNotificationJob::class);
    }

    public function test_checkout_fails_when_cart_is_empty(): void
    {
        $user     = User::factory()->create();
        $response = $this->actingAs($user)->post(route('shop.checkout.store'));
        $response->assertStatus(400);
    }
}
