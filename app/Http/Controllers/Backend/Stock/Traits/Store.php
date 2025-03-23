<?php
namespace App\Http\Controllers\Backend\Stock\Traits;

use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductOwner;
use App\Models\ProductSupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

trait Store
{
    public function StockStore(Request $request){
        
        if($request->stock_type == "OUT"){
             $product = Product::where('id',$request->product)->first();
            if($product){
            $product->stock -= $request->product_qty;
 
            $product->save(); 
            $owner = ProductOwner::where('product_id',$request->product)->where('dealer_id', 1)->first();
            
            if($owner){
               $owner->qty -= $request->product_qty;
               $owner->save();
            }
            
            notify()->success('Product Stock out  SuccessFull');
            return redirect()->route('product_stock_histories');
        }
        
               notify()->error('Product not found!');
                return back();
            
        }
       
            $product = Product::where('id',$request->product)->first();
            if($product){
            $product->stock += $request->product_qty;
 
            $product->save(); 
            $owner = ProductOwner::where('product_id',$request->product)->where('dealer_id', 1)->first();
            
            if($owner){
               $owner->qty += $request->product_qty;
               $owner->save();
                }
            else{
                $owner = new ProductOwner();
                $owner->dealer_id = 1;
                $owner->product_id = $request->product;
                $owner->qty = $request->product_qty;
                $owner->save();
                }
        
                $product_stock = new ProductStock();
                $product_stock->owner_id = 1;
                $product_stock->supplier = $request->supplier;
                $product_stock->sell_price = $request->product_sell_price;
                $product_stock->purchase_price = $request->product_purchase_price;
                $product_stock->stock_type = $request->stock_type;
                $product_stock->product_id = $request->product;
                $product_stock->qty = $request->product_qty;
                $product_stock->created_by = Auth::id();
                $product_stock->save();
                notify()->success('Product Stock in Successfull');
                
                Cache::forget('Product_stock_history');
                return redirect()->route('product_stock_histories');
            }else{
                notify()->error('Product not found!');
                return back();
            }
        
       
    }
}