<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PointSaleHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Package;
use App\Models\RoiSetting;
use App\Models\ProductOwner;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ShippingAddress;
use App\Models\BillingAddress;
use Illuminate\Support\Str;
use App\Models\DealerSelection;
use App\Models\Withdraw;
use App\Models\User;
use App\Notifications\UserMessageNotification;
class PurchaseController extends Controller
{
    public function productOrder(Request $request)
    {
        $gsd = global_user_data();
        $prev_sp_address = ShippingAddress::where('user_id', $gsd->id)->first();
        $prev = 0;
        if ($prev_sp_address) {
            $prev = 1;
        }
        $prev_bl_address = BillingAddress::where('user_id', $gsd->id)->first();

        $user_address = json_decode($gsd->address);
        $product = Product::where('slug', $request->slug)->first();
        return view('Admin.order.product.index', compact('prev', 'prev_sp_address', 'prev_bl_address', 'user_address', 'product', 'gsd'));
    }

    public function packageOrder(Request $request)
    {
        $gsd = global_user_data();
        $package = Package::where('slug', $request->slug)
            ->latest('id')
            ->first();

        $prev_sp_address = ShippingAddress::where('user_id', $gsd->id)->first();
        $prev = 0;
        if ($prev_sp_address) {
            $prev = 1;
        }
        $prev_bl_address = BillingAddress::where('user_id', $gsd->id)->first();

        $user_address = json_decode($gsd->address);

        return view('Admin.order.package.index', compact('prev', 'prev_sp_address', 'prev_bl_address', 'user_address', 'package', 'gsd'));
    }

    public function productConfirmOrder(Request $request)
    {
         $gsd = global_user_data();
       
          $selected_dealer = DealerSelection::where('user_id', $gsd->id)->with('dealer')->first();
    
              if(!$selected_dealer){
               $selected_dealer = new DealerSelection();
               $selected_dealer->user_id = $gsd->id;
               $selected_dealer->dealer_id = 1;
               $selected_dealer->save();
        
            }
        $setting = setting();

        if($request->paymentMethod == ""){
            notify()->error('Please Select Payment Method');
            return back();
        }

        $product = Product::where('id', $request->product_id)->first();
          if (!$product) {
                    notify()->error('Product not found');
                    return back();
                }
    
        $owner = ProductOwner::where('dealer_id', $selected_dealer->dealer_id)
            ->where('product_id', $product->id)
            ->first();
    
        if (!$owner || $owner->qty < $request->product_qty) {
            notify()->error('Stock limit or dealer not available');
            return back();
        }
        $shipping_cost = 0;
        if($request->rMethod == 'Courier'){
            if ($request->sp_state == 'Dhaka') {
                $shipping_cost = $setting->shipping_cost_in_dhaka;
            } else {
                $shipping_cost = $setting->shipping_cost_out_dhaka;
            }
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

    
    
        $final_price = $product->main_price * $request->product_qty;
        $total_point = $request->product_qty * $product->point;
        
        if ($request->paymentMethod == "Cash") {
          
        } else {
            if ($final_price + $shipping_cost > $gsd->balance) {
                if ($gsd->balance  == 0) {
                    notify()->error('Sorry your  Balance is Empty');
                    return back();
                } else {
                    notify()->error('Sorry your  Balance insufficient');
                    return back();
                }
            } else {
            
                if ($request->paymentMethod == "Wallet") {
                    $gsd->balance -= $final_price + $shipping_cost;
                    $gsd->point += $total_point;
                    $gsd->save();

                    $withdraw = new Withdraw();
                    $withdraw->user_id = $gsd->id;
                    $withdraw->method_code = "Wallet Payment";
                    $withdraw->amount = $final_price + $shipping_cost;
                    $withdraw->charge =  0;
                    $withdraw->detail = '';
                    $withdraw->payment_r_ac =  'Wallet payment';
                    $withdraw->refer_trx = strtoupper(Str::random(11)); // Or generate based on your logic
                    $withdraw->status = 'Approve'; // or 0 if using integer
                    $withdraw->trx = strtoupper(Str::random(10));
                    $withdraw->admin_feedback = '';
                    $withdraw->created_at = Carbon::now();
                    $withdraw->updated_at = Carbon::now();
                    $withdraw->save();
                    // $chkm = $setting->check_point;

                    // $PointSaleHistory = new PointSaleHistory();
                    // $PointSaleHistory->user_id = $gsd->id;
                    // $PointSaleHistory->point = $total_point;
                    // $PointSaleHistory->status = 1;
                    // $PointSaleHistory->save();

                    // if($gsd->point >= $chkm && $gsd->distribute_status == 0){
                    //     $prev_point = $gsd->point;
                    //     $today = Carbon::today();
                    //     $gsd->point -= $chkm;
                    //     $gsd->submitted_point = $chkm;
                          
                    
                    //     $gsd->point_submit_date = $today;
                    //     $gsd->distribute_status = 1;
                    //     $gsd->submit_check = 1;
                    //     $gsd->save();
                
                    //     trxCreate($chkm,$prev_point,$gsd->point,$gsd->id,'auto_pv_submit','admin action','+','N',"M");
                    // }


                }
            }
        }

        // order

            $order = new Order();
            $order->user_id = $gsd->id;
            $order->dealer_id = $selected_dealer->dealer_id;
            $order->order_type = 'product';
            $order->trucking_code = "JB_" . Str::random(10);
            if($request->rMethod == 'Courier'){
                $order->picup_method = 'Courier';
                $order->shipping = !empty($prev_sp_address) ? $prev_sp_address->id : $sp_address->id;
                
            }

            $order->shipping_cost = $shipping_cost;
            if ($request->paymentMethod == "Wallet") {
                $order->payment_status = "Paid";
                $owner->qty -= $request->product_qty;
                $owner->save();
                $product->stock -= $request->product_qty;
                $product->save();
                $order->payment_method = "Wallet";
            } elseif ($request->paymentMethod == "Cash") {
                $order->payment_status = "Unpaid";
                $order->payment_method = "Cash";
            }
            $order->status = "Pending";
            $order->save();

            // order detail
            $order_detail = new OrderDetail();
            $order_detail->order_id = $order->id;
            $order_detail->order_type = 'product';
            $order_detail->qty = $request->product_qty;
            $order_detail->price = $product->main_price;
            $order_detail->total_price = $final_price;
            $order_detail->point = $product->point;
            $order_detail->total_point = $total_point;
            
            
            $order_detail->product_id = $product->id;
            $order_detail->save();

            $gsd->save();
            
              //Send Notification to Admin
            $admin = User::where('id', 1)->first();
            $template = getNotificationTemplate('new_order', [
                '[amount]' =>number_format($final_price,2),
                '[order_by_name]' => $gsd->username,
                '[method]' => $request->paymentMethod ,
                '[points]' => $order_detail->total_point,

                ]);
                $data = [
                'body' => $template['body'],
                'type' => $template['type'],
                'subject' => $template['subject'],
                'url' => url('product-orders'),
                ];
                $admin->notify(new UserMessageNotification($data));
                        
            notify()->success('Order Creating success!');
            return back();
            
        
    }

    public function productConfirmReOrder(Request $request)
    {
        $data = $request->except('_token'); // get all data except _token

        if (empty($data)) {
            return back()->withErrors('No data submitted.');
        }
        $prices = $request->input('price');        // Array of prices
        $ids = $request->input('id');               // Array of IDs
        $dealer_ids = $request->input('dealer_id'); // Array of dealer IDs
        $qtys = $request->input('qty');             // Array of qtys
        $order_id = $request->input('order_id');             // Array of qtys
    
        foreach ($ids as $index => $productId) {
            $price = $prices[$index];
            $dealerId = $dealer_ids[$index];
            $quantity = $qtys[$index];
            $orderId = $order_id[$index];
        // dd($request->all());
         $gsd = global_user_data();
        
    
        $product = Product::where('id', $productId)->first();
          if (!$product) {
                    notify()->error('Product not found');
                    return back();
                }
    
        $owner = ProductOwner::where('dealer_id', $dealerId)
            ->where('product_id', $productId)
            ->first();
    
        // if (!$owner || $owner->qty < $quantity) {
        //     notify()->error('Stock limit or dealer not available');
        //     return back();
        // }
        
    
        $final_price = $product->main_price * $quantity;
        $total_point = $quantity * $product->point;
        
                // order detail
            $order_detail = new OrderDetail();
            $order_detail->order_id = $orderId;
            $order_detail->order_type = 'product';
            $order_detail->qty = $quantity;
            $order_detail->price = $product->main_price;
            $order_detail->total_price = $final_price;
            $order_detail->point = $product->point;
            $order_detail->total_point = $total_point;
            
            
            $order_detail->product_id = $product->id;
            $order_detail->save();

            // $gsd->save();
            
            
                    
                // $owner->qty -= $quantity;
                // $owner->save();
            
                // $product->stock -= $quantity;
                // $product->save();
        }
            
            
            notify()->success('Order Creating success!');
            return back();
            
        
    }

    public function productConfirmOrderEdit(Request $request)
    {

        $prevQty = $request->input('prev_qty');
        $orderDetailsIds = $request->input('order_details_id');
        $orderIds = $request->input('order_id');
        $productIds = $request->input('product_id');
        $qtys = $request->input('qty');
        $dealer_ids = $request->input('dealer_id');
    
        // Process data (e.g., saving to database)
        foreach ($orderDetailsIds as $index => $orderDetailsId) {
            // Example: Updating order details
            
                $orev_quantity  = $prevQty[$index];
                $quantity = $qtys[$index];
                $orderIds[$index];
                $productId =$productIds[$index];
                $dealerId =$dealer_ids[$index];
          
        
    
  
        
         $gsd = global_user_data();
        
    
        $product = Product::where('id', $productId)->first();
          if (!$product) {
                    notify()->error('Product not found');
                    return back();
                }
    
        $owner = ProductOwner::where('dealer_id', $dealerId)
            ->where('product_id', $productId)
            ->first();
    
      
        
        // $owner->qty +=array_sum($prevQty);
        // $owner->save();
    
        // $product->stock += array_sum($prevQty);
        // $product->save();

       
        if($quantity <=0){
            if(count($orderIds) <=1){
                notify()->error('At least one product required in an order');
                return back();
            }
         OrderDetail::where('id', $orderDetailsId)->delete();
        }else{

            // if (!$owner || $owner->qty < $quantity) {
            //     notify()->error('Stock limit or dealer not available');
            //     return back();
            // }
            $final_price = $product->main_price * $quantity;
            $total_point = $quantity * $product->point;
        $order_detail = OrderDetail::where('id', $orderDetailsId)->first();
        if ($order_detail) {
            $order_detail->order_type = 'product';
            $order_detail->qty = $quantity;
            $order_detail->price = $product->main_price;
            $order_detail->total_price = $final_price;
            $order_detail->point = $product->point;
            $order_detail->total_point = $total_point;
            $order_detail->product_id = $product->id;
            $order_detail->save();
        }
                     
                    
                $owner->qty -= $quantity;
                $owner->save();
            
                $product->stock -= $quantity;
                $product->save();
        }
    }
            
            notify()->success('Order Updateing success!');
            return redirect()->to(url('product-order-details/' . $request->order_id[0]));
            
        
    }

// package confirm
    public function packageConfirmOrder(Request $request)
     {
        $gsd = global_user_data();
        $selected_dealer = DealerSelection::where('user_id', $gsd->id)->with('dealer')->first();
    
        if(!$selected_dealer){
         $selected_dealer = new DealerSelection();
         $selected_dealer->user_id = $gsd->id;
         $selected_dealer->dealer_id = 1;
         $selected_dealer->save();
  
      }

        $gsd = global_user_data();
        $setting = setting();
        $package = Package::where('id', $request->package_id)->first();
        $shipping_cost = 0;
        if($request->rMethod == 'Courier'){
            if ($request->sp_state == 'Dhaka') {
                $shipping_cost = $package->shipping_cost_in_dhaka;
            } else {
                $shipping_cost = $package->shipping_cost_out_dhaka;
            }

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
        
        $final_price = $package->main_price;
        $total_point = $package->point;
        
            if($request->paymentMethod == "Cash"){
      
            }else {
                if ($final_price+$shipping_cost > $gsd->balance) {
                    if ($gsd->balance == 0) {
                        notify()->error('Sorry your  Balance is Empty');
                        return back();
                    } else {
                        notify()->error('Sorry your  Balance insufficient');
                        return back();
                    }
                } else {
                  
                    if ($request->paymentMethod == "Wallet") {
                        $gsd->balance -= $final_price + $shipping_cost;
                        $gsd->point +=  $request->package_qty * $package->point;

                        $gsd->save();

                        $PointSaleHistory = new PointSaleHistory();
                        $PointSaleHistory->user_id = $gsd->id;
                        $PointSaleHistory->point = $total_point;
                        $PointSaleHistory->status = 1;
                        $PointSaleHistory->save();

                    }
                }
            }
                
            $order = new Order();
            $order->user_id = $gsd->id;
            $order->dealer_id =  $selected_dealer->dealer_id;
           
            $order->order_type = 'package';
            $order->shipping_cost = $shipping_cost;
            $order->trucking_code = "JB_" . Str::random(10);
            if($request->rMethod == 'Courier'){
                $order->picup_method = 'Courier';
                $order->shipping = !empty($prev_sp_address) ? $prev_sp_address->id : $sp_address->id;
         
            }

            if ($request->paymentMethod == "Wallet") {
                $order->payment_status = "Paid";
                $order->payment_method = "Wallet";
            } elseif ($request->paymentMethod == "Cash") {
                $order->payment_status = "Unpaid";
                $order->payment_method = "Cash";
            }
                $order->status = "Pending";
                $order->save();

                // order detail
                $order_detail = new OrderDetail();
                $order_detail->order_id = $order->id;
                $order_detail->order_type = 'package';
                $order_detail->qty = $request->package_qty;
                $order_detail->price = $package->main_price;
                $order_detail->total_price = $final_price;
                $order_detail->point = $package->point;
                $order_detail->total_point = $total_point;
                $order_detail->package_id = $package->id;
                $order_detail->save();

                $gsd->invest_status = 1;
                $gsd->save();
                if ($request->paymentMethod == "Wallet") {
                   $chkm =$setting->check_point;
                    
                if($gsd->point >= $chkm && $gsd->distribute_status == 0){
                    $prev_point = $gsd->point;
                    $today = Carbon::today();
                    $gsd->point -= $chkm;
                    
                    if($gsd->new_submited_point_status == 0){
                        $gsd->new_submited_point_status = 2;
                    }
                    
                    $gsd->submitted_point = $chkm;
                    $gsd->point_submit_date = $today;
                    $gsd->distribute_status = 1;
                    $gsd->submit_check = 1;
                    $gsd->save();
                    
                    
                    $ph = new PointSubmitHistory();
                    $ph->point = $chkm;
                    $ph->user_id = $gsd->id;
                    $ph->created_at = $today;
                    $ph->updated_at = $today;
                    $ph->save();
                    
                    $PointSaleHistory = new PointSaleHistory();
                    $PointSaleHistory->user_id = $gsd->id;
                    $PointSaleHistory->point = $total_point;
                    $PointSaleHistory->status = 1;
                    $PointSaleHistory->save();
                    
                    referralComission($gsd->id);
                    trxCreate($chkm,$prev_point,$gsd->point,$gsd->id,'auto_pv_submit','admin action purchase','+','N',"M");
                } 
                    
                if($gsd->new_submited_point_status == 2){
                     autoMatrixGenerator($gsd->id);
                }
                      
            }

        notify()->success('Package order  success!');
        return back(); 
    }
}
