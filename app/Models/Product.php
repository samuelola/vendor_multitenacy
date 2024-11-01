<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\CurrencyService;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name','price','product_image'];

    /**
     * Observing or using Single segeration principle
     */
    public function getPriceEurAttribute(){

         return ( new CurrencyService())->convert($this->price,'usd','eur');
    }

    protected $date = ['created_at'];
}
