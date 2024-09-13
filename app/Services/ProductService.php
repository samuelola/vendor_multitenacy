<?php

namespace App\Services;

use App\Services\LocalFileStorage;
use App\Repositories\ProductRepository;
use App\Models\Product;

class ProductService{
    
    private $data;
    private $therequest;

    public function __construct($data,$therequest){
       
        $this->data = $data;
        $this->therequest = $therequest;
    }

    public function StoreWebProduct(){
       
        if($this->therequest->hasFile('image')){
        /**
         * Dependency Inversion Principle with LocalFileStorage
         * 
         */
          $image = $this->therequest->file('image');
          $path = time().'.'.$this->therequest->image->extension();
          $store_path = (new LocalFileStorage())->localFileStoreFile('images/',$image,$path);
        }
        $this->data['product_image'] = $store_path;
        (new ProductRepository())->createProduct($this->data);
    }

    /**
     * Without a constuctor
     * 
     */

    // public function StoreWebProduct($productData,$request){
       
    //     if($request->hasFile('image')){
    //     /**
    //      * Dependency Inversion Principle with LocalFileStorage
    //      * 
    //      */
    //       $image = $request->file('image');
    //       $path = time().'.'.$request->image->extension();
    //       $store_path = (new LocalFileStorage())->localFileStoreFile('images/',$image,$path);
    //     }
    //     $productData['product_image'] = $store_path;
    //     (new ProductRepository())->createProduct($productData);
    // }

     
}