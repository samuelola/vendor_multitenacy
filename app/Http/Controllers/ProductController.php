<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use App\Services\ProductService;
use App\Http\Requests\ProductRequest;
use App\Repositories\ProductRepository;
use App\Http\Requests\StoreProductRequest;


class ProductController extends Controller
{

    public function allproducts(ProductRepository $productRepository){
       $allproducts =   Cache::remember('products',60*60*24,function() use($productRepository){
            return $productRepository->ProductPaginate();
        });

        // $allproducts = Product::Paginate(10);
        return view('products',compact('allproducts'));
        
        Product::chunk(100,function($products){
            /** do somthing with the collection result */
        });
    }

    public function create(){
        if(Gate::denies('product_create')){
            return abort(403,'forbidden for this action');
        };

        return view('createproduct');
    }

    public function store(ProductRequest $request){
        /**
         * Single Responsibilty Principle for ProductService without a contructor
         */
        //(new ProductService())->StoreWebProduct($request->validated(),$request);

        /**
         * Using Single Responsibilty Principle for ProductService with a constructor in product servic
         */
        (new ProductService($request->validated(),$request))->StoreWebProduct();
        return redirect()->route('product');
    }

    public function edit($id){
        $theproduct = Product::where('id',$id)->first();
        return view('editproduct',['theproduct'=>$theproduct]);
    }

    public function update(StoreProductRequest $request, $id){
        /**
         * Single Responsibilty Principle
         */
        (new ProductRepository())->updateProduct($id,$request->validated());
        return redirect()->route('product');
    }

    public function delete(Product $product, ProductRepository $productRepository){
        $productRepository->deleteProduct($product);
        return redirect()->route('product');
    }
}
