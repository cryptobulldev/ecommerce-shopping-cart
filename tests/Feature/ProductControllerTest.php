<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_index_requires_authentication(): void
    {
        $response = $this->get(route('shop.products.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_products_index_displays_products_via_inertia(): void
    {
        $user = User::factory()->create();
        Product::factory()->count(3)->create();

        $response = $this->actingAs($user)->get(route('shop.products.index'));

        $response->assertOk();
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Products/Index')
            ->where('products.0.id', Product::first()->id)
        );
    }
}
