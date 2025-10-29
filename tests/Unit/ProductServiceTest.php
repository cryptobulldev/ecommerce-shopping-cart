<?php

namespace Tests\Unit;

use App\Jobs\LowStockNotificationJob;
use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\ProductService;
use Illuminate\Support\Facades\Bus;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    /** @var ProductRepositoryInterface&MockObject */
    private $repo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = $this->createMock(ProductRepositoryInterface::class);
    }

    public function test_reduce_stock_returns_false_if_product_missing(): void
    {
        $service = new ProductService($this->repo);
        $this->repo->method('find')->willReturn(null);
        $this->assertFalse($service->reduceStock(1, 1));
    }

    public function test_reduce_stock_updates_and_dispatches_notification_job_when_below_threshold(): void
    {
        Bus::fake();
        $service = new ProductService($this->repo);

        $product = new Product(['stock_quantity' => 6]);
        $this->repo->method('find')->willReturn($product);
        $this->repo->expects($this->once())
            ->method('updateStock')
            ->with(5, 1);

        // Use productId=5, quantity=5 -> new stock 1 (<5 triggers dispatch)
        $service->reduceStock(5, 5);

        Bus::assertDispatched(LowStockNotificationJob::class);
    }
}
