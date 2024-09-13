<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Exceptions\ProductException;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreProductRequest;
use App\Repositories\ProductRepository;
use App\Service\PaymentFactory;



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
    public function store(StoreProductRequest $request, ProductRepository $productRepository)
    {
        /**
         * Volate Single responsibility principle but it is working
         */
        
        //  $product_data = $request->validated();
        //  Product::create($product_data);
        /**
         * Single responsibility principle
         */
        $productRepository->createProduct($request->validated());
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

    
    //demostrating open and closed principle (no modification to previous code just add new one) part 1 
    public function pay(Request $request){

        /**
         * demostrating open and closed principle part 1 
         * which will not work this way bcos code may break 
         */
        // $payment = new PaymentService();
        // if($type === 'credit'){
        //    $payment->payWithCreditCard();
        // }elseif($type === 'paypal'){
        //     $payment->payWithPaypal();
        // }else{
        //     $payment->payWithWireTransfer();
        // }

        /**
         * demostrating open and closed principle part 1 
         */
        $paymentFactory = new PaymentFactory();
        $payment = $paymentFactory->initializePayment($request->type);
        $payment->paywith();
        
    }
}
