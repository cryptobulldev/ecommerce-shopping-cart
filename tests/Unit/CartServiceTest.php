<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\CartService;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class CartServiceTest extends TestCase
{
    /** @var CartRepositoryInterface&MockObject */
    private $cartRepo;

    /** @var ProductRepositoryInterface&MockObject */
    private $productRepo;

    private CartService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cartRepo    = $this->createMock(CartRepositoryInterface::class);
        $this->productRepo = $this->createMock(ProductRepositoryInterface::class);
        $this->service     = new CartService($this->cartRepo, $this->productRepo);
    }

    public function test_add_throws_when_product_not_found(): void
    {
        $this->productRepo->method('find')->willReturn(null);
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Product not found.');
        $this->service->add(123, 1);
    }

    public function test_add_throws_when_insufficient_stock(): void
    {
        $product = new Product(['stock_quantity' => 1]);
        $this->productRepo->method('find')->willReturn($product);
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Insufficient stock.');
        $this->service->add(123, 2);
    }

    public function test_add_calls_repository_when_ok(): void
    {
        $product = new Product(['stock_quantity' => 10]);
        $this->productRepo->method('find')->willReturn($product);
        $this->cartRepo->expects($this->once())
            ->method('add')
            ->with(123, 3);
        $this->service->add(123, 3);
    }
}
