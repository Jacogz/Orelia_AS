<?php

namespace Tests\Unit;

use App\Services\ExchangeRateService;
use Tests\TestCase;

class ExchangeRateServiceTest extends TestCase
{
    public function test_empty_rates_structure_is_correct(): void
    {
        $service = new ExchangeRateService;
        $method = new \ReflectionMethod(ExchangeRateService::class, 'getEmptyRates');
        $method->setAccessible(true);

        $result = $method->invoke($service);

        $this->assertArrayHasKey('base', $result);
        $this->assertArrayHasKey('USD', $result);
        $this->assertArrayHasKey('EUR', $result);
        $this->assertArrayHasKey('available', $result);
        $this->assertFalse($result['available']);
    }

    public function test_empty_rates_returns_cop_as_base(): void
    {
        $service = new ExchangeRateService;
        $method = new \ReflectionMethod(ExchangeRateService::class, 'getEmptyRates');
        $method->setAccessible(true);

        $result = $method->invoke($service);

        $this->assertEquals('COP', $result['base']);
    }
}
