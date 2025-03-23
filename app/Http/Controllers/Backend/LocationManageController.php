<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BdLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class LocationManageController extends Controller
{
    public function index(){
         $gsd = global_user_data();
             if ($gsd->id == 1 || permission_checker($gsd->role_info,'location_manage') == 0){
        $locations = BdLocation::all();
        return view('Admin.location.index',compact('locations','gsd'));
             }
    }

    public function create(){
        $gsd = global_user_data();
        $divisions = BdLocation::where('division',1)->get();
        return view('Admin.location.create',compact('divisions','gsd'));
    }
    public function location_query(Request $request){
        $locations = BdLocation::where('parent_id',$request->location)->get();
        return response()->json($locations);
    }

    public function store(Request $request){
             $gsd = global_user_data();
             if ($gsd->id =! 1 || permission_checker($gsd->role_info,'location_manage') == 0){
        $BDLocation = new BdLocation();
        $BDLocation->e_name = $request->eng_name;
        $BDLocation->slug = $request->eng_name;
        $BDLocation->b_name = $request->bn_name;
        $BDLocation->division = $request->location_type == 'division' ? 1 : 0;
        $BDLocation->district = $request->location_type == 'district' ? 1 : 0;
        $BDLocation->upzila = $request->location_type == 'upzila' ? 1 : 0;
        $BDLocation->l_union = $request->location_type == 'l_union' ? 1 : 0;
    
 if($request->parent_id != ''){

 }
        $BDLocation->parent_id = $request->parent_id != '' ? $request->parent_id : null;
        $BDLocation->save();
   
        return back();
    }
    }
}
