<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CustomerRankCondition;
use App\Models\RankCondition;
use Illuminate\Http\Request;

class RankConditionController extends Controller
{
    public function customer_rank_conds(Request $request){
        $gsd = global_user_data();
       $rank_conditions = CustomerRankCondition::orderBy('target_point','asc')->get();
       return view('Admin.rank-condition.customer.index', compact('rank_conditions','gsd'));
    }

    public function customer_rank_cond_create(Request $request){
        $gsd = global_user_data();
   
        return view('Admin.rank-condition.customer.create', compact('gsd'));
    }
    public function customer_rank_cond_store(Request $request){
        $cond = new CustomerRankCondition();
        $cond->target_point = $request->target_point;
        $cond->rank_name = $request->rank_name;
        $cond->rank_price = $request->rank_price;
        $cond->save();
        notify()->success('Creating Success');
        return back();
    }
    public function customer_rank_cond_remove(Request $request){
        $rank_condition = CustomerRankCondition::find($request->id);
        $rank_condition->delete();
        notify()->success('remove Success');
        return back();
    }



    public function gen_rank_conds(Request $request){
        $gsd = global_user_data();
       $rank_conditions = RankCondition::orderBy('pos','asc')->get();
       return view('Admin.rank-condition.gen_rank.index', compact('rank_conditions','gsd'));
    }


public function gen_rank_cond_create(Request $request){
    $gsd = global_user_data();
    return view('Admin.rank-condition.gen_rank.create', compact('gsd'));
}
public function gen_rank_cond_store(Request $request){
   $cond = new RankCondition();
   $cond->rank_royality = $request->rank_royality;
   $cond->rank_name = $request->rank_name;
   $cond->prev_rank = $request->prev_rank;
   $cond->second_check = $request->second_check;
   $cond->first_check = $request->first_check;
   $cond->down_check = $request->down_check;
   $cond->lock_status = 0;
   $cond->pos = $request->pos;
   $cond->save();
   notify()->success('Creating Success');
   return back();
}
public function gen_rank_cond_edit(Request $request){
    $gsd = global_user_data();
    $cond = RankCondition::find($request->id);

    return view('Admin.rank-condition.gen_rank.edit', compact('cond','gsd'));
}
public function gen_rank_cond_update(Request $request){
    $cond = RankCondition::find($request->id);
    $cond->rank_royality = $request->rank_royality;
    $cond->rank_name = $request->rank_name;
    $cond->prev_rank = $request->prev_rank;
    $cond->second_check = $request->second_check;
    $cond->first_check = $request->first_check;
    $cond->down_check = $request->down_check;
    $cond->lock_status = 0;
    $cond->pos = $request->pos;
    $cond->save();
    notify()->success('update Success');
    return back();
}
public function gen_rank_cond_remove(Request $request){
    $cond = RankCondition::find($request->id);
    $cond->delete();
    notify()->success('remove Success');
    return back();
}










}
