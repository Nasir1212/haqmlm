<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Package;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use App\Models\Dealer;
use App\Models\DealerSelection;
use App\Models\ProductOwner;

class ProductDetailController extends Controller
{
    public function singleProduct(Request $request){
        $gsd = global_user_data();
        $c_products = cart_counter();
        $wsp_products = wishlist_counter();
        if(Auth::check()){
            $selected_dealer = DealerSelection::where('user_id', $gsd->id)->first();
            $dealerId = $selected_dealer->dealer_id;
        }else{
            $dealerId = 1;
        }
        
       $product = Product::where('slug',$request->slug)->select('products.*', 'product_owners.qty as owner_qty')
    ->join('product_owners', 'products.id', '=', 'product_owners.product_id')
    ->where('product_owners.dealer_id', $dealerId)
    ->first();
    
    if(!$product){
        notify()->error("Your information was not found");
        return back();
    }
    
    
     
if($product){
    if($product->category_id != ''){
     $related_products = Product::where('category_id', $product->category_id)->get();
}else{
    $related_products = '';
}
}else{
    $related_products = '';
}

       


        return view('Frontend.product.details', compact('related_products','product','gsd','c_products','wsp_products'));

    }
 public function Brand_product(Request $request){
      
        $selected_dealer = '';
        $gsd = '';
            $Brand = ProductBrand::where('slug',$request->slug)->first();
        if (Auth::check()) {
           $gsd = global_user_data();
           
           $selected_dealer = DealerSelection::where('user_id', $gsd->id)->first();
           if(!$selected_dealer){
               $selected_dealer = new DealerSelection();
               $selected_dealer->user_id = $gsd->id;
               $selected_dealer->dealer_id = 1;
               $selected_dealer->save();
           }
        }
        
        if (Auth::check()) {
        if (!$selected_dealer) {
      
            // Fetch products with eager loading for related models
            $products = Product::where('brand_id',$Brand->id)->where('status', 1)
                            ->latest('id')
                            ->paginate(24);
        } else{
                // Fetch product IDs for the selected dealer with available quantity
                $productIds = ProductOwner::where('dealer_id', $selected_dealer->dealer_id)
                               
                                ->pluck('product_id');
    
                // Fetch products with eager loading for related models
                $products = Product::where('brand_id',$Brand->id)->whereIn('id', $productIds)
                                ->where('status', 1)
                                ->latest('id')
                                ->paginate(24);
    
        } 
            
        } else{
            
        $products = Product::where('brand_id',$Brand->id)->where('status', 1)
        ->latest('id')
        ->paginate(24);
    }          
        
        
        
        
        $c_products = cart_counter();
        $wsp_products = wishlist_counter();
    
        

        return view('Frontend.product.brand-product', compact('products','Brand','gsd','c_products','wsp_products'));

    }

 public function Category_product(Request $request){
        $selected_dealer = '';
        $gsd = '';
        $Category = ProductCategory::where('slug',$request->slug)->first();
        if (Auth::check()) {
           $gsd = global_user_data();
           $selected_dealer = DealerSelection::where('user_id', $gsd->id)->first();
           if(!$selected_dealer){
               $selected_dealer = new DealerSelection();
               $selected_dealer->user_id = $gsd->id;
               $selected_dealer->dealer_id = 1;
               $selected_dealer->save();
           }
        }
        
        if (Auth::check()) {
        if (!$selected_dealer) {
      
            // Fetch products with eager loading for related models
            $products = Product::where('category_id',$Category->id)->where('status', 1)
                            ->latest('id')
                            ->paginate(24);
        } else{
                // Fetch product IDs for the selected dealer with available quantity
                $productIds = ProductOwner::where('dealer_id', $selected_dealer->dealer_id)
                               
                                ->pluck('product_id');
    
                // Fetch products with eager loading for related models
                $products = Product::where('category_id',$Category->id)->whereIn('id', $productIds)
                                ->where('status', 1)
                                ->latest('id')
                                ->paginate(24);
    
        } 
             
        } else{
        $products = Product::where('category_id',$Category->id)->where('status', 1)
        ->latest('id')
        ->paginate(24);
    }          
        
        $c_products = cart_counter();
        $wsp_products = wishlist_counter();
       
        
        return view('Frontend.product.category-product', compact('products','Category','gsd','c_products','wsp_products'));

    }





    public function singlePackage(Request $request){
        $gsd = global_user_data();
        $package = Package::where('slug',$request->slug)->first();
        $products_id = json_decode($package->product_ids);
        $products = Product::whereIn('id',$products_id)->get();

        
        return view('Frontend.package.details', compact('products','package','gsd'));
    }
}
