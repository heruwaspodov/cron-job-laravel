<?php

namespace App\Console\Commands;

use App\Services\DailyCalculateService;
use Illuminate\Console\Command;

/**
 *
 */
class DailyCalculateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:daily-calculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily calculate users data';

    protected DailyCalculateService $dailyCalculateService;

    /**
     * Create a new console command instance.
     *
     * @return void
     */
    public function __construct(DailyCalculateService $dailyCalculateService)
    {
        parent::__construct();
        $this->dailyCalculateService = $dailyCalculateService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->dailyCalculateService->call();
    }
}
