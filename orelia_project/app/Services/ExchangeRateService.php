<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ExchangeRateService
{
    private string $apiKey;

    private string $baseCurrency;

    public function __construct()
    {
        $this->apiKey = config('services.exchangerate.key');
        $this->baseCurrency = config('services.exchangerate.base_currency');
    }

    public function getRates(): array
    {
        return Cache::remember('exchangerate_rates', 3600, function () {
            $response = Http::timeout(5)->get(
                "https://v6.exchangerate-api.com/v6/{$this->apiKey}/latest/{$this->baseCurrency}"
            );

            if ($response->failed()) {
                return $this->getEmptyRates();
            }

            $data = $response->json();

            if ($data['result'] !== 'success') {
                return $this->getEmptyRates();
            }

            return [
                'base' => $data['base_code'],
                'USD' => $data['conversion_rates']['USD'] ?? null,
                'EUR' => $data['conversion_rates']['EUR'] ?? null,
                'available' => true,
            ];
        });
    }

    private function getEmptyRates(): array
    {
        return [
            'base' => $this->baseCurrency,
            'USD' => null,
            'EUR' => null,
            'available' => false,
        ];
    }
}
