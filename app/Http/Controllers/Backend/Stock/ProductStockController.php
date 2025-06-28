<?php

namespace App\Http\Controllers\Backend\Stock;

use App\Http\Controllers\Backend\Stock\Traits\Store;
use App\Http\Controllers\Backend\Stock\Traits\TransferCancel;
use App\Http\Controllers\Backend\Stock\Traits\TransferReject;
use App\Http\Controllers\Backend\Stock\Traits\TransferStore;
use App\Http\Controllers\Controller;
use App\Models\Dealer;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\ProductOwner;
use App\Models\ProductStock;
use App\Models\ProductTrasnsferRecord;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;


class ProductStockController extends Controller
{

    use Store;
    use TransferStore;
    use TransferReject;
    use TransferCancel;


    public function check_product_owner_raltime(Request $request) {
        $gsd = global_user_data();
        $query = ProductOwner::with(['product.category', 'owner'])
                              ->join('products', 'product_owners.product_id', '=', 'products.id')
                              ->select('product_owners.*', 'products.name as product_name'); // Adjust the columns as needed
    
        if ($gsd->id == 1) {
            $query->where('dealer_id', $request->id);
        } else {
            $query->where('dealer_id', $gsd->id);
        }
    
        if (isset($request->product_name) && $request->product_name != '') {
            $query->where('products.name', 'like', '%' . $request->product_name . '%');
        }
       $query->orderBy('qty');
        $stocks = $query->get();
        
        return view('Admin.product.stock.owner.render', compact('stocks','gsd'))->render();
        
       
    }

    public function update_product_stock(Request $request) {
    $stock = ProductOwner::find($request->id);
    if ($stock) {
        $stock->qty = $request->qty;
        $stock->save();
        return response()->json(['success' => true, 'message' => 'Stock updated successfully!']);
    }
    return response()->json(['success' => false, 'message' => 'Stock update failed.']);
}

    
    public function owner_stock_list(){
        $gsd = global_user_data();
        $query = ProductOwner::with(['product.category','owner']);

        $dealers = 0;
     
             if ($gsd->id == 1 || permission_checker($gsd->role_info,'product_manage') == 1){
            $dealers = Dealer::all();
            $query->where('dealer_id',$gsd->id);
        }else{
           
            $query->where('dealer_id',$gsd->id);
        }
         $query->orderBy('qty');
        $stocks = $query->get();
        
        return view('Admin.product.stock.owner.design-1',compact('stocks','dealers','gsd'));
    }

    public function index(){
         $gsd = global_user_data();
             if ($gsd->id == 1 || permission_checker($gsd->role_info,'stock_manage') == 1){
        $stocks = ProductStock::with(['product','owner','creator'])->get();
         return view('Admin.product.stock.index.design-1',compact('stocks','gsd'));
        }else{
            notify()->error('permission not allow!');
            return back();
        }
     }
     public function stocker(){
        $gsd = global_user_data();
             if ($gsd->id == 1 || permission_checker($gsd->role_info,'stock_manage') == 1){
        $dealers = Dealer::all();
        $brands = ProductBrand::all();
        $categories = ProductCategory::all();
        return view('Admin.product.stock.create.design-1',compact('dealers','categories','brands','gsd'));
        }else{
            notify()->error('permission not allow!');
            return back();
        }
    }
    public function stock_store(Request $request){
          $gsd = global_user_data();
             if ($gsd->id == 1 || permission_checker($gsd->role_info,'stock_manage') == 1){
            return $this->StockStore($request);
        }else{
            notify()->error('permission not allow!');
            return back();
        }
    }

    public function stock_transfer_list(){
        $gsd = global_user_data();
        $query = ProductTrasnsferRecord::with(['sender','receiver','product','creator']);
    
             if ($gsd->id == 1 || permission_checker($gsd->role_info,'stock_manage') == 1){

        }else{
            $query->where('sender_id',$gsd->id)->orWhere('receiver_id',$gsd->id);
        }
        $transfer_histories = $query->latest('id')->get();
        return view('Admin.product.stock.transfer.index.design-1',compact('transfer_histories','gsd'));
    } 

    public function dealer_order_history(){
        $gsd = global_user_data();
        $dealer = Dealer::where("user_id", $gsd->id)->exists();
       
        if (Auth::id() == 1){
            $orders = Order::where('order_type','product')->with(['order_detail.product','user','shipping_address'])->with('dealer')->latest('id')->paginate(10);
       
        }else if( $dealer == true){
            
            $orders = Order::where('order_type','product')->where('dealer_id',$gsd->id)->with(['order_detail.product','user','shipping_address'])->latest('id')->paginate(10);
        }
        return view('Admin.orders.product.index',compact('orders','gsd'));
    

    }
    
    public function stock_transfer_options(){
        $gsd = global_user_data();
   
             if ($gsd->id != 1 || permission_checker($gsd->role_info,'stock_manage') == 0){
            notify()->error('permission not allow');
            return back();
        }
        $dealers = Dealer::all();
        $sender = Dealer::where('user_id',$gsd->id)->first();

        $brands = ProductBrand::all();
        $categories = ProductCategory::all();
        return view('Admin.product.stock.transfer.create.design-1',compact('sender','categories','brands','dealers','gsd'));
    }

    public function Dealer_stock_product(Request $request){
        $Dealer = Dealer::where('id',$request->Dealer)->with('stock_records')->first();
        return response()->json($Dealer);
    }

    public function stock_transfer_store(Request $request){
        $gsd = global_user_data();
   
             if ($gsd->id != 1 || permission_checker($gsd->role_info,'stock_manage') == 0){
            notify()->error('permission not allow');
            return back();
        }
        return $this->StockTransferStore($request);
    }
    
    public function stock_transfer_status(Request $request){
        $record = ProductTrasnsferRecord::where('id',$request->id)->first();
        if($record->status != 'Pending'){
            notify()->error('Sorry');
            return back();
        }else{

            if($request->status == "Accept"){
                $record->status = "Accept";
                $record->updated_by = Auth::id();
                $record->save();


                
                $receiver_owner_check = ProductOwner::where('product_id',$record->product_id)->where('dealer_id',$record->receiver_id)->first(); 
                    if($receiver_owner_check){
                        $receiver_owner_check->qty += $record->qty;
                        $receiver_owner_check->save();
                    }else{
                        $receiver_owner = new ProductOwner();
                        $receiver_owner->product_id = $record->product_id;
                        $receiver_owner->dealer_id = $record->receiver_id;
                        $receiver_owner->qty = $record->qty;
                        $receiver_owner->save();
                    }
        

                notify()->success('Accept Success');
                return back();
            }
    
            if($request->status == "Reject"){
                return $this->StockTransferReject($request);
            }

            if($request->status == "Cancel"){
                return $this->StockTransferCancel($request);
            }
        }
       
    }
}
