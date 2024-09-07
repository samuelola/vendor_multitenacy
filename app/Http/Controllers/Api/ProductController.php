<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Exceptions\ProductException;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Cache;



class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //using cache in api controller
        return ProductResource::collection(Cache::remember('products',60*60*24,function(){
           return Product::all();
        }));
       

        //return ProductResource::collection(Product::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
           'name'=> 'required',
           'price' => 'required'
        ]);
         Product::create($validated);
         return response()->json('Product Created Successfully',200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $find_product = Product::where('id',$id)->orderByDesc('created_at')->first();
        if (is_null($find_product)) {
            return response()->json('Product not found.');
        }
        return $find_product;


        // try{
        //    $find_product = Product::where('id',$id)->orderByDesc('created_at')->first();
        //     if (is_null($find_product)) {
        //         return response()->json('Product not found.');
        //     }
        //     return $find_product;

        // }catch(\Throwable $e){

        //      return response()->json(['error'=> 'Product not found'],404);
        // }
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
           'name'=> 'required',
           'price' => 'required'

        ]);
        $find_product = Product::where('id',$id)->orderByDesc('created_at')->first();
        if (is_null($find_product)) {
            return response()->json('Product not found.');
        }else{
            $find_product->update($validated);
            // return $find_product;
             return response()->json('Product updated Successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
          $product->delete();
          return response()->json('Product Deleted Succesfully.');
    }
}
