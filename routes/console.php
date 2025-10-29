<?php

use App\Jobs\DailySalesReportJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule the daily report at 23:59
// Schedule::job(new DailySalesReportJob)->dailyAt('23:59');
Schedule::job(new DailySalesReportJob)->everyMinute();
