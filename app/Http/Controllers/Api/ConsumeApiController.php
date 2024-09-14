<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ApiConsumeRepository;

class ConsumeApiController extends Controller
{
    public function getExternalApi(){
        
        $url = "https://ecommerce.styletisfy.com/api/categories";
        $result = (new ApiConsumeRepository($url))->getApi();
        return $result;
    }
}
