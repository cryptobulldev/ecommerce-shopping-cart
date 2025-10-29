<?php

namespace App\Jobs;

use App\Mail\DailySalesReportMail;
use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;

class DailySalesReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $today = now()->startOfDay();
        /** @var Collection<int, \App\Models\OrderItem> $sales */
        $sales = OrderItem::whereDate('created_at', $today)->with('product')->get();

        /** @var Collection<int, array{product:string,quantity:int,revenue:float|int}> $summary */
        $summary = $sales->groupBy('product_id')->map(function ($items): array {
            /** @var Collection<int, \App\Models\OrderItem> $items */
            return [
                'product'  => $items->first()->product->name,
                'quantity' => $items->sum('quantity'),
                'revenue'  => $items->sum(fn ($i) => $i->price * $i->quantity),
            ];
        });

        Mail::to(config('mail.admin_email'))->send(new DailySalesReportMail($summary));
    }
}
