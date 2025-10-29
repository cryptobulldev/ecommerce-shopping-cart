<?php

namespace Tests\Unit;

use App\Mail\DailySalesReportMail;
use App\Models\Product;
use App\Notifications\LowStockNotification;
use Tests\TestCase;

class MailAndNotificationTest extends TestCase
{
    public function test_daily_sales_report_mail_builds_with_markdown_and_subject(): void
    {
        $summary = collect([
            ['product' => 'Test', 'quantity' => 2, 'revenue' => 1000],
        ]);
        $mail  = new DailySalesReportMail($summary);
        $built = $mail->build();
        $this->assertSame('Daily Sales Report', $built->subject);
        $this->assertEquals('emails.reports.daily', $built->markdown);
    }

    public function test_low_stock_notification_to_mail_contains_expected_lines(): void
    {
        $product      = Product::factory()->make(['name' => 'Widget', 'stock_quantity' => 3]);
        $notification = new LowStockNotification($product);
        $message      = $notification->toMail((object) []);

        $this->assertStringContainsString('Low Stock Alert', $message->subject);
        $this->assertStringContainsString('Product: Widget', collect($message->introLines)->join(' '));
        $this->assertStringContainsString('Current Stock: 3', collect($message->introLines)->join(' '));
    }
}
