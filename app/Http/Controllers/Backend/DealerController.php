<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BdLocation;
use App\Models\Dealer;
use App\Models\DealerSelection;
use App\Models\User;
use Illuminate\Http\Request;

class DealerController extends Controller
{
    public function dealer_select_for_buying(Request $request){
                $gsd = global_user_data();
                
                $dealer = Dealer::where('user_id',$request->dealer)->first();
                
                if($dealer){
                    $sdealer = DealerSelection::where('user_id',$gsd->id)->first();
                    if($sdealer){
                        $sdealer->dealer_id = $request->dealer;
                        $sdealer->save();
                    }else{
                        $n_dealer = new DealerSelection();
                        $n_dealer->dealer_id = $request->dealer;
                        $n_dealer->user_id = $gsd->id;
                        $n_dealer->save();
                    }
                    notify()->success('Dealer Select Done');
                    return back();
                }else{
                    notify()->error('Dealer not found');
                    return back();
                }
         
    }
    
    
    
    public function index(){
        $gsd = global_user_data();
         if ($gsd->id == 1 || permission_checker($gsd->role_info,'dealer_manage') == 1){
             $dealers = Dealer::where('user_id', '!=', 1)->with('ref','user')->latest('id')->get();
            
            return view('Admin.dealer.index',compact('dealers','gsd'));
         }
    }
    public function create(){
            $gsd = global_user_data();
             if ($gsd->id == 1 || permission_checker($gsd->role_info,'dealer_manage') == 1){
        $divisions = BdLocation::where('division',1)->get();
        return view('Admin.dealer.create',compact('divisions','gsd'));
             }
    }
    public function store(Request $request){
        $gsd = global_user_data();
         if ($gsd->id == 1 || permission_checker($gsd->role_info,'dealer_manage') == 1){
        $user = User::where('username',$request->username)->first();
        $ref = User::where('username',$request->ref_username)->first();
       


        $dealer = new Dealer();
        $dealer->user_id = $user->id;
        $dealer->ref_id = $ref->id;
        $dealer->phone = $request->phone;
        $dealer->email = $request->email;
        $dealer->name = $request->name;
        $dealer->status = $request->status;
        $dealer->full_address = $request->address;
        $dealer->country = $request->country;

        $dealer->save();
        notify()->success('Dealer Create submitted !');
        return back();
         }
    }
    public function edit(Request $request){
             $gsd = global_user_data();
         if ($gsd->id == 1 || permission_checker($gsd->role_info,'dealer_manage') == 1){
        $dealer = Dealer::where('id',$request->id)->with('ref','user')->first();
        $divisions = BdLocation::where('division',1)->get();
        return view('Admin.dealer.edit',compact('dealer','divisions','gsd'));
         }
    }



    public function update(Request $request) {
          $gsd = global_user_data();
         if ($gsd->id == 1 || permission_checker($gsd->role_info,'dealer_manage') == 1){
        // Helper function to get location name
       
    
        // Retrieve and update dealer
        $dealer = Dealer::find($request->dealer_id);
        if (!$dealer) {
            return back()->withErrors(['Dealer not found']);
        }
    $dealer->full_address = $request->address;
        $dealer->phone = $request->phone;
        $dealer->email = $request->email;
        $dealer->name = $request->name;
        $dealer->status = $request->status;
        $dealer->country = $request->country;
        $dealer->save();
        notify()->success('Update submitted!');
        return back();
         }
    }
    

    
}
