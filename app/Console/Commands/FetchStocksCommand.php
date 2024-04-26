<?php

namespace App\Console\Commands;

use App\Models\Stock;
use App\Services\ApiService;
use Illuminate\Console\Command;

class FetchStocksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '
                        fetch:stocks
                        {--dateFrom= : The starting date}
                        {--dateTo= : The ending date}
                        {--limit=100 : The limit of records to fetch}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch stocks from api and store in database';

    /**
     * Execute the console command.
     */
    public function handle(ApiService $apiService)
    {
        $dateFrom = $this->option('dateFrom') ? ($this->option('dateFrom') < date('Y-m-d') ? date('Y-m-d') : $this->option('dateFrom')) : date('Y-m-d');
        $dateTo = $this->option('dateTo') ?? date('Y-m-d', strtotime('+1 day'));;
        $limit = $this->option('limit') ?? 100;

        $params = [
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'page' => 1,
            'limit' => $limit
        ];

        $jsonData = $apiService->fetchData('stocks', $params);

        $data = json_decode($jsonData, true);
        ;
        if($data['data']){
            $data=$data['data'];

            foreach ($data as $item) {
                Stock::updateOrCreate(
                    ['barcode' => $item['barcode']],
                    $item
                );
            }
        }

        $this->info('Stocks fetched and stored successfully.');
    }
}
//run  php artisan fetch:stock --dateFrom=2024-04-26 --dateTo=2024-04-30 --limit=50
