<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Gateway;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Image;

class GatewayController extends Controller
{
        // gateways

        public function gateways(){
            $gsd = global_user_data();
            $gateways = Gateway::all();
            return view('Admin.gateway.gateways',compact('gateways','gsd'));
        } 
    
        public function add_gateway(){
            $gsd = global_user_data();
            
            if (Auth::id() == 1 || permission_checker($gsd->role_info,'gateway_manage') == 1){
            return view('Admin.gateway.add_gateway',compact('gsd'));
            }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
        } 
        
        public function gateway_store(Request $request){
            $gsd = global_user_data();
             if (Auth::id() == 1 || permission_checker($gsd->role_info,'gateway_manage') == 1){
            $gateway = new Gateway();
    
            if($request->hasFile('image')){
                $dt = Carbon::now();
                $micro = $dt->micro;
                $image_obj = $request->file('image');
                $orpath = storage_path('app/public/uploads/gateways/');
                $image_name = $micro.$image_obj->getClientOriginalName();
                $public_path = 'storage/uploads/gateways/';
                Image::make($image_obj)->save($orpath.'/'.$image_name);
                $gateway->image_path = $public_path;
                $gateway->image_name = $image_name;
            }
    
          
            $gateway->name = $request->name;
            $gateway->code =  getTrx(5);
     
            $gateway->description = $request->g_details;
        
            $gateway->status = $request->gateway_status;
           
            $gateway->save();
    
            notify()->success('Created Successfull');
           return redirect()->route('gateways');
             }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
          
        } 
    
    
        public function edit_gateway(){
            $gsd = global_user_data();
             if (Auth::id() == 1 || permission_checker($gsd->role_info,'gateway_manage') == 1){
            
            return view('Admin.gateway.gateways',compact('gsd'));
        } }
        public function upadate_gateway(){
            $gsd = global_user_data();
             if (Auth::id() == 1 || permission_checker($gsd->role_info,'gateway_manage') == 1){
            
            return view('Admin.gateway.gateways',compact('gsd'));
             }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
        } 
        public function remove_gateway(Request $request){
            $gsd = global_user_data();
             if (Auth::id() == 1 || permission_checker($gsd->role_info,'gateway_manage') == 1){
            Gateway::destroy($request->id);
            notify()->success('Remove Successfull');
            return back();
             }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
        }
        
}
