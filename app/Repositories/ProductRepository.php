<?php

namespace App\Repositories;

use App\Models\Product;
use App\Interface\ProductInterface;
use App\Interface\ProductModifyInterface;

class ProductRepository implements ProductInterface,ProductModifyInterface {

    /**
     * Interface Segregation Principle with ProductRepository
     * 
     */
    public function createProduct($userData){
        $product =  Product::create($userData);
        return $product;
    }

    public function updateProduct($id,$productData){
        $theproduct = Product::where('id',$id)->first();
        $theproduct->update($productData);
        return $theproduct;
    }

    public function deleteProduct($product){
       return $product->delete();
    }

    public function ProductPaginate(){
        return Product::Paginate(10);
    }
}