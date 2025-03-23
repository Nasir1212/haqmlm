<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    public function Index(){
        $gsd = global_user_data();
        if (Auth::id() == 1 || permission_checker($gsd->role_info,'package_manage') == 1){
        $packages =  Package::latest('id')->get();
        return view('Admin.package.index',compact('packages','gsd'));
        }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    }

    public function Create(){
        $gsd = global_user_data();
        if (Auth::id() == 1 || permission_checker($gsd->role_info,'package_manage') == 1){
        $products = Product::with('brand')->latest('id')->get();
        return view('Admin.package.create',compact('products','gsd'));
        }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    }

    public function Store(Request $request){
if (Auth::id() == 1 || permission_checker($gsd->role_info,'package_manage') == 1){
        $package = new Package();
        $package->name = $request->package_name;
        $package->slug = $request->package_slug;
        if($request->package_slug == ''){
            $package->slug = $request->package_name;
        }else{
             $package->slug = $request->package_slug;
        }
        $package->point = $request->package_point;
        $package->shipping_cost_out_dhaka = $request->package_spco;
        $package->shipping_cost_in_dhaka = $request->package_spcd;
        $package->status = $request->package_status;
        $package->main_price = $request->package_sell_price;
        $package->regular_price = $request->package_regular_price;
        $package->details = $request->package_details;
        $package->img_name = $request->img;
        if(isset($request->product_code)){
            $package->product_ids = json_encode($request->product_code);
        }else{
            $package->product_ids = json_encode([]);
        }
       
        $package->save();
        notify()->success('Creating Success');
        return redirect()->route('package_list');
}else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    }

    public function Edit(Request $request){
        $gsd = global_user_data();
        if (Auth::id() == 1 || permission_checker($gsd->role_info,'package_manage') == 1){
        $package = Package::where('id', $request->id)->first();
        $package_product_ids = json_decode($package->product_ids);
        $products = Product::with('brand')->latest('id')->get();
        return view('Admin.package.edit',compact('products','package','package_product_ids','gsd'));
        }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    }
    public function Update(Request $request){
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'package_manage') == 1){
        $package = Package::where('id', $request->id)->first();
        $package->name = $request->package_name;
          if($request->package_slug == ''){
            $package->slug = $request->package_name;
        }else{
             $package->slug = $request->package_slug;
        }
        $package->point = $request->package_point;
        $package->shipping_cost_out_dhaka = $request->package_spco;
        $package->shipping_cost_in_dhaka = $request->package_spcd;
        $package->status = $request->package_status;
        $package->main_price = $request->package_sell_price;
        $package->regular_price = $request->package_regular_price;
        $package->details = $request->package_details;
        $package->img_name = $request->img;
        if(isset($request->product_code)){
            $package->product_ids = json_encode($request->product_code);
        }else{
            $package->product_ids = json_encode([]);
        }
        $package->save();
        notify()->success('Update Success');
        return back();
         }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    }
    public function Remove(Request $request){
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'package_manage') == 1){
        Package::destroy($request->id);
        notify()->success('Remove Success');
        return back();
    }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    }
}
