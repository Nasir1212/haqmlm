<?php
namespace App\Http\Controllers\Backend\Stock\Traits;

use App\Models\Dealer;
use App\Models\ProductOwner;
use App\Models\ProductTrasnsferRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait TransferStore
{
    public function StockTransferStore(Request $request){
        $gsd = global_user_data();
        $owner_check = ProductOwner::where('product_id',$request->product)->where('dealer_id',$gsd->id)->first();
            if($owner_check){
                    if($owner_check->qty < $request->product_qty){
                        notify()->error('Stock limit Please check reserve stock1');
                        return back();
                    }else{
                        $owner_check->qty -= $request->product_qty;
                        $owner_check->save();
                    }
            }else{
                notify()->error('Operation failed!');
                return back();
            }
        
                $transfer_record = new ProductTrasnsferRecord();
                $transfer_record->receiver_id = $request->receiver_dealer;
                $transfer_record->sender_id = $request->sender_dealer;
                $transfer_record->product_id = $request->product;
                $transfer_record->qty = $request->product_qty;
                $transfer_record->created_by = Auth::id();
                $transfer_record->status = "Pending";
                $transfer_record->save();
                notify()->success('Product Transfer Success');
                return redirect()->route('product_stock_transfer_list');
           
    }
}