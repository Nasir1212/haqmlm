<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function Index(){
        $gsd = global_user_data();
        $productCategories =  ProductCategory::latest('id')->get();
        return view('Admin.category.index',compact('productCategories','gsd'));
    }

    public function Create(){
        $gsd = global_user_data();
        return view('Admin.category.create',compact('gsd'));
    }

    public function Store(Request $request){
        if($request->category_name == ''){

            notify()->error('Required Category Name');
            return back();
        } 

        $ProductCategory = new ProductCategory();
        $ProductCategory->name = $request->category_name;
       
        if ($request->category_slug == '') {
            $ProductCategory->slug = Str::slug($request->category_name); 
        }else{
            $ProductCategory->slug = $request->category_slug;
        }
        


        $ProductCategory->img_name = $request->img;
        $ProductCategory->save();
        notify()->success('Creating Success');
        return redirect()->route('product_category_list');
    }

    public function Edit(Request $request){
        $gsd = global_user_data();
        $ProductCategory = ProductCategory::where('id', $request->id)->first();
        return view('Admin.category.edit',compact('ProductCategory','gsd'));
    }
    public function Update(Request $request){

        if($request->category_name == ''){
            notify()->error('Required Category Name');
            return back();
        } 
        $ProductCategory = ProductCategory::where('id', $request->id)->first();
        $ProductCategory->name = $request->category_name;
        if ($request->category_slug == '') {
            $ProductCategory->slug = Str::slug($request->category_name); 
        }else{
            $ProductCategory->slug = $request->category_slug;
        }
        $ProductCategory->img_name = ($request->img != '') ? $request->img:'storage/uploads/users/sq.png';
        $ProductCategory->save();
        notify()->success('Update Success');
        return redirect()->route('product_category_list');
    }
    public function Remove(Request $request){
        ProductCategory::destroy($request->id);
        notify()->success('Remove Success');
        return back();
    }
}
