<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function (\App\Services\ApiService $apiService) {
    $dateFrom =  '2024-04-26';
    $dateTo = '2024-04-30';
    $limit = 50;

    $params = [
        'dateFrom' => $dateFrom,
        'dateTo' => $dateTo,
        'page' => 1,
        'limit' => $limit
    ];

    $jsonData = $apiService->fetchData('stocks', $params);

    return $jsonData;
});
