<?php

namespace App\Console\Commands;

use App\Models\Sale;
use App\Services\ApiService;
use Illuminate\Console\Command;

class FetchSalesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '
                        fetch:sales
                        {--dateFrom= : The starting date}
                        {--dateTo= : The ending date}
                        {--limit=100 : The limit of records to fetch}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch sales from api and store in database';

    /**
     * Execute the console command.
     */
    public function handle(ApiService $apiService)
    {
        $dateFrom = $this->option('dateFrom') ?? date('Y-m-d');
        $dateTo = $this->option('dateTo') ?? date('Y-m-d', strtotime('+1 day'));;
        $limit = $this->option('limit') ?? 100;

        $params = [
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'page' => 1,
            'limit' => $limit
        ];

        $jsonData = $apiService->fetchData('sales', $params);

        $data = json_decode($jsonData, true);

        foreach ($data['data'] as $item) {
            Sale::updateOrCreate(
                ['g_number' => $item['g_number']],
                $item
            );
        }

        $this->info('Sales fetched and stored successfully.');
    }
}
//run php artisan fetch:sales --dateFrom=2024-04-01 --dateTo=2024-04-30 --limit=50
