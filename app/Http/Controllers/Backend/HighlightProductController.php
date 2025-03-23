<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\HighLightProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class HighlightProductController extends Controller
{
    public function index(){
        $gsd = global_user_data();
        $products = HighLightProduct::orderBy("id")->with('product')->get();
        return view("Admin.hightlight-product.index",compact('products','gsd'));
    }

    public function create(){
        $gsd = global_user_data();
        $products = Product::latest('id')->get();
        return view("Admin.hightlight-product.create",compact('products','gsd'));
    }

    
    public function store(Request $request){
   

     $product = new HighLightProduct();
     $product->product_id = $request->product_id;
     $product->save();
    return back();
    }

    public function remove(Request $request){
     
    $product = HighLightProduct::where("id",$request->id)->first();
    $product->delete();
    return back();
    }


}
