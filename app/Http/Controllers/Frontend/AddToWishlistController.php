<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WishList;
use App\Models\Product;

class AddToWishlistController extends Controller
{

public function getWishlist(){
    $gsd = global_user_data();
    $c_products = cart_counter();
 
    $wish_list = WishList::where('user_id', $gsd->id)->with('product')->get();
    $wsp_products = count($wish_list);
    return view('Frontend.product.wishlist',compact('wish_list','gsd','wsp_products','c_products'));
}

    public function AddWishlist(Request $request){
        $gsd = global_user_data();
        $pexist =  WishList::where('product_id', $request->id)->exists();
        
        if(!$pexist){
        $wishlist = new WishList();
        $product = Product::where('id', $request->id)->exists();
        if($product){
            $wishlist->product_id = $request->id;
            $wishlist->user_id = $gsd->id;
            $wishlist->save();
        }
        $wsp_products = wishlist_counter();
        return response()->json(['success',$wsp_products]);
    }else{
        return response()->json(['Alrady Exists']);
    }


    }
    public function RemoveWishlist(Request $request){
        WishList::destroy($request->pid);
        $wsp_products = wishlist_counter();
        return response()->json(['succees',$wsp_products]);
    }

}
