<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CompanyReserveFund;
use App\Models\ClubMember;

class ClubController extends Controller
{
    public function index(){
        $gsd = global_user_data();
        $club_members = ClubMember::paginate(20);
        $fund = CompanyReserveFund::where('id',1)->first();
        
        $club_income_fund = $fund->club_income;
        return view('Admin.club.index', compact('club_income_fund','club_members','gsd'));
    }
     
  

    public function create(Request $request){
        $gsd = global_user_data();
        $user = User::where('username',$request->username)->first(); 
        if($user){
            $ClubMember = new ClubMember();
            $ClubMember->pos = $request->position;
            $ClubMember->username = $request->username;
            $ClubMember->status = $request->status;
            $ClubMember->save();

            notify()->success('Club Member Create Success !'); 
        }else{
             notify()->error('User Not Found!'); 
        }
      
        return back();
    }

    public function update(Request $request){

         $user = User::where('username',$request->username)->first(); 
        if($user){
        $ClubMember = ClubMember::where('id',$request->id)->first();
        $ClubMember->pos = $request->position;
        $ClubMember->username = $request->username;
        $ClubMember->status = $request->status;
        $ClubMember->save();

        notify()->success('Club Member Update Success !');
        }else{
             notify()->error('User Not Found!'); 
        }
        return back();
        
       }

       public function remove(Request $request){

        ClubMember::destroy('id',$request->id);
       
        notify()->success('Club Member Remove Success !');
        return back();

       }
       
       public function cmbs(Request $request){

        $c_members = ClubMember::all();
        $fund = CompanyReserveFund::where('id',1)->first();
        $club_income_fund = $fund->club_income;
        $total = count($c_members);
        $amount = 0;
        if($club_income_fund < 1){
             notify()->error('Sorry Club Fund Empty!');
        }else{
             if($total != 0){
            $amount = $club_income_fund / $total;
            foreach($c_members as $c_member){
                $c_member->club_balance += $amount;
                $c_member->save();
            }
                notify()->success('Successfully sending -- Total Member - '.$total.' per member amount - '.$amount.' Total Amount '.$club_income_fund);
            }else{
                notify()->error('Member Not Found !');
            }
        }
       
        
       
        
        return back();

       }
    
       
    
}
