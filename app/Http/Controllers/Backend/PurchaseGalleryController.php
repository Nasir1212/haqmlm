<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Package;

class PurchaseGalleryController extends Controller
{
    public function index(Request $request){
        $gsd = global_user_data();
        if($request->type == 'package'){
            $packages = Package::latest('id')->get();
            return view('Admin.purchase.package.index', compact('packages','gsd'));
        }elseif($request->type == 'product'){
            $products = Product::latest('id')->get();
            return view('Admin.purchase.product.index', compact('products','gsd'));
        }



        
    }
}
