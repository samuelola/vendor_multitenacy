<?php

namespace App\Exceptions;

use Exception;

use Throwable;


class ProductException extends Exception
{
    public function report(): void
    {
        // ...
    }

    public function render(Request $request): Response
    {
        //  if($request->is('api/*')){
        //     return true;
        //  }

        //  return $request->expectsJson();

        //  if ($request->is('api/*')) {
        //     return response()->json([
        //         'message' => "Product not found"
        //     ], 404);
        // }

         return response()->json([
                'message' => "Product not found"
            ], 404);
        
    }
}
