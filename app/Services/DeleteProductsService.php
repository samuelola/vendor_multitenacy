<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DeleteProductsService{

    public function __invoke(){
        return DB::table('products')->delete();
    }
}