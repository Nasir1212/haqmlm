<?php
namespace App\Http\Controllers\Backend\Stock\Traits;
use App\Models\ProductOwner;
use App\Models\ProductTrasnsferRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait TransferCancel
{
    public function StockTransferCancel(Request $request){
        $record = ProductTrasnsferRecord::where('id',$request->id)->first();
        if ($record) {
            $record->status = "Cancel";
            $record->updated_by = Auth::id();
            $record->save();

           $sender_owner = ProductOwner::where('dealer_id',$record->sender_id)->where('product_id',$record->product_id)->first();
           $sender_owner->qty += $record->qty;
           $sender_owner->save();
           notify()->success('Cancel Success');
           return back();


        }else{
            notify()->success('Record not found');
           return back();
        }
     
    }
}