<?php

namespace Tests\Feature;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_index_requires_authentication(): void
    {
        $response = $this->get(route('shop.cart.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_cart_index_displays_items(): void
    {
        $user    = User::factory()->create();
        $product = Product::factory()->create();
        CartItem::factory()->create(['product_id' => $product->id, 'quantity' => 2]);

        $response = $this->actingAs($user)->get(route('shop.cart.index'));
        $response->assertOk();
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Cart/Index')
            ->has('cart')
        );
    }

    public function test_store_validates_input(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('shop.cart.store'), [
            'product_id' => 999999,
            'quantity'   => 0,
        ]);

        $response->assertSessionHasErrors(['product_id', 'quantity']);
    }

    public function test_store_adds_item_to_cart(): void
    {
        $user    = User::factory()->create();
        $product = Product::factory()->create(['stock_quantity' => 10]);

        $response = $this->actingAs($user)->post(route('shop.cart.store'), [
            'product_id' => $product->id,
            'quantity'   => 3,
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
            'quantity'   => 3,
        ]);
    }

    public function test_update_changes_quantity(): void
    {
        $user    = User::factory()->create();
        $product = Product::factory()->create();
        $item    = CartItem::factory()->create(['product_id' => $product->id, 'quantity' => 1]);

        $response = $this->actingAs($user)->patch(route('shop.cart.update', $item->id), [
            'quantity' => 5,
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('cart_items', [
            'id'       => $item->id,
            'quantity' => 5,
        ]);
    }

    public function test_destroy_removes_item(): void
    {
        $user    = User::factory()->create();
        $product = Product::factory()->create();
        $item    = CartItem::factory()->create(['product_id' => $product->id, 'quantity' => 1]);

        $response = $this->actingAs($user)->delete(route('shop.cart.destroy', $item->id));

        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('cart_items', [
            'id' => $item->id,
        ]);
    }
}
