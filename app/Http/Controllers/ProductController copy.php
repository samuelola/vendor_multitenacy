<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Laravel\Facades\Image;
use App\Http\Requests\ProductRequest;

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

    public function store(ProductRequest $request){
        
        $product_data = $request->validated();
        if($request->hasFile('image')){
            // without package
            // $path = time().'.'.$request->image->extension();
            // $request->image->move(public_path('images'),$path);

            // using image intervention method
            $image=$request->file('image');
            $path = time().'.'.$request->image->extension();
            $location=public_path('images/'.$path);
            Image::read($image)->resize(800, 900)->save($location);

             // using image intervention method and aws
            // $image=$request->file('image');
            // $path = time().'.'.$request->image->extension();
            // $location=public_path('images/'.$path);
            // $img_upload = Image::read($image)->resize(800, 900)->save($location);
            //option one
            // Storage::disk('s3')->put('images/'.$path, $image->stream(), 'public');
            //option two
            //Storage::disk('s3')->put($path, $img->stream()->__toString());

            //this is used to get the path where the file is stored
            // $awsPath = Storage::disk('s3')->url($path);

        }
        Product::create([
            'name' => $product_data['name'],
            'price' => $product_data['price'],
            'product_image' => 'images/'.$path,

            // 'product_image' =>$awsPath
            
        ]);

        return redirect()->route('product');

        /**
         * Using Dependency Inversion Principle
         * 
         */
         
         
       
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
