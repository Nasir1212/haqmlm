<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\CompanyReserveFund;

class ReserveManageController extends Controller
{
    public function Index(){
        $gsd = global_user_data();
       $reserve = CompanyReserveFund::where('id',1)->first();

       return view('Admin.settings.reserve-fund', compact('reserve','gsd'));

    }

    public function update(Request $request){
        $reserve = CompanyReserveFund::where('id',1)->first();
        $reserve->royality_fund = $request->ryf;
        $reserve->club_income = $request->clb;
        $reserve->repurchase_perform_bonus = $request->rpb;
        $reserve->save();
        
        notify()->success('Reserve Update Success !');
        return back();
    }
}
