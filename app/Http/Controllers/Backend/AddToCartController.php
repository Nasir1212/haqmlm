<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PointSaleHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductOwner;
use App\Models\ShippingAddress;
use App\Models\BillingAddress;
use Illuminate\Support\Str;
use App\Models\DealerSelection;

class AddToCartController extends Controller
{
    public function getCart()
    {
        $c_products = cart_counter();
        $gsd = global_user_data();
        $cart_products = Cart::where('user_id', $gsd->id)
            ->with('product')
            ->get();
        $c_products = count($cart_products); 
        $wsp_products = wishlist_counter();
        
     //   dd($wsp_products);
        
        
        return view('Frontend.product.cart', compact('cart_products', 'gsd','c_products','wsp_products'));
    }

    public function AddCart(Request $request)
    {
        $gsd = global_user_data();
         $selected_dealer = DealerSelection::where('user_id', $gsd->id)->first();
         
         
           if (!$selected_dealer) {
            $c_products = cart_counter();
            return response()->json(['error',$c_products,'Dealer Not Select']);
        }else{

            $productIds = ProductOwner::where('dealer_id', $selected_dealer->dealer_id)
            ->where('qty', '>', 0)
            ->pluck('product_id')->toArray();
            if(!in_array($request->id, $productIds)){
                $c_products = cart_counter();
                return response()->json(['error',$c_products,'product not found']);
            }
        }
         
       $pexist = Cart::where('product_id', $request->id)->where('user_id',$gsd->id)->exists();

        if (!$pexist) {
            $cart = new Cart();
            $product = Product::where('id', $request->id)->first();
            $cart->product_id = $request->id;
            $cart->user_id = $gsd->id;
              $cart->dealer_id = $selected_dealer->dealer_id;
            $cart->qty = $request->qty;
            $cart->price = $request->qty * $product->main_price;
            $cart->point = $request->qty * $product->point;
            $cart->save();
            $c_products = cart_counter();
            return response()->json(['success',$c_products]);
        } else {
            $c_products = cart_counter();
            return response()->json(['error',$c_products,'Already Exists']);
        }
    }


    public function CartUpdate(Request $request){
        $gsd = global_user_data();
         $selected_dealer = DealerSelection::where('user_id', $gsd->id)->first();
        
        $cart = Cart::where('id', $request->id)->first();

        if ($cart) {
            
                  
        $checkqty = ProductOwner::where('product_id',$cart->product_id)->where('dealer_id', $selected_dealer->dealer_id)
        ->first();
        if($checkqty->qty < $request->qty){
                $c_products = cart_counter();
                return response()->json(['error','Stock limit!']);
        }
            
            $product = Product::where('id', $cart->product_id)->first();
            $cart->qty = $request->qty;
            $cart->price = $request->qty * $product->main_price;
            $cart->point = $request->qty * $product->point;
            $cart->save();
          
            return response()->json(['success','update success!']);
        } else {
            $c_products = cart_counter();
            return response()->json(['error','update failed!']);
        }
    }
public function carts_info(Request $request){
    $gsd = global_user_data();
    $selected_dealer = DealerSelection::where('user_id', $gsd->id)->first();

    $cart_products = Cart::where('user_id', $gsd->id)->where('dealer_id',$selected_dealer->dealer_id)
        ->get();
        $points =   0;
        $prices =  0;
     

        foreach ($cart_products as $cart) {
            $points += $cart->point;
            $prices += $cart->price;
        }

  return response()->json([$points,$prices]);
}
    public function RemoveCart(Request $request)
    {
        Cart::destroy($request->id);
        $c_products = cart_counter();
        return response()->json(['succees',$c_products]);
    }

    public function CartCheckOut(Request $request)
    {
      $setting = setting();
        $gsd = global_user_data();
        $prev_sp_address = ShippingAddress::where('user_id', $gsd->id)->first();
        $prev = 0;
        if ($prev_sp_address) {
            $prev = 1;
        }
        $prev_bl_address = BillingAddress::where('user_id', $gsd->id)->first();

        $user_address = json_decode($gsd->address);

        $cart_datas = Cart::where('user_id', $gsd->id)
            ->with('product')
            ->get();
        return view('Admin.order.product.cart', compact('prev', 'prev_sp_address', 'prev_bl_address', 'user_address', 'cart_datas', 'gsd','setting'));
    }



    public function CartCheckOutConfirm(Request $request)
    {
        // dd($request->all());
        
        $gsd = global_user_data();
        
              $selected_dealer = DealerSelection::where('user_id', $gsd->id)->with('dealer')->first();
    
              if(!$selected_dealer){
               $selected_dealer = new DealerSelection();
               $selected_dealer->user_id = $gsd->id;
               $selected_dealer->dealer_id = 1;
               $selected_dealer->save();
        
            }
    
        
        $shipping_cost = 0;
        $aptp = 0;
        $gpoint = 0;
        
        $setting = setting();
        $cart_products = Cart::where('user_id', $gsd->id)
            ->with('product')
            ->get();

        if(count($cart_products) == 0){
            notify()->error('Your at is Empty!');
            return back();
        }

         foreach ($cart_products as $key => $dt) {
            $product = Product::find($dt->product_id);
            if (!$product) {
                notify()->error("This Product not found");
                return back();
            }

        if ($product->stock < $dt->qty) {
            notify()->error("This Product " . $dt->product->name . " Stock Out");
            return back();
        }
        
   
   

        $owner = ProductOwner::where('dealer_id', $selected_dealer->dealer_id)
            ->where('product_id', $dt->product_id)
            ->first();
        
        if (!$owner || $owner->qty < $dt->qty) {
            notify()->error("This Product " . $dt->product->name . " Stock Out From " . ($owner ? $owner->name : 'Unknown'));
            return back();
        }
        
             $aptp += $dt->qty * $dt->product->main_price;
    }


        if($request->rMethod == 'Courier'){
              
            if ($request->sp_state == 'Dhaka') {
                $shipping_cost = $setting->shipping_cost_in_dhaka;
            } else {
                $shipping_cost = $setting->shipping_cost_out_dhaka;
            }
        
            //Shipping Cost
              $aptp += $shipping_cost;
                // shipping
                $prev_sp_address = ShippingAddress::where('user_id', $gsd->id)->first();
                if (empty($prev_sp_address)) {
                    $sp_address = new ShippingAddress();
                    $sp_address->user_id = $gsd->id;
                    $sp_address->contact_person_name = $request->sp_name;
    
                    $sp_address->address = $request->sp_address;
                    $sp_address->country = $request->sp_country;
                    $sp_address->state = $request->sp_state;
                    $sp_address->phone = $request->sp_phone;
                    $sp_address->email = $request->sp_email;
                    $sp_address->save();
                } else {
                    $prev_sp_address->user_id = $gsd->id;
                    $prev_sp_address->contact_person_name = $request->sp_name;
    
                    $prev_sp_address->address = $request->sp_address;
                    $prev_sp_address->country = $request->sp_country;
                    $prev_sp_address->state = $request->sp_state;
                    $prev_sp_address->phone = $request->sp_phone;
                    $prev_sp_address->email = $request->sp_email;
                    $prev_sp_address->save();
                }
    
               
        }
        
        // foreach ($cart_products as $key => $dt) {
        //     $aptp += $dt->qty * $dt->product->main_price;
        //     $gpoint += $dt->qty * $dt->product->point;

        // }

      
        // dd($aptp);
            if($request->paymentMethod == "Cash"){

            }else {
                if ($aptp > $gsd->balance) {
                    if ($gsd->balance == 0) {
                        notify()->error('Sorry your  Balance is Empty');
                        return back();
                    } else {
                        notify()->error('Sorry your  Balance insufficient');
                        return back();
                    }
                } else {
                    if ($request->paymentMethod == "Wallet") {
                        $gsd->balance -= $aptp;
                        $gsd->point +=  $gpoint;
                        $gsd->save();
                    }
               }
            }

            $order = new Order();
            $order->shipping_cost = $shipping_cost;
            $order->user_id = $gsd->id;
            $order->dealer_id = $selected_dealer->dealer_id;
            $order->trucking_code = "HQ_" . Str::random(10);
            $order->order_type = 'product';
             if($request->rMethod == 'Courier'){
                $order->picup_method = 'Courier';
                $order->shipping = !empty($prev_sp_address) ? $prev_sp_address->id : $sp_address->id;
           
            }else{
               
            }
            $order->shipping_cost = $shipping_cost;

             if ($request->paymentMethod == "Wallet") {
                $order->payment_status = "Paid";
                $order->payment_method = "Wallet";
            } elseif ($request->paymentMethod == "Cash") {
                $order->payment_status = "Unpaid";
                $order->payment_method = "Cash";
            }
            $order->status = "Pending";
            $order->save();

            $total_point = 0;
      
            foreach ($cart_products as $key => $data) {
                $order_detail = new OrderDetail();
                $order_detail->order_type = 'product';
                $order_detail->order_id = $order->id;
                $order_detail->qty = $data->qty;
                $order_detail->product_id = $data->product->id;
                $order_detail->price = $data->product->main_price;
                $order_detail->total_price = $data->qty * $data->product->main_price;
                $order_detail->point = $data->product->point;
                $order_detail->total_point = $data->qty * $data->product->point;
                $order_detail->save();

                $total_point += $data->qty * $data->product->point;

                $product_q = Product::find($data->product->id);
                $product_q->stock -= $data->qty;
                $product_q->save();
        
                $owner = ProductOwner::where('dealer_id', $selected_dealer->dealer_id)
                    ->where('product_id', $data->product->id)
                    ->first();
                if ($owner) {
                    $owner->qty -= $data->qty;
                    $owner->save();
                }



                Cart::destroy('id', $data->id);
            }
            if ($request->paymentMethod == "Wallet") {
                
                // $PointSaleHistory = new PointSaleHistory();
                // $PointSaleHistory->user_id = $gsd->id;
                // $PointSaleHistory->point = $total_point;
                // $PointSaleHistory->status = 1;
                // $PointSaleHistory->save();
                // $chkm = $setting->check_point;

                // if($gsd->point >= $chkm && $gsd->distribute_status == 0){
                //     $prev_point = $gsd->point;
                //     $today = Carbon::today();
                //     $gsd->point -= $chkm;
                //     $gsd->submitted_point = $chkm;
                //     $gsd->point_submit_date = $today;
                //     $gsd->distribute_status = 1;
                //     $gsd->submit_check = 1;
                //     $gsd->save();
                //     trxCreate($chkm,$prev_point,$gsd->point,$gsd->id,'auto_pv_submit','admin action addtocart','+','N',"M");
                // }

            }

  

            notify()->success('Order Creating success!');
            return back();
        
    }
}
