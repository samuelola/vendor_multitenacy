<?php 

namespace App\Services;

class CurrencyService{

    const RATES = [

        'usd' => [
            'eur' => 0.98
        ]

    ];

    public function convert($amount,$currencyFrom,$currencyTo){
         
         $rate = self::RATES[$currencyFrom][$currencyTo] ?? 0;

         return round($amount * $rate,2);
    }
}