<?php

namespace App\Console\Commands;

use App\Services\ApiService;
use Illuminate\Console\Command;

class MasterCommand extends Command
{
//php artisan fetch:all --dateFrom=2024-04-25 --dateTo=2024-04-26 --limit=50
    protected $signature = 'fetch:all {--dateFrom= : The starting date} {--dateTo= : The ending date} {--limit=100 : The limit of records to fetch}';
    protected $description = 'Fetch data from all endpoints and store in database';

    public function handle()
    {
        $dateFrom = $this->option('dateFrom') ?? date('Y-m-d');
        $dateTo = $this->option('dateTo') ?? date('Y-m-d', strtotime('+1 day'));
        $limit = $this->option('limit') ?? 100;

        $this->call('orders:fetch', [
            '--dateFrom' => $dateFrom,
            '--dateTo' => $dateTo,
            '--limit' => $limit,
        ]);

        $this->call('stocks:fetch', [
            '--dateFrom' => $dateFrom,
            '--dateTo' => $dateTo,
            '--limit' => $limit,
        ]);

        $this->call('incomes:fetch', [
            '--dateFrom' => $dateFrom,
            '--dateTo' => $dateTo,
            '--limit' => $limit,
        ]);

        $this->call('sales:fetch', [
            '--dateFrom' => $dateFrom,
            '--dateTo' => $dateTo,
            '--limit' => $limit,
        ]);

        $this->info('Data fetched and stored successfully.');
    }
}
