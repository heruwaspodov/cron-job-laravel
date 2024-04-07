<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('~ WSPDV TAMPAN ~')->everyMinute();

Schedule::command('app:fetch-users --limit=20')->hourly();
Schedule::command('app:daily-calculate')->dailyAt('23:59:59');
