<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function allproducts(){

       
       $allproducts =   Cache::remember('products',60*60*24,function(){
            return Product::Paginate(10);
        });

        // $allproducts = Product::Paginate(10);
        
        return view('products',compact('allproducts'));
    }

    public function create(){

        if(Gate::denies('product_create')){
            return abort(403,'forbidden for this action');
        };

        return view('createproduct');
    }

    public function store(Request $request){
         $request->validate([
           'name'=> 'required',
           'price' => 'required'
        ]);
        Product::create([
            'name' => $request->name,
            'price' => $request->price
        ]);

       return redirect()->route('product');
    }

    public function edit($id){
        $theproduct = Product::where('id',$id)->first();
        return view('editproduct',['theproduct'=>$theproduct]);

    }

    public function update(Request $request, $id){

        $request->validate([
           'name'=> 'required',
           'price' => 'required'
        ]);
        $theproduct = Product::where('id',$id)->first();
        $theproduct->update([
            'name' => $request->name,
            'price' => $request->price
        ]);

        return redirect()->route('product');

    }

    public function delete(Product $product){

        $product->delete();
        return redirect()->route('product');
    }
}
