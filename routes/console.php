<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;
use App\Services\DeleteProductsService;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Schedule::call(function (){
//     DB::table('products')->delete();
// })->everySecond();

// Schedule::call(new DeleteProductsService)->everyTwoMinutes();

Schedule::command('delete-products')->everyTwoMinutes();