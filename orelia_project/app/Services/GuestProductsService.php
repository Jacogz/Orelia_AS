<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GuestProductsService
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.guest_products.base_url');
    }

    public function getProducts(): array
    {
        return Cache::remember('guest_products', 3600, function () {
            $response = Http::timeout(5)->get("{$this->baseUrl}/api/products/in-stock");

            if ($response->failed()) {
                return $this->getEmptyProducts();
            }

            $data = $response->json();

            if (($data['status'] ?? null) !== 'success') {
                return $this->getEmptyProducts();
            }

            return [
                'total' => $data['total'] ?? 0,
                'products' => $data['data'] ?? [],
                'available' => true,
            ];
        });
    }

    private function getEmptyProducts(): array
    {
        return [
            'total' => 0,
            'products' => [],
            'available' => false,
        ];
    }
}
