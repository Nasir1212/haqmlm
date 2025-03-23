<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ProductBrand;
use Illuminate\Support\Str;
class ProductBrandController extends Controller
{
    public function Index(){
        $gsd = global_user_data();
        $ProductBrands =  ProductBrand::latest('id')->get();
        return view('Admin.brand.index',compact('ProductBrands','gsd'));
    }

    public function Create(){
        $gsd = global_user_data();
        return view('Admin.brand.create',compact('gsd'));
    }

    public function Store(Request $request){
        if($request->brand_name == ''){

            notify()->error('Required Brand Name');
            return back();
        } 

        $ProductBrand = new ProductBrand();
        $ProductBrand->name = $request->brand_name;
  
        if ($request->brand_slug == '') {
            $ProductBrand->slug = Str::slug($request->brand_name); 
        }else{
            $ProductBrand->slug = $request->brand_slug;
        }

        $ProductBrand->img_name = ($request->img != '') ? $request->img:'storage/uploads/users/sq.png';
        $ProductBrand->save();
        notify()->success('Creating Success');
        return redirect()->route('product_brand_list');
    }

    public function Edit(Request $request){
        $gsd = global_user_data();
        $ProductBrand = ProductBrand::where('id', $request->id)->first();
        return view('Admin.brand.edit',compact('ProductBrand','gsd'));
    }
    public function Update(Request $request){
        if($request->brand_name == ''){

            notify()->error('Required Brand Name');
            return back();
        } 

        $ProductBrand = ProductBrand::where('id', $request->id)->first();
        $ProductBrand->name = $request->brand_name;

        if ($request->brand_slug == '') {
            $ProductBrand->slug = Str::slug($request->brand_name); 
        }else{
            $ProductBrand->slug = $request->brand_slug;
        }

        $ProductBrand->img_name = $request->img;
        $ProductBrand->save();
        notify()->success('Update Success');
        return back();
    }
    public function Remove(Request $request){
        ProductBrand::destroy($request->id);
        notify()->success('Remove Success');
        return back();
    }
}
