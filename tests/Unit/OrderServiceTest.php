<?php

namespace Tests\Unit;

use App\Models\CartItem;
use App\Models\Product;
use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @var CartRepositoryInterface&MockObject */
    private $cartRepo;

    /** @var OrderRepositoryInterface&MockObject */
    private $orderRepo;

    /** @var ProductService&MockObject */
    private $productService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cartRepo       = $this->createMock(CartRepositoryInterface::class);
        $this->orderRepo      = $this->createMock(OrderRepositoryInterface::class);
        $this->productService = $this->getMockBuilder(ProductService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['reduceStock'])
            ->getMock();
    }

    public function test_checkout_aborts_on_empty_cart(): void
    {
        $this->cartRepo->method('all')->willReturn(new Collection);
        $service = new OrderService($this->orderRepo, $this->cartRepo, $this->productService);

        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);
        $service->checkout();
    }

    public function test_checkout_creates_order_items_and_clears_cart(): void
    {
        $product  = Product::factory()->create(['price' => 1200]);
        $cartItem = CartItem::factory()->make([
            'product_id' => $product->id,
            'quantity'   => 2,
        ]);
        $cartItem->setRelation('product', $product);

        $this->cartRepo->method('all')->willReturn(collect([$cartItem]));

        $this->orderRepo->method('create')->willReturn(
            \App\Models\Order::create(['total_price' => 2400])
        );

        $this->productService->expects($this->once())
            ->method('reduceStock')
            ->with($product->id, 2);

        $this->cartRepo->expects($this->once())->method('clear');

        $service = new OrderService($this->orderRepo, $this->cartRepo, $this->productService);
        $order   = $service->checkout();

        $this->assertDatabaseHas('orders', ['id' => $order->id, 'total_price' => 2400]);
        $this->assertDatabaseHas('order_items', [
            'order_id'   => $order->id,
            'product_id' => $product->id,
            'quantity'   => 2,
            'price'      => 1200,
        ]);
    }
}
