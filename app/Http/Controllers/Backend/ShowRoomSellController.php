<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ShowRoomSellController extends Controller
{ 
    
    public function create_sell(){
        $gsd = global_user_data();
       $products =  Product::all();
       
        return view('Admin.show-room.sale.create',compact('gsd','products'));
    }
    
     public function sell_make(){
        
    }
    
}