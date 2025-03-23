<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\ProductOwner;
use App\Models\ProductTrasnsferRecord;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    
    
    public function query(Request $request){
    $query = Product::query();

    if($request->filled('brand')){
        $query->where('brand_id', $request->brand);
    }

    if($request->filled('category')){
        $query->where('category_id', $request->category);
    }

    $products = $query->latest('id')->get();

    return response()->json($products);
}


public function query_with_owner(Request $request)
{

    // Retrieve product IDs for the given dealer
    $productIds = ProductOwner::where('dealer_id', $request->dealer)->pluck('product_id');
    $dealer = $request->dealer;
    // Early return if no products found
    if ($productIds->isEmpty()) {
        return response()->json([]);
    }

    // Build the query
    $query = Product::whereIn('id', $productIds)
                    ->select('id', 'name', 'brand_id', 'category_id',"main_price") // Adjust the columns as needed
                    ->latest('id')
                    ->with(['ownerSelf' => function($query) use ($dealer) {
                        // Apply user_id filter if provided
                        if (isset($dealer)) {
                            $query->where('dealer_id', $dealer);
                        }
                    }]);
    // Apply optional filters
    if ($request->filled('brand')) {
        $query->where('brand_id', $request->brand);
    }

    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }

    // Execute the query and get the results
    $products = $query->get();

    return response()->json($products);
}


    
    public function product_name_get(Request $request){
          $products = Product::where('name', 'LIKE', "%$request->product_name%")->orWhere('b_name', 'LIKE', "%$request->product_name%")->get();
       $tb = '';
        if($products){
            $tb = '<ul id="products">';
    
            foreach ($products as $key => $product) {
                $tb .= '<li class="product" data-product_name="'.$product->name.'">'.$product->name.'</li>';
            }
            $tb .= '</ul>';
        }else{
            $tb = '';
        }
    
        return response()->json($tb);
    }
    
    
    public function Index(Request $request){
        $gsd = global_user_data();
          if (Auth::id() == 1 || permission_checker($gsd->role_info,'product_manage') == 1){
              
              if(isset($request->product_name)){
                 $products = Product::with(['brand','category'])->where('name',$request->product_name)->paginate(10);
                 
              }else{
                  $products = Product::with(['brand','category'])->latest('id')->paginate(10);
              }
              
              
              
              return view('Admin.product.index',compact('products','gsd'));
          }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    }

    public function Create(){
        $gsd = global_user_data();
          if (Auth::id() == 1 || permission_checker($gsd->role_info,'product_manage') == 1){
        $brands =  ProductBrand::latest('id')->get();
        $productCategories =  ProductCategory::latest('id')->get();
        return view('Admin.product.create',compact('productCategories','brands','gsd'));
          }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    }

    public function Store(Request $request){
        $gsd = global_user_data();
          if (Auth::id() == 1 || permission_checker($gsd->role_info,'product_manage') == 1){
        $product = new Product();

        if($request->product_name == ''){

            notify()->error('Required Product Name');
            return back();
        } 

        if($request->product_brand_id == ''){

            notify()->error('Please Select Product Brand then Try Again');
            return back();
        } 
        if($request->product_category_id == ''){

            notify()->error('Please Select Product Category then Try Again');
            return back();
        }

        $product->name = $request->product_name;
        if($request->product_slug == ''){
            $product->slug = Str::slug($request->product_name);
        }else{
             $product->slug = $request->product_slug;
        }
        
        $product->main_price = $request->product_sell_price;
        $product->regular_price = $request->product_reg_price;
        $product->point = $request->product_point;
        $product->status = $request->product_status;
        $product->b_name = $request->product_b_name;
        $product->brand_id = $request->product_brand_id;
        $product->category_id = $request->product_category_id;
        $product->details = $request->product_details;
        $product->img_name = ($request->img != '') ? $request->img:'storage/uploads/users/sq.png';
        $product->save();
        notify()->success('Creating Success');
        return redirect()->route('product_list');
          }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    }

    public function Edit(Request $request){
        $gsd = global_user_data();
          if (Auth::id() == 1 || permission_checker($gsd->role_info,'product_manage') == 1){
        $product = Product::with(['brand','category'])->where('id', $request->id)->first();
        $brands =  ProductBrand::latest('id')->get();
        $productCategories =  ProductCategory::latest('id')->get();
        return view('Admin.product.edit',compact('product','productCategories','brands','gsd'));
          }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    }
    public function Update(Request $request){
        $gsd = global_user_data();
          if (Auth::id() == 1 || permission_checker($gsd->role_info,'product_manage') == 1){
        $product = Product::where('id', $request->id)->first();

        if($request->product_name == ''){

            notify()->error('Required Product Name');
            return back();
        } 



        if($request->product_brand_id == ''){

            notify()->error('Please Select Product Brand then Try Again');
            return back();
        } 
        if($request->product_category_id == ''){

            notify()->error('Please Select Product Category then Try Again');
            return back();
        }


        $product->name = $request->product_name;
       if($request->product_slug == ''){
            $product->slug =  Str::slug($request->product_name);
        }else{
             $product->slug = $request->product_slug;
        }
        $product->main_price = $request->product_sell_price;
        $product->regular_price = $request->product_reg_price;
        $product->b_name = $request->product_b_name;
        $product->point = $request->product_point;
        $product->status = $request->product_status;
        $product->brand_id = $request->product_brand_id;
        $product->category_id = $request->product_category_id;
        $product->details = $request->product_details;
        $product->img_name = ($request->img != '') ? $request->img:'storage/uploads/users/sq.png';
        $product->save();
        notify()->success('Update Success');
        return back();
          }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    }
    public function Remove(Request $request){
            $gsd = global_user_data();
          if (Auth::id() == 1 || permission_checker($gsd->role_info,'product_manage') == 1){
        Product::destroy($request->id);
        notify()->success('Remove Success');
        return back();
          }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    }
}
