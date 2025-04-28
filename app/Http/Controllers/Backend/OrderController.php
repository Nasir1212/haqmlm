<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductOwner;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PointSaleHistory;
use App\Models\Product;
use App\Models\Package;
use App\Models\User;
use App\Models\Dealer;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function packageOrders(Request $request){
        $gsd = global_user_data();
        $dealer = Dealer::where("user_id", $gsd->id)->exists();
       // dd(Order::where('order_type','package')->where('dealer_id',$gsd->id)->get());
        
        if (Auth::id() == 1){
         $orders = Order::where('order_type','package')->with(['order_detail.package','user','shipping_address'])->latest('id')->paginate(10);
      
        }else if( $dealer == true){
          
            $orders = Order::where('order_type','package')->where('dealer_id',$gsd->id)->with(['order_detail.package','user','shipping_address'])->latest('id')->paginate(10);
            
        }else{
          $orders = Order::where('user_id',$gsd->id)->where('order_type','package')->with(['order_detail.package','user','shipping_address'])->latest('id')->paginate(10);
        }
        return view('Admin.orders.package.index',compact('orders','gsd'));
        
    
    }

    public function productOrders(Request $request){
        $gsd = global_user_data();
        $dealer = Dealer::where("user_id", $gsd->id)->exists();
       
        if (Auth::id() == 1){
            $orders = Order::where('order_type','product')->with(['order_detail.product','user','shipping_address'])->latest('id')->paginate(10);
        }else if( $dealer == true){
            
            $orders = Order::where('order_type','product')->where('dealer_id',$gsd->id)->with(['order_detail.product','user','shipping_address'])->latest('id')->paginate(10);
        }else{
            $orders = Order::where('user_id',$gsd->id)->where('order_type','product')->with(['order_detail.product','user','shipping_address'])->latest('id')->paginate(10);
        }
        return view('Admin.orders.product.index',compact('orders','gsd'));
    }

    public function productOrderDetails(Request $request){
        $gsd = global_user_data();
        $order = Order::where('id',$request->id)->with(['order_detail.product','user','shipping_address','billing_address','dealer'])->first();
        $products = Product::select('products.*', 'product_owners.qty as owner_qty')
        ->join('product_owners', 'products.id', '=', 'product_owners.product_id')
        ->where('product_owners.dealer_id', $order->dealer->user_id)
        ->latest('products.id')
        ->get();
        // ->paginate(24);

       
        return view('Admin.orders.product.details',compact('order','gsd','products'));
    }

    public function generate_product_invoice(Request $request){
        $gsd = global_user_data();
        $setting = setting();
          $order = Order::where('id',$request->id)->with(['order_detail.product','user.sponsor','shipping_address','billing_address','dealer'])->first();
          $user_address = json_decode($order->user->address);
         
     
         return  view('Admin.orders.product.invoice',compact('order','gsd','setting','user_address'));
     

  
    }
    
    
    public function generate_product_invoice_download(Request $request){
        $gsd = global_user_data();
        $setting = setting();
       
      $order = Order::where('id',$request->id)->with(['order_detail.product','user.sponsor','shipping_address','billing_address'])->first();
      $user_address = json_decode($order->user->address);
 
      $html = view('Admin.orders.product.invoice_download',compact('order','gsd','setting','user_address'))->render();
   
      $mpdf = new Mpdf([
        'mode' => 'utf-8', // Enable UTF-8
        'format' => 'A4',
       
    ]);

  

    // Use the custom Bangla font in the HTML content
    $mpdf->WriteHTML($html);

     $filename = "invoice_{$order->id}.pdf"; // Customize filename as needed
     return $mpdf->Output($filename, 'D'); // 'D' forces the browser to download the PDF
    }

    public function product_order_status_change(Request $request){
         $gsd = global_user_data();
         if (auth()->user()->id == 1 || permission_checker($gsd->role_info,'order_manage') == 1|| is_dealer(auth()->user()->id) == true){

            $setting = setting();
        $order = Order::where('id',$request->id)->with('order_detail')->first();
        if($order->status != "Delivered" && $request->order_status == "Returned" &&  $order->status != "Returned"){
             $odd = OrderDetail::where('order_id', $order->id)->get();
              if($odd){
                    foreach($odd as $ddt){
                             
                            $product_q = Product::find($ddt->product_id);
                            $product_q->stock += $ddt->qty;
                            $product_q->save();   
                             
                        $owner = ProductOwner::where('dealer_id', $order->dl_id)
                            ->where('product_id', $ddt->product_id)
                            ->first();
                        if ($owner) {
                            $owner->qty += $ddt->qty;
                            $owner->save();
                        }
                            
                        }
                  }
         }
         
         
        if($order->status != "Delivered" &&  $order->status != "Returned"){
            if($request->order_status == "Delivered"){
                if($order->payment_status == "Paid"){
                      $order->status = $request->order_status;
                        $order->updated_by = $gsd->name;
                        $order->save();
                        
                        
                       $user = User::where('id',$order->user_id)->first();
                        if($order->order_type == 'product'){
                            $total_point = 0;
                            foreach ($order->order_detail as $key => $value) {
                               $pd = Product::where('id',$value->product_id)->first();
                               if ($pd) {
                                $user->point += $value->total_point;
                                $user->save();
                                $total_point += $value->total_point;
                               }
                            } 
            
            
                                // $chkm = $setting->check_point;
                                // if($user->point >= $chkm && $user->distribute_status == 0){
                                //     $prev_point = $user->point;
                                //     $today = Carbon::today();
                                //     $user->point -= $chkm;
                                //     $user->submitted_point = $chkm;
                                      
                                //     $user->total_submitted_point += $chkm;
                                //     $user->point_submit_date = $today;
                                //     $user->distribute_status = 1;
                                //     $user->submit_check = 1;
                                //     $user->save();
                            
                                //     trxCreate($chkm,$prev_point,$user->point,$user->id,'auto_pv_submit','admin action','+','N',"M");
                                // }
            
            
                            $PointSaleHistory = new PointSaleHistory();
                            $PointSaleHistory->user_id = $user->id;
                            $PointSaleHistory->point = $total_point;
                            $PointSaleHistory->status = 1;
                            $PointSaleHistory->save();
                            
                        }
                     
                    }else{
                        return response()->json(['success'=>'Oparation fail for payment unpaid!']);
                    }
              }else{

                $order->status = $request->order_status;
                $order->updated_by = $gsd->name;
                $order->save();
            }
        }



        return response()->json(['success'=>'Status Chage Successfully!']);
      
        }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    }
    public function product_order_payment_status_change(Request $request){
            $setting = setting();
             $gsd = global_user_data();
             if (auth()->user()->id == 1 || permission_checker($gsd->role_info,'order_manage') == 1|| is_dealer(auth()->user()->id) == true){
             $gsd = global_user_data();
            $order = Order::where('id',$request->id)->with('order_detail')->first();
            $order->payment_status = $request->payment_status;
            $order->save();

      

        return response()->json(['success'=>'Status Chage Successfully!']);
             }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    }  
    public function product_order_shipping_cost_change(Request $request){
         $gsd = global_user_data();
         if (auth()->user()->id == 1 || permission_checker($gsd->role_info,'order_manage') == 1|| is_dealer(auth()->user()->id) == true)
         {
        $order = Order::where('id',$request->id)->first();
        $order->shipping_cost = $request->amount;
        $order->save();

        return response()->json(['success'=>'Shipping Cost Updated!']);
        
    }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    }

// package 

public function packageOrderDetails(Request $request){
    $gsd = global_user_data();
    $order = Order::where('id',$request->id)->with(['order_detail.package','user','shipping_address','billing_address'])->first();
    return view('Admin.orders.package.details',compact('order','gsd'));
}

public function generate_package_invoice(Request $request){
       $gsd = global_user_data();
       $setting = setting();
       
       $order = Order::where('id',$request->id)->with(['order_detail.package','user.sponsor','shipping_address','billing_address'])->first();
  
       $user_address = json_decode($order->user->address);
       // , 'isRemoteEnabled' => true
       
        // $pdf = PDF::loadView('Admin.orders.package.invoice',compact('order','gsd','setting','user_address'))->setOptions([
        // 'format' => 'A4','dpi' => 150,'images' => true, "enable_php" => true, 'isHtml5ParserEnabled', true, 'isRemoteEnabled' => true ]);

        // return $pdf->stream('product'.$order->id.'.pdf');
   

}

public function package_order_status_change(Request $request){
      $gsd = global_user_data();
      if (auth()->user()->id == 1 || permission_checker($gsd->role_info,'order_manage') == 1|| is_dealer(auth()->user()->id) == true)
{
    $order = Order::where('id',$request->id)->first();
    $order->status = $request->order_status;
    $order->save();

    return response()->json(['success'=>'Status Chage Successfully!']);
    
}else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
}
public function package_order_payment_status_change(Request $request){
     $setting = setting();
    $gsd = global_user_data();
    if (auth()->user()->id == 1 || permission_checker($gsd->role_info,'order_manage') == 1|| is_dealer(auth()->user()->id) == true){

    $order = Order::where('id',$request->id)->with('order_detail')->first();
    $order->payment_status = $request->payment_status;
    $order->save();

    if($request->payment_status == 'Paid'){
        $user = User::where('id',$order->user_id)->first();
        if($order->order_type == 'package'){
            $total_point = 0;
            foreach ($order->order_detail as $key => $value) {
               $pd = Package::where('id',$value->package_id)->first();
               if ($pd) {
                $user->point += $value->total_point;
                $user->save();
                $total_point += $value->total_point;
               }
            } 


                $chkm = $setting->check_point;
                    if($user->point >= $chkm && $user->distribute_status == 0){
                        $prev_point = $user->point;
                        $today = Carbon::today();
                        $user->point -= $chkm;
                        $user->submitted_point = $chkm;
                        $user->total_submitted_point += $chkm;
                        if($user->new_submited_point_status == 0){
                            $user->new_submited_point_status = 2;
                        }
                    
                        $user->point_submit_date = $today;
                        $user->distribute_status = 1;
                        $user->submit_check = 1;
                        $user->save();
                        
                        referralComission($user->id);
                        
                        trxCreate($chkm,$prev_point,$user->point,$user->id,'auto_pv_submit','action purchase','+','N',"M");
                    }

                   if($user->new_submited_point_status == 2){
                     autoMatrixGenerator($user->id);
                   }



            $PointSaleHistory = new PointSaleHistory();
            $PointSaleHistory->user_id = $user->id;
            $PointSaleHistory->point = $total_point;
            $PointSaleHistory->status = 1;
            $PointSaleHistory->save();
            
        }else {
            # code... package
        }
    }

    return response()->json(['success'=>'Status Chage Successfully!']);
    
}else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
}  
public function package_order_shipping_cost_change(Request $request){
      $gsd = global_user_data();
      if (auth()->user()->id == 1 || permission_checker($gsd->role_info,'order_manage') == 1|| is_dealer(auth()->user()->id) == true){
        $order = Order::where('id',$request->id)->first();
            $order->shipping_cost = $request->amount;
            $order->save();
        
            return response()->json(['success'=>'Shipping Cost Updated!']);
    
}else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
}


}
