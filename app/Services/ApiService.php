<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;

class ApiService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.wb_api.protocol') . '://' .
            config('services.wb_api.host') . ':' .
            config('services.wb_api.port') . '/api/';
    }

    public function fetchData($endpoint, $params)
    {
        $params['key'] = config('services.wb_api.key');

        $response = Http::get($this->baseUrl . $endpoint, $params);
        return $response;
    }
}
