<?php

namespace Tests\Unit;

use App\Jobs\DailySalesReportJob;
use App\Jobs\LowStockNotificationJob;
use App\Mail\DailySalesReportMail;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class JobsTest extends TestCase
{
    use RefreshDatabase;

    public function test_low_stock_notification_job_sends_notification(): void
    {
        Notification::fake();
        config(['mail.admin_email' => 'admin@test.com']);

        $product = Product::factory()->create(['stock_quantity' => 2]);
        (new LowStockNotificationJob($product))->handle();

        Notification::assertSentOnDemand(\App\Notifications\LowStockNotification::class, function ($notification, $channels, $notifiable) {
            return in_array('mail', $channels ?? []) && ($notifiable->routes['mail'] ?? null) === 'admin@test.com';
        });
    }

    public function test_daily_sales_report_job_sends_mailable(): void
    {
        Mail::fake();
        config(['mail.admin_email' => 'admin@test.com']);

        $product = Product::factory()->create(['price' => 500]);
        OrderItem::factory()->create([
            'product_id' => $product->id,
            'quantity'   => 2,
            'price'      => 500,
            'created_at' => now(),
        ]);

        (new DailySalesReportJob)->handle();

        Mail::assertQueued(DailySalesReportMail::class, function ($mail) {
            return $mail->hasTo('admin@test.com');
        });
    }
}
