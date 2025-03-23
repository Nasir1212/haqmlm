<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\UnilevelTree;
use App\Models\Transaction;
use App\Models\UserExtra;
use App\Models\WorkingGenCondition;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\UserChild;
use App\Models\MatrixLevel;
use App\Services\UserTreeService;
use App\Models\CompanyAccount;
use App\Models\DirectBonusTransaction;
use Illuminate\Support\Facades\Auth;
use App\Models\SpbTransaction;
use App\Models\WgbTransaction;
use App\Models\ReferBonusTransaction;
use App\Models\NwmtgTransaction;
use App\Models\NwmtbTransaction;
use App\Models\RankCondition;
use App\Models\MatrixGenTree;
use App\Models\CustomerRankCondition;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\PointSaleHistory;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;
use App\Models\ProductOwner;
use App\Models\ProductStock;
use App\Models\Product;

class CronController extends Controller
{
    
      protected $userTreeService;

    public function __construct(UserTreeService $userTreeService)
    {
        $this->userTreeService = $userTreeService;
    }
    
      public function gen_debug(Request $request){
    
       
      }
    
    
    
    
    
    public function team_point_check(Request $request){
        $now = Carbon::now();
       
        $user = User::where('username',$request->username)->with('child')->first();
dd($user);
    //  $child_users = User::whereIn('id',json_decode($user->child->downline_total_user))->whereYear('point_submit_date',$now->year)->whereMonth('point_submit_date',$now->month)->sum('submitted_point');
        $child_users = User::whereIn('id',json_decode($user->child->downline_total_user))->whereYear('point_submit_date',$now->year)->whereMonth('point_submit_date',$now->month)->get();
        
    dd($child_users);
    }
    
    
    
    
    
    
    
private function gen_check($user_id)
{
    try {
        // Fetch children for generation 1 and 2 in a single query
        $children = UnilevelTree::where('parent_id', $user_id)
            ->whereIn('generation', [1, 2])
            ->get(['child_id', 'generation']);

        // Separate the children into generation 1 and generation 2
        $fsg_ids = $children->where('generation', 1)->pluck('child_id');
        $ssg_ids = $children->where('generation', 2)->pluck('child_id');

        // Fetch the users with active matrix status in a single query
        $fsg_pm_count = User::whereIn('id', $fsg_ids)->where('matrix_activation_status', 1)->count();
        $ssg_pm_count = User::whereIn('id', $ssg_ids)->where('matrix_activation_status', 1)->count();

        return [$fsg_pm_count, $ssg_pm_count];
    } catch (\Exception $e) {
        // Log the exception or handle it as required
        Log::error('Error in gen_check: ' . $e->getMessage());
        return [0, 0]; // Return a default value or handle error as needed
    }
}

private function leader_gen_check($user_id, $rank, $way)
{
    try {
        // Fetch children based on the generation
        $generations = ($way == 1) ? [1] : [1, 2];
        $children = UnilevelTree::where('parent_id', $user_id)
            ->whereIn('generation', $generations)
            ->get(['child_id', 'generation']);

        // Separate the children into generations
        $fsg_ids = $children->where('generation', 1)->pluck('child_id');
        $ssg_ids = ($way == 2) ? $children->where('generation', 2)->pluck('child_id') : collect();

        // Fetch the users with the specified leader rank in a single query
        $fsg_pm_count = User::whereIn('id', $fsg_ids)->where('leader_rank', $rank)->count();
        $ssg_pm_count = ($way == 2) ? User::whereIn('id', $ssg_ids)->where('leader_rank', $rank)->count() : 0;

        return ($way == 1) ? $fsg_pm_count : [$fsg_pm_count, $ssg_pm_count];
    } catch (\Exception $e) {
        // Log the exception or handle it as required
        Log::error('Error in leader_gen_check: ' . $e->getMessage());
        return ($way == 1) ? 0 : [0, 0]; // Return a default value or handle error as needed
    }
}

public function leader_rank_update()
{
    try {
        $users = User::all();
        $conditions = RankCondition::all();

        foreach ($users as $user) {
            $store_gen = $this->gen_check($user->id);

            if (is_null($user->leader_rank) || $user->leader_rank == '') {
                $cm = array_sum($store_gen);
                if ($conditions[0]->down_check <= $cm) {
                    $user->leader_rank = $conditions[0]->rank_name;
                    $user->save();
                }
            } else {
                $withoutFirstRow = $conditions->skip(1);
                foreach ($withoutFirstRow as $cond) {
                    $lcm = $this->leader_gen_check($user->id, $cond->prev_rank, 1);
                    if ($lcm >= $cond->down_check) {
                        $user->leader_rank = $cond->rank_name;
                        $user->save();
                        break; // Save and break if condition is met to avoid unnecessary checks
                    }
                }
            }
        }

        echo "ok";
    } catch (\Exception $e) {
        // Log the exception or handle it as required
        Log::error('Error in leader_rank_update: ' . $e->getMessage());
        echo "error";
    }
}

    
    
    
    
    
    
    
    
    
    
    
    
    
    public function customer_rank_update(){
        $ran_conds = CustomerRankCondition::all();
        $users = User::all();
        
        foreach($users as $user){
            foreach($ran_conds as $ran_cond){
                if($user->total_submitted_point >= $ran_cond->target_point){
                    $user->customer_rank = $ran_cond->rank_name;
                  
                }
            }
            $user->save();
        }
        
        echo "ok";
    }

public function finally_sms_send(Request $request){
  
      
}







public function sms_send_before_review(Request $request){
     if (Auth::id() == 1){
    
    $chcu = [];
    $users = User::where('submitted_point','>=',400)->get();
      $now = Carbon::now();
     
    foreach($users as $user){
            $DirectBonusTransaction = DirectBonusTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
            $ReferBonusTransaction = ReferBonusTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
            $NwmtbTransaction = NwmtbTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
            $NwmtgTransaction = NwmtgTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
            $WgbTransaction = WgbTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
            
            
            $net_amount =  $DirectBonusTransaction + $ReferBonusTransaction + $WgbTransaction + $NwmtbTransaction +  $NwmtgTransaction;
            $m_m = $net_amount / 0.90;
            $charge = $m_m - $net_amount;
             if($net_amount > 0){
            $msg =  "HMS Affiliate Bonus for (".$request->month_year.")- ".$net_amount."TK, Charge deducted ".$charge."TK, New Balance ".$user->balance."TK (".$user->username.") \n Haqmultishop.com \n Digital Affiliate System";
           $chcu[] = ['to'=>$user->phone,'message'=>$msg];
             }
            
                    
    }
   

      echo "<pre>";
      print_r($chcu);
      
    }else{
       notify()->error('Permission Not Allow !');
           return back();
    }
      
}






public function msgCaller(Request $request){
    $url = 'http://'.$request->web_url;
    $data = [
        "api_key" => $request->api,
        "senderid" => $request->app_id,
        "number" => $request->client_number,
        "message" => $request->message,
       
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
          
}



public function autom(Request $request){


 $user = UserExtra::where('id',1)->first();
 $uls = UserExtra::where('pos_id', $user->id)->where('position',1)->first();
 $ums = UserExtra::where('pos_id', $user->id)->where('position',2)->first();
 $urs = UserExtra::where('pos_id', $user->id)->where('position',3)->first();
 if($uls){
        $left_store_users =  userSc($uls->id);
        $left_store_users = getThingTo($left_store_users);
        array_unshift($left_store_users, $uls->id);
 }

 if($ums){
        $middle_store_users =  userSc($ums->id);
        $middle_store_users = getThingTo($middle_store_users);
        array_unshift($middle_store_users, $ums->id);
}

if($urs){
    $right_store_users =  userSc($urs->id);
    $right_store_users = getThingTo($right_store_users);
    array_unshift($right_store_users, $urs->id);
}

$treechild = collection::make([count($left_store_users),count($middle_store_users),count($right_store_users)])->sort()->flatten()->toArray();


}
   
  public function RankUpdate(){
        $users = User::all();
        $rf_starter = RankCondition::where('lock_status',1)->first();
        $rf_running = RankCondition::where('lock_status',0)->get();
        foreach ($users as $key => $user) {
           $second_gen_downs = [];
           $first_gen_downs = User::where('ref_id', $user->id)->get('id');
           if ($first_gen_downs) {
            foreach ($first_gen_downs as $key => $value) {
                $second_gens = User::where('ref_id', $value->id)->get('id');
                if($second_gens){
                    foreach ($second_gens as $key => $second_gen) {
                        $second_gen_downs[] = $second_gen->id;
                    }
                }
                
             }
            
           }

           if(count($first_gen_downs) >= $rf_starter->down_check){
            $user->user_rank = $rf_starter->rank_name;
            $user->save();
           }else{
            if (count($first_gen_downs) >= $rf_starter->first_check && count($second_gen_downs) >= $rf_starter->second_check) {
                $user->user_rank = $rf_starter->rank_name;
                $user->save();
            }
           }
        }

        
        function new_rank($prev,$cond,$next){
            $users = User::all('id');
            foreach ($users as $key => $user) {
                $down = User::where('ref_id', $user->id)->where('user_rank',$prev)->get(['user_rank','id','ref_id']);
                if(count($down) >= $cond){
                    $user->user_rank = $next;
                    $user->save();
                }
            }
        }
        
        foreach($rf_running as $data){
             new_rank($data->prev_rank,$data->down_check,$data->rank_name);
        }
    }
   

    public function boot_registerr(Request $request)
    {
 
        NewTreeMake();
        echo "okkook";
    }
    

    public function generation_check(Request $request){
       
        $user = User::where('id',5)->first(['id','username']);
        $args = [[$user->id,$user->username]];
        $gen = 1;
        $i = 0;
        function gensQ($prev){
            $ngen = [];
            foreach ($prev as $key => $value) {
               $gens = User::where('ref_id', $value[0])->get(['id','username']);
               if ($gens) {
                 foreach ($gens as $key => $gen) {
                    $ngen[] = [$gen->id,$gen->username];
                  }
               }
            }
           
            return $ngen;
        }

        while ($args) {
            $i++;
           $gdata = gensQ($args);
            if($gen == $i){
                break;
            }
            $args = $gdata;
        }

        dd($gdata);
        
     }

    


}
