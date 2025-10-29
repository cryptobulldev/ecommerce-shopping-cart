<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class DailySalesReportMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @param Collection<int, array{product:string,quantity:int,revenue:int|float}> $summary
     */
    public function __construct(public Collection $summary) {}

    public function build(): self
    {
        return $this->subject('Daily Sales Report')
            ->markdown('emails.reports.daily', [
                'summary' => $this->summary,
            ]);
    }
}
