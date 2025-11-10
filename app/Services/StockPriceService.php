<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class StockPriceService
{
    protected $client;
    protected $apiKey;
    protected $apiHost;
    protected $baseUrl = 'https://yh-finance.p.rapidapi.com/stock/v2/get-chart';  // Endpoint para cotação

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('RAPIDAPI_KEY');
        $this->apiHost = env('RAPIDAPI_HOST'); 
    }

    public function getCurrentPrice(string $symbol): ?float
    {
        $cacheKey = "stock_price_{$symbol}";

        if (Cache::has($cacheKey)) {
            Log::info("Preço de {$symbol} obtido do cache.");
            return Cache::get($cacheKey);
        }

        try {
            $response = $this->client->get($this->baseUrl, [
                'query' => [
                    'symbol' => $symbol,
                    'interval' => '1m',
                    'range' => '1d',
                ],
                'headers' => [
                    'X-RapidAPI-Key' => $this->apiKey,
                    'X-RapidAPI-Host' => $this->apiHost,
                ],
                'timeout' => 10,
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data['chart']['result'][0]['meta']['regularMarketPrice'])) {
                $price = (float) $data['chart']['result'][0]['meta']['regularMarketPrice'];

                Cache::put($cacheKey, $price, 60);

                Log::info("Preço de {$symbol} obtido da API: {$price}");
                return $price;
            } else {
                Log::error("Dados inválidos da API para {$symbol}: " . json_encode($data));
                return null;
            }
        } catch (RequestException $e) {
            Log::error("Erro na requisição da API para {$symbol}: " . $e->getMessage());
            return null;
        }
    }
}