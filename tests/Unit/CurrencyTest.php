<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\CurrencyService;

class CurrencyTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_convert_usd_to_eur()
    {
        $this->assertEquals(98,(new CurrencyService())->convert(100,'usd','eur'));
    }
}
