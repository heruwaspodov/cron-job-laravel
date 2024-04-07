<?php

namespace App\Console\Commands;

use App\Services\FetchUsersService;
use Illuminate\Console\Command;

/**
 * Command to execute fetch user for cron every hour
 */
class FetchUsersCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-users {--limit=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch users from API and store in database';

    protected FetchUsersService $fetchUserService;

    /**
     * Create a new console command instance.
     *
     * @return void
     */
    public function __construct(FetchUsersService $fetchUserService)
    {
        parent::__construct();
        $this->fetchUserService = $fetchUserService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->fetchUserService->call($this->limit());
    }

    /**
     * @return int
     */
    private function limit(): int
    {
        $limit = $this->option('limit');
        return (int)(empty($limit)) ? 20 : $limit;
    }
}
