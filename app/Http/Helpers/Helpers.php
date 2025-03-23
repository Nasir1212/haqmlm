<?php

use App\Models\Cart;
use App\Models\CompanyAccount;
use App\Models\DirectBonusTransaction;
use App\Models\MatrixLevel;
use App\Models\NonWorkingGenCondition;
use App\Models\NonWorkingMatrixCondition;
use App\Models\NwmtbTransaction;
use App\Models\NwmtgTransaction;
use App\Models\OutPointHistory;
use App\Models\RankBonusTransaction;
use App\Models\ReferBonusTransaction;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\UnilevelTree;
use App\Models\User;
use App\Models\UserChild;
use App\Models\UserExtra;
use App\Models\WgbTransaction;
use App\Models\SpbTransaction;
use App\Models\WishList;
use App\Models\Dealer;
use App\Models\DealerSelection;
use App\Models\WorkingGenCondition;

use App\Models\SponsorGenCondition;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

function calculateDiscountedValue($value, $percentage) {
    $discount = ($value * $percentage) / 100;
    return $value - $discount;
}
function formatAmount($amount) {
    return fmod($amount, 1) == 0 ? floor($amount) : number_format($amount, 2);
}
function dealer_check()
{
    $gsd = global_user_data();
    $dealer = Dealer::where("user_id", $gsd->id)->where('status', "Active")->exists();
    if ($dealer) {
        return 1;
    } else {
        return 0;
    }
}

function current_select_dealer()
{
   if(Auth::check()){
       $gsd = global_user_data();
        $selected_dealer = DealerSelection::where('user_id', $gsd->id)->with('dealer')->first();
        
        if ($selected_dealer) {
           
            $rs = "<p>".$selected_dealer->dealer->name ." -  " .$selected_dealer->dealer->full_address ." - " .$selected_dealer->dealer->phone ."</p>";
            return $rs;
        } else {
            return '';
        }
        }else{
            return '';
    }
        
    }

 function fileDelete($image_path){
        if (file_exists($image_path)) {
            @unlink($image_path);
        }
  }

  function folderCreate($path){
    if(!file_exists($path)){
    mkdir($path, 0777);
  }}

function usermatrix_up_down_check($id, $user_name){
    $user = UserExtra::where('user_id', $id)->first();
    if(!$user) return false;
    
    for($i = 1; $i <= 3; $i++){
        $pos = getPositionDown($user->id, $i, $user_name);
        if($pos == 'match' || optional(UserExtra::find($pos['pos_id']))->username == $user_name){
            return true;
        }
    }
    
    return false;

}
function parent_username($id){
    $UserExtra = UserExtra::where('user_id',$id)->with('user')->first();
       return $UserExtra->user->username;
   }
   
   
function admin_trx_pin(){
    return User::where('id', 1)->first(['trx_password'])->trx_password;
} 

function cart_counter(){
    $check_auth_id = session('check_auth_id');
    return Cart::where('user_id', $check_auth_id)->count();
} 
function wishlist_counter(){
    $check_auth_id = session('check_auth_id');
    return WishList::where('user_id', $check_auth_id)->count();
} 

function global_user_data(){
   if(Auth::id() == 1){
    return User::where('id', 1)->with('role_info')->first();
   }else{
    $check_auth_id = session('check_auth_id');
    return User::where('id', $check_auth_id)->with('role_info')->first();
   }
}


function setting(){
    return Setting::where('id',1)->first();
}

function out_bonus($amount){
    $CompanyAccount = CompanyAccount::where('id',1)->first();
    $CompanyAccount->out_point += $amount;
    $CompanyAccount->save();
}

function out_bonus_history($id,$amount,$mark,$details=''){
    $out_point = new OutPointHistory();
    $out_point->user_id = $id;
    $out_point->mark = $mark;
    $out_point->details = $details;
    $out_point->amount = $amount;
    $out_point->save();
}

function permission_checker($Role_info,$data){
    if(Auth::id() == 1){
        return 1;
    }else{
        $modules = $Role_info->access_module;
        $mdarray = json_decode($modules);
    
        if(in_array($data,$mdarray)){
                return 1;
            }else{
                return 0;
            }
        }
   
    }


function slug($string)
{
    return Illuminate\Support\Str::slug($string);
}
function diffForHumans($date)
{
    $lang = session()->get('lang');
    Carbon::setlocale($lang);
    return Carbon::parse($date)->diffForHumans();
}

function showDateTime($date, $format = 'd M, Y h:i A')
{
    $lang = session()->get('lang');
    Carbon::setlocale($lang);
    return Carbon::parse($date)->translatedFormat($format);
}


function shortDescription($string, $length = 120)
{
    return Illuminate\Support\Str::limit($string, $length);
}


function removeFile($path)
{
    return file_exists($path) && is_file($path) ? @unlink($path) : false;
}


function makeDirectory($path)
{
    if (file_exists($path)) return true;
    return mkdir($path, 0755, true);
}

function getTrx($length = 12)
{
    $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function trxCreate($amount,$prev_amount,$post_amount,$uid,$remark,$details,$trx_type,$trx,$tb='M'){
    if($trx == 'N'){
        $trx = getTrx();
    }
    if($tb == 'M'){
        $transaction = new Transaction();
        $transaction->amount = $amount;
        $transaction->trx = $trx;
        $transaction->user_id = $uid;
        $transaction->trx_type = $trx_type;
        $transaction->prev_balance = $prev_amount;
        $transaction->post_balance = $post_amount;
        $transaction->details = $details;
        $transaction->remark = $remark;
    
        $transaction->save();
    }

    if ($tb == 'NWMBT') {
        $transaction = new NwmtbTransaction();
        $transaction->amount = $amount;
        $transaction->trx = $trx;
        $transaction->user_id = $uid;
        $transaction->trx_type = $trx_type;
        $transaction->prev_balance = $prev_amount;
        $transaction->post_balance = $post_amount;
        $transaction->details = $details;
        $transaction->remark = $remark;
    
        $transaction->save();
    }

    if ($tb == 'NWMGT') {
        $transaction = new NwmtgTransaction();
        $transaction->amount = $amount;
        $transaction->trx = $trx;
        $transaction->user_id = $uid;
        $transaction->trx_type = $trx_type;
        $transaction->prev_balance = $prev_amount;
        $transaction->post_balance = $post_amount;
        $transaction->details = $details;
        $transaction->remark = $remark;
    
        $transaction->save();
    }

    if ($tb == 'RFBT') {
        $transaction = new ReferBonusTransaction();
        $transaction->amount = $amount;
        $transaction->trx = $trx;
        $transaction->user_id = $uid;
        $transaction->trx_type = $trx_type;
        $transaction->prev_balance = $prev_amount;
        $transaction->post_balance = $post_amount;
        $transaction->details = $details;
        $transaction->remark = $remark;
    
        $transaction->save();
    }

    if ($tb == 'DBT') {
        $transaction = new DirectBonusTransaction();
        $transaction->amount = $amount;
        $transaction->trx = $trx;
        $transaction->user_id = $uid;
        $transaction->trx_type = $trx_type;
        $transaction->prev_balance = $prev_amount;
        $transaction->post_balance = $post_amount;
        $transaction->details = $details;
        $transaction->remark = $remark;
    
        $transaction->save();
    }


    if ($tb == 'RKBT') {
        $transaction = new RankBonusTransaction();
        $transaction->amount = $amount;
        $transaction->trx = $trx;
        $transaction->user_id = $uid;
        $transaction->trx_type = $trx_type;
        $transaction->prev_balance = $prev_amount;
        $transaction->post_balance = $post_amount;
        $transaction->details = $details;
        $transaction->remark = $remark;
    
        $transaction->save();
    }

if ($tb == 'WGBT') {
        $transaction = new WgbTransaction();
        $transaction->amount = $amount;
        $transaction->trx = $trx;
        $transaction->user_id = $uid;
        $transaction->trx_type = $trx_type;
        $transaction->prev_balance = $prev_amount;
        $transaction->post_balance = $post_amount;
        $transaction->details = $details;
        $transaction->remark = $remark;
    
        $transaction->save();
    }
    
    
     if ($tb == 'SPBT') {
        $transaction = new SpbTransaction();
        $transaction->amount = $amount;
        $transaction->trx = $trx;
        $transaction->user_id = $uid;
        $transaction->trx_type = $trx_type;
        $transaction->prev_balance = $prev_amount;
        $transaction->post_balance = $post_amount;
        $transaction->details = $details;
        $transaction->remark = $remark;
    
        $transaction->save();
    }
    
    

}

function getAmount($amount, $length = 0)
{
    if(0 < $length){
        return round($amount + 0, $length);
    }
    return $amount + 0;
}
function getTreeChild($parentid, $position)
{
    $cou = UserExtra::where('pos_id', $parentid)->where('position', $position)->count();
    $cid = UserExtra::where('pos_id', $parentid)->where('position', $position)->with('user')->first();
    if ($cou > 0)
    {
        return $cid;
    }
    else
    {
       return 'Not Found';
    }
}


// get user tree child id
function getTreeChildId($parentid, $position)
{
    $cou = UserExtra::where('pos_id', $parentid)->where('position', $position)->count();
    $cid = UserExtra::where('pos_id', $parentid)->where('position', $position)->first();
    if ($cou == 1)
    {
        return $cid->user_id;
    }
    else
    {
        return -1;
    }
}

function getTreeChildIdDown($parentid, $position, $check_username)
{
    $userExtra = UserExtra::where('pos_id', $parentid)->where('position', $position)->first();
    if ($userExtra && $userExtra->user_name == $check_username) {
        return 'match';
    }
    return $userExtra ? $userExtra->user_id : -1;
}


// check user exist

function isUserExists($id)
{
    $user = User::find($id);
    if ($user)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function isMatrixUserExists($id)
{
    
    $user =  UserExtra::where('user_id',$id)->first();
    if ($user)
    {
        return true;
    }
    else
    {
        return false;
    }
}


function isMatrixUserExtraIdExists($id,$first)
{

     if($first == 0){
         $user = UserExtra::where('user_id',$id)->first();
        }else{
        $user = UserExtra::where('id',$id)->first(); 
     }
    
    if ($user)
    {
        return true;
    }
    else
    {
        return false;
    }
}

// find out position id
function getPositionId($id)
{
    $user = UserExtra::where('user_id',$id)->first();
    
    if ($user)
    {
        return $user->pos_id;
    }
    else
    {
        return 0;
    }
}

function getPositionExtraId($id,$first)
{
    if($first == 0){
         $user = UserExtra::where('user_id',$id)->first();
       
    }else{
        $user = UserExtra::where('id',$id)->first(); 
      
    }
   
    if ($user)
    {
        return $user->pos_id;
    }else
    {
        return 0;
    }
}



// find out position location
function getPositionLocation($id)
{
    $user =  UserExtra::where('user_id',$id)->first();
    if ($user)
    {
        return $user->position;
    }
    else
    {
        return 0;
    }
}



// find out user position
function getPositionUser($id, $position)
{
    return UserExtra::where('pos_id', $id)->where('position', $position)->first();
}



// findout position
function getPosition($parentid, $position)
{
    $childid = getTreeChildId($parentid, $position);

    if ($childid != "-1")
    {
        $id = $childid;
    }
    else
    {
        $id = $parentid;
    }
    while ($id != "" || $id != "0")
    {
        if (isMatrixUserExists($id))
        {
            $nextchildid = getTreeChildId($id, $position);
            if ($nextchildid == "-1")
            {
                break;
            }
            else
            {
                $id = $nextchildid;
            }
        }
        else break;
    }

    $res['pos_id'] = $id;
    $res['position'] = $position;
    return $res;
}

function getPositionDown($parentid, $position, $check_username)
{
    $childid = getTreeChildIdDown($parentid, $position,$check_username);

    if($childid == 'match'){
        return 'match';
    }


    if ($childid != "-1")
    {
        $id = $childid;
    }
    else
    {
        $id = $parentid;
    }
    while ($id != "" || $id != "0")
    {
        if (isMatrixUserExists($id))
        {
            $nextchildid = getTreeChildIdDown($id, $position, $check_username);
            if($nextchildid == 'match'){
                return 'match';
            }

            if ($nextchildid == "-1")
            {
                break;
            }
            else
            {
                $id = $nextchildid;
            }
        }
        else break;
    }

    $res['pos_id'] = $id;
    return $res;
}




// update free account test success 

function updatePaidCount($id)
{
    while ($id != "" || $id != "0") {
        if (isUserExists($id)) {
            $posid = getPositionId($id);
            if ($posid == "0" || $posid == 0) {
                break;
            }
            $position = getPositionLocation($id);
            $extra = UserExtra::where('user_id', $posid)->first();

            if ($position == 1) {
                $extra->left += 1;
            }
           
            if($position == 2) {
                $extra->middle += 1;
            }

            if($position == 3) {
                $extra->right += 1;
            }
            
            $extra->save();
            $id = $posid;
        } else {
            break;
            
        }
    }

}



function updatePaidCountCut($id)
{
    while ($id != "" || $id != "0") {
        if (isUserExists($id)) {
            $posid = getPositionId($id);
            if ($posid == "0" || $posid == 0) {
                break;
            }
            $position = getPositionLocation($id);
            $extra = UserExtra::where('user_id', $posid)->first();

            if ($position == 1) {
                $extra->left -= 1;
            }
           
            if($position == 2) {
                $extra->middle -= 1;
            }

            if($position == 3) {
                $extra->right -= 1;
            }
            $extra->save();
            $id = $posid;
        } else {
            break;
            
        }
    }

}


function matrix_serial_bonus($id){
    
      $target_user = UserExtra::where('user_id',$id)->first();
      if($target_user){
          $topc = $target_user->id;
          $start = 0;
          $uu = [];
          $setting = setting();
            $gnnc = NonWorkingGenCondition::where('id',1)->first();
            $limit = $gnnc->limit;
          
            while( $topc > 1){
                $topc--;
                 
                $find_user = UserExtra::where('id', $topc)->first();
                
                if($find_user){
                    $user = User::find($find_user->user_id);
                    if($user->submit_check == 1){
                        $prevpoint = $user->balance;
                        $amount = $gnnc->amount / 100 * $setting->income_charge;
                        $namount = $gnnc->amount - $amount;
                        $user->balance += $namount;
                        $user->total_income += $namount;
                        $user->save();
                       // out_bonus($amount);
                        $level = $start+1;
                        out_bonus_history($user->id,$amount,'non_working_gen_bonus','Get Level '.$level.' Bonus Get From user - '.$target_user->username);

                   
                        trxCreate($namount,$prevpoint,$user->balance,$find_user->user_id,'non_working_gen_bonus','Get Level '.$level.' Bonus Get From user - '.$target_user->user_name,'+','N','NWMGT');
                    
                       $start++;
                    }
                    
                }
                
                if($start == $limit){
                    break;
                }
                
            }
      }
      
}


function matrix_gen_bonus($id,$limit,$rootId){
    $setting = setting();
    $root = User::where('id',$rootId)->first('username');
    $user = User::find($id);
    $gnnc = NonWorkingGenCondition::where('id',1)->first();
    if($user->submit_check == 1){
        $prevpoint = $user->balance;
        $amount = $gnnc->amount / 100 * $setting->income_charge;
        $namount = $gnnc->amount - $amount;
        $user->balance += $namount;
        $user->total_income += $namount;
        $user->save();
       // out_bonus($amount);
        $level = $limit+1;
        out_bonus_history($user->id,$amount,'non_working_gen_bonus','Get Level '.$level.' Bonus Get From user - '.$root->username);

        
        trxCreate($namount,$prevpoint,$user->balance,$id,'non_working_gen_bonus','Get Level '.$level.' Bonus Get From user - '.$root->username,'+','N','NWMGT');
    }
}






function matrix_gen($id, $limit = 0)
{
    $flp = 0;
    $rootId = $id;
    $start = 0;

    while ($id != "" || $id != "0") {
        if (isMatrixUserExtraIdExists($id,$flp)) {
         
            
            $posid = getPositionExtraId($id, $flp);
            if ($posid == "0" || $posid == 0) {
                break;
            }
           
        if($flp == 0){
               $extra = UserExtra::where('user_id', $posid)->first();
           }else{
              $extra = UserExtra::where('id', $posid)->first(); 
           }
            matrix_gen_bonus($extra->user_id,$start,$rootId);

            $start++;
            if($limit == $start){
                break;
            }else{
                $id = $posid;
                 $flp++;
            }
            
        } else {
            break;
            
        }
    }

}

function matrix_gen_income($id,$cond,$pos,$rootId){

    $setting = setting();
    $root = User::where('id',$rootId)->first();
    $amount = $root->submitted_point / 100 * $cond[$pos]->amount;
    $amount -= $amount / 100 * $setting->income_charge;
    $user = User::find($id);
    
    if($user->submit_check == 1){ 
        $prevpoint = $user->balance;
        $user->balance += $amount;
        $user->total_income += $amount;
        // $user->save();
        // out_bonus_history($user->id,$amount,'non_working_matrix','Bonus Get From level '.$cond[$pos]->level.' user - '.$root->username);
        // trxCreate($amount,$prevpoint,$user->balance,$id,'non_working_matrix','Bonus Get From level '.$cond[$pos]->level.' user - '.$root->username,'+','N','NWMBT');
    
    }
    
}

// out_bonus($amount);
function get_matrix_gen_income($root_id, $down_id,$gen,$conds){
$setting = setting();
$root_user = User::where('id',$root_id)->first();
$down_user = User::where('id',$down_id)->first();
if($down_user->submitted_point > 0  && $down_user->distribute_status ==1 && $root_user->submit_check == 1 ){
$amount = $down_user->submitted_point / 100 * $conds[$gen-1]->amount;
$amount -= $amount / 100 * $setting->income_charge;
$prevpoint = $root_user->balance;
$root_user->balance += $amount;
$root_user->total_income += $amount;
$root_user->save();
out_bonus_history($root_user->id,$amount,'non_working_matrix','Bonus Get From level '.$conds[$gen-1]->level.' user - '.$down_user->username);
trxCreate($amount,$prevpoint,$root_user->balance,$root_id,'non_working_matrix','Bonus Get From level '.$conds[$gen-1]->level.' user - '.$down_user->username,'+','N','NWMBT');

// echo "$root_id non_working_matrix from $down_user->username as Generation $gen and amount is $amount and point is $down_user->submitted_point";
}
}



function matrix_income($id)
{   $limit = NonWorkingMatrixCondition::all();
    $matrix_evel =   MatrixLevel::where('user_id',$id)->first();
   for($i = 1; $i<=count($limit);$i++){
       $level = json_decode($matrix_evel->{"lv_$i"},true );
    if(empty($level)) break;
    for($k = 0; $k < count($level); $k++){
    get_matrix_gen_income($id,$level[$k],$i ,$limit);// (Root User, DownUser, Generation,condition)
    }
   }

}


// function matrix_income($id)
// {
//     $flp = 0;
//     $start = 0;
//     $rootId = $id;
//     $limit = NonWorkingMatrixCondition::all();
    

   
//     while ($id != "" || $id != "0") {
     
//          if (isMatrixUserExtraIdExists($id,$flp)) {
  
             
//             $posid = getPositionExtraId($id, $flp);
         
//             if ($posid == "0" || $posid == 0) {
//                 break;
//             }
           
//            if($flp == 0){
//                $extra = UserExtra::where('user_id', $posid)->first();
//            }else{
//               $extra = UserExtra::where('id', $posid)->first(); 
//            }
           
          
           
//             matrix_gen_income($extra->user_id, $limit, $start,$rootId);

//             $start++;
//             if(count($limit) == $start){
//                 break;
//             }else{
//                 $id = $posid;
//                 $flp++;
                
//             }
            
//         } else {
//             break;
            
//         }
//     }

// }



function parentChecker($id, $checker_id)
{
    while ($id != "" || $id != "0") {
        if (isUserExists($id)) {
            $posid = getPositionId($id);
            if ($posid == "0" || $posid == 0) {
                break;
            }
            $position = getPositionLocation($id);
            $extra = UserExtra::where('user_id', $posid)->first();
            if($extra->user_id == $checker_id){
                return 1; 
            }
            
            $id = $posid;
        } else {
            break;
            
        }
    }

}



// carry  balance update debug success 


function referralComission($user_id)
{
    $setting = setting();
    $user = User::find($user_id);
     if (!$user) {
        // Handle the case where the user doesn't exist
        return false;
    }
    
    $refer = User::where('id',$user->ref_id)->where('lock_status', 0)->first();
    if ($refer) {
      
            $amount =  $setting->refer_com;
            $prev_balance = $refer->balance;
            $amount = $setting->refer_com / 100 * $setting->income_charge;
            $trxm = $setting->refer_com - $amount;
            $refer->balance += $trxm;
            $refer->total_income += $trxm;
            $refer->save();
            out_bonus_history($refer->id,$trxm,'refer_bonus','Refer From - '.$user->name);
          //  out_bonus($trxm);
            trxCreate($trxm,$prev_balance,$refer->balance,$refer->id,'refer_bonus','Refer From - '.$user->name,'+','N','RFBT');
    }
    
    return false;
}


 function getDownlineUsers($userId, &$downlineUsers = [])
{
    $users = User::where('ref_id', $userId)->get();
    foreach ($users as $user) {
        if($user->distribute_status == 1){
            
            $downlineUsers[] = ['user_id'=>$user->id,'user_name'=>$user->username,'ref_id'=>$user->ref_id];
        //     echo "<pre>";
        //   print_r( getValidGenerations($user->id));
        //   echo "<pre/>";
        }
        getDownlineUsers($user->id, $downlineUsers); // Recursive call
    }
    return $downlineUsers;
}


function getValidDownlineByGeneration($userId, $generation = 1, &$generations = [], $maxGen =0 ) {
    if($generation > $maxGen){
        return $generations; 
    }
    // Get direct referrals
    $directRefs = User::where('ref_id', $userId)->get();

    if ($directRefs->isEmpty()) {
        return $generations; // Stop if no more users in downline
    }

    foreach ($directRefs as $user) {
        if ($user->distribute_status == 1) {
            $generations[$generation][] = ['id'=>$user->id,'username'=>$user->username,'submitted_point'=>$user->submitted_point]; // Add user to this generation
            getValidDownlineByGeneration($user->id, $generation + 1, $generations,$maxGen);
        } else {
            // If the user is skipped, get their next referrals instead
            getValidDownlineByGeneration($user->id, $generation, $generations,$maxGen);
        }
    }

    return $generations;
}


// function getRefIncomeInsert($root,$ref_id,$conds,$miss_count,$key,$point){
  
    
//     $root_user = User::where('id', $root)->first('username');
//     echo "<br/> $root_user <br/>";
//     $user = User::where('id', $ref_id)->first();


//     if ($user)
//     {
//         if($user->invest_status == 0 || $user->income_strike == 1){
//             $miss_count +=1; 
//             echo "False is $user->ref_id , $miss_count";
//             return [$user->ref_id,$miss_count];
//         }else{
           
//             $setting = setting();
//             if($user->submit_check == 1){ 
//                 $prev_balance = $user->balance;
//                 $working_gen_amount = $point / 100 * $conds[$key]->amount;
//                 $working_gen_amount -= $working_gen_amount / 100 * $setting->income_charge;

//                 $user->balance += $working_gen_amount;
//                 $user->total_income += $working_gen_amount;
//                 $tremark = 'working_gen';
                
//                 $tdetails = "Get Working Generation from -- ".$root_user->username." -- and ";
//                 // $user->save();

//               //  out_bonus_history($user->id,$working_gen_amount,'working_gen',$tdetails);
//                     // //   out_bonus($working_gen_amount);
//                     echo "<br/>".$tdetails.$conds[$key]->level."<br/>";
//                // trxCreate($working_gen_amount,$prev_balance,$user->balance,$user->id,$tremark,$tdetails.$conds[$key]->level,'+','N',"WGBT");
//             }
//             // print_r([$user->ref_id,$miss_count]);
//             echo "User ID $user->ref_id and misscound $miss_count";
//             return [$user->ref_id,$miss_count];
//         }
       
           
//     }
//     else 
//     {
//         return [0,$miss_count];
//     }
// }

// function getRefIncomeInsert($root, $ref_id, $conds, $miss_count, $key, $point) {
    
//     $root_user = User::where('id', $root)->first('username');
//     $user = User::where('id', $ref_id)->first();

//     if ($user) {
//         // যদি ইউজার ইনভেস্ট না করে বা ব্লক থাকে, তাহলে সরাসরি তার রেফারার চেক করব
//         if ($user->invest_status == 0 || $user->income_strike == 1 || $user->submit_check == 0) {
//             $miss_count += 1; 
//             return getRefIncomeInsert($root, $user->ref_id, $conds, $miss_count, $key, $point);
//         }

//         // ইউজার কোয়ালিফাই হলে ইনকাম যোগ করব
//         $setting = setting();
//         $prev_balance = $user->balance;
//         $working_gen_amount = $point / 100 * $conds[$key]->amount;
//         $working_gen_amount -= $working_gen_amount / 100 * $setting->income_charge;

//         $user->balance += $working_gen_amount;
//         $user->total_income += $working_gen_amount;
//         $tremark = 'working_gen';
//         $tdetails = "Get Working Generation from -- " . $root_user->username . " -- ";
//         $user->save();

//         out_bonus_history($user->id, $working_gen_amount, 'working_gen', $tdetails);
//         trxCreate($working_gen_amount, $prev_balance, $user->balance, $user->id, $tremark, $tdetails . $conds[$key]->level, '+', 'N', "WGBT");

//         return [$user->ref_id, $miss_count];
//     } 

//     return [0, $miss_count];
// }



function working_generation_income_with_refer($root_user, $conds){
    
    $generations=[];

   
    $dd = getValidDownlineByGeneration($root_user->id,1,$generations,count($conds));
    $setting = setting();
    foreach($dd as $key=>$d){
      
        foreach($d as $t ){
           
            if($root_user->submit_check == 1){ 
                $prev_balance = $root_user->balance;
                $working_gen_amount = $t['submitted_point'] / 100 * $conds[$key-1]->amount;
                $working_gen_amount -= $working_gen_amount / 100 * $setting->income_charge;
            
                $root_user->balance += $working_gen_amount;
                $root_user->total_income += $working_gen_amount;
                $tremark = 'working_gen';
            
               // $tdetails = "Get Working Generation from -- ".$root_user->username." -- and ";
              //  $tdetails = "$root_user->username prev Blance  $prev_balance  Present blance is  ". $prev_balance+$working_gen_amount." Get Working Generation from -- ".$t['username']."  --  ".$conds[$key- 1]->level." Income is ".$working_gen_amount . " LSP  ".formatAmount($t['submitted_point'])." </br> ";
            
              $tdetails = " Get Working Generation from -- ".$t['username']."  --  ".$conds[$key- 1]->level."   LSP  ".formatAmount($t['submitted_point']);
          
             $root_user->save();
            out_bonus_history($root_user->id,$working_gen_amount,'working_gen',$tdetails);
            out_bonus($working_gen_amount);
            trxCreate($working_gen_amount,$prev_balance,$root_user->balance,$root_user->id,$tremark,$tdetails,'+','N',"WGBT");
            
            }
        }
    }
    
    
 
    // echo "<pre>";
    // print_r($conds[1-1]->level);
    // echo "</pre>";
        // $miss_count = 0;
        // $fire = 0;
        // $mv = 0;
    // while (count($conds) > 0) {
     
        // $mv = 0;
        // $refid = getRefIncomeInsert($root,$refer_id,$conds,$miss_count,$fire,$point);
      
// dd($refid);

        // if($refid[1] == 0){
        //     $fire++;            
        // }
        
        //     if ($refid[0] == 0) {
                
        //         break;
        //     }else{
        //         if($fire == count($conds)){
        //             if($refid[1] >= count($conds)){
        //                 break; 
        //             }else{
        //                 $fire = count($conds) - $refid[1];
        //                 $mv = 1;
        //             }
                    
        //         }

        //         $refer_id = $refid[0];
        //         if($mv == 1){
        //             $miss_count = 0;
        //         }else{
        //             $miss_count = $refid[1];
                   
        //         }
                
           // }

    //}
}



function getSponsorIncomeInsert($root,$ref_id,$conds,$miss_count,$key,$point){
    // dd($conds[$key]);
    
    $root_user = User::where('id', $root)->first('username');
    $user = User::where('id', $ref_id)->first();

    if ($user)
    {
        if($user->invest_status == 0 || $user->income_strike == 1){
            $miss_count +=1; 

            return [$user->sponsor_id,$miss_count];
        }else{
           
            $setting = setting();
            if($user->submit_check == 1){ 
                $prev_balance = $user->balance;
                $working_gen_amount = $point / 100 * $conds[$key]->amount;
                $working_gen_amount -= $working_gen_amount / 100 * $setting->income_charge;

                $user->balance += $working_gen_amount;
                $user->total_income += $working_gen_amount;
                $tremark = 'sponsor_gen';
                
                $tdetails = "Get Sponsor Generation from -- ".$root_user->username." -- and ";
                $user->save();

                out_bonus_history($user->id,$working_gen_amount,'sponsor_gen',$tdetails);
             //   out_bonus($working_gen_amount);
                trxCreate($working_gen_amount,$prev_balance,$user->balance,$user->id,$tremark,$tdetails.$conds[$key]->level,'+','N',"SPBT");
            }
            return [$user->sponsor_id,$miss_count];
        }
       
           
    }
    else 
    {
        return [0,$miss_count];
    }
}




function sponsor_generation_income_with_sponsor($root,$refer_id,$point){
    
        $conds =  SponsorGenCondition::all();
        $miss_count = 0;
        $fire = 0;
        $mv = 0;
    while (count($conds) > 0) {
        $mv = 0;
        $refid = getSponsorIncomeInsert($root,$refer_id,$conds,$miss_count,$fire,$point);
      


        if($refid[1] == 0){
            $fire++;            
        }
        
            if ($refid[0] == 0) {
                
                break;
            }else{
                if($fire == count($conds)){
                    if($refid[1] >= count($conds)){
                        break; 
                    }else{
                        $fire = count($conds) - $refid[1];
                        $mv = 1;
                    }
                    
                }

                $refer_id = $refid[0];
                if($mv == 1){
                    $miss_count = 0;
                }else{
                    $miss_count = $refid[1];
                   
                }
                
            }

    }
}















// rank bonus sender section end

function RgetAmount($amount, $length = 0)
{
    if(0 < $length){
        return round($amount + 0, $length);
    }
    return $amount + 0;
}

function parent_lv($id){
   $user = UserExtra::where('user_id',$id)->first();
   if($user){
     return  $user->root_level;
   }
}

function parent_cap_lv($lv)
{
    // Count the number of users with the specified root_level directly in the query
    $userCount = UserExtra::where('root_level', $lv)->count();

    // Return count plus one, defaulting to 1 if no users are found
    return $userCount > 0 ? $userCount + 1 : 1;
}



function autoMatrixGenerator($user){
    $user = User::where('id', $user)->first();
    if($user){
        if(!isMatrixUserExists($user->id)){
            $parent = UserExtra::where('fill_check',1)->latest('id')->first();
            if(!$parent){
                $parent = UserExtra::where('fill_check',2)->latest('id')->first();
                if (!$parent) {
                    $parent = UserExtra::where('fill_check',3)->latest('id')->first();
                    if($parent){
                        $parent = UserExtra::where('fill_check',0)->first();
                    }else {
                        $parent = UserExtra::where('fill_check',0)->first();
                    }
                }
            }

           $parent_lvc = parent_lv($parent->user_id);
           $my_lvc = $parent_lvc + 1;
          $ncp = parent_cap_lv($my_lvc);

            $userMatrix = new UserExtra();
            $userMatrix->user_id = $user->id;
            $userMatrix->user_name = $user->username;
            $userMatrix->pos_id = $parent->user_id;
            $userMatrix->root_level = $my_lvc;
            $userMatrix->level_cap = $ncp;
            $userMatrix->status = 1;
            if ($parent->fill_check == 0) {
                $userMatrix->position = 1;
            }
            if($parent->fill_check == 1) {
                $userMatrix->position = 2;
            }
            if($parent->fill_check == 2){
                $userMatrix->position = 3;
            }
            
            $userMatrix->save();
            $parent->fill_check +=1;
            $parent->save();
            
             $user->matrix_activation_status = 1;
             $user->invest_status = 1;
             $user->save();
             
            UpdateUplevel($user->id,$user->id);
            updatePaidCount($user->id);
            
            // $ca = CompanyAccount::where('id',1)->first();
            // $ca->point += $user->submitted_point;
            // $ca->save();

            
            // $user->distribute_status = 1;
            // $user->submit_check = 1;
            // $user->new_submited_point_status = 1;
            // $user->save();
            // updatePaidCount($user->id);
            // referralComission($user->id);
           // notify()->success('Matrix Joining Success');
        }
    }
}



function UplineFiller($user){
   $child = UserChild::where('user_id',$user->ref_id)->first();
   if($child){
       if($child->down_users == ''){
            $child->down_users = json_encode([$user->id]);
            $child->save();
       }else{
          $chd = json_decode($child->down_users);
          if(!in_array($user->id,$chd)){
              $chd[] = $user->id;
              $child->down_users = json_encode($chd);
              $child->save();
          }
       }
     
     
   }else{
       $child = new UserChild();
       $child->user_id = $user->ref_id;
       $child->down_users = json_encode([$user->id]);
       $child->save();
   }
   
   $ref = User::where('id', $user->ref_id)->first();
   if( $ref){
          UplineFiller($ref);
   }
}

function treefill($uid, $generation,$pid = 0) {
    // Create a new entry in the unilevel_trees table
    UnilevelTree::create([
        'parent_id' => $pid,
        'child_id' => $uid,
        'generation' => $generation,
    ]);

    // Find the parent user based on ID
    $parent = User::find($pid);

    // Check if the parent has a valid ref_id
    if ($parent && $parent->ref_id > 0) {
        // Recursively call treefill for the parent's referrer
        treefill($uid,  ($generation + 1),$parent->ref_id);
    }
}

function updateReferrer($userId,$fix) {
    $user = User::find($userId);
    if ($user->ref_id != 0) {
        $referringUser = User::find($user->ref_id);
        $userChild = UserChild::where('user_id', $referringUser->id)->first();
        if ($userChild) {
            $userDownline = json_decode($userChild->downline_total_user, true);
            if($userChild->downline_total_user == ''){
                $userDownline[] = $fix;
                $userChild->downline_total_user = json_encode($userDownline);
                $userChild->save();
            }else{
                 if (in_array($fix, $userDownline)) {
            
                }else{
                   $userDownline[] = $fix;
                   $userChild->downline_total_user = json_encode($userDownline);
                   $userChild->save();
                }
            }
           
        }
       
        updateReferrer($referringUser->id,$fix); // Recursively call for the referrer
    }
}

function matrixLCreate($id){
    $data = json_encode([]);
   $lv = new MatrixLevel();
   $lv->user_id = $id;
   $lv->lv_1 = $data;
   $lv->lv_2 = $data;
   $lv->lv_3 = $data;
   $lv->lv_4 = $data;
   $lv->lv_5 = $data;
   $lv->lv_6 = $data;
   $lv->lv_7 = $data;
   $lv->lv_8 = $data;
   $lv->lv_9 = $data;
   $lv->lv_10 = $data;
   $lv->lv_11 = $data;
   $lv->lv_12 = $data;
   $lv->lv_13 = $data;
   $lv->lv_14 = $data;
   $lv->lv_15 = $data;
   $lv->save();
 
}

function matrixLUpdate($id){
    $data = json_encode([]);
   $lv = MatrixLevel::where('user_id',$id)->first();
 
   $lv->user_id = $id;
   $lv->lv_1 = $data;
   $lv->lv_2 = $data;
   $lv->lv_3 = $data;
   $lv->lv_4 = $data;
   $lv->lv_5 = $data;
   $lv->lv_6 = $data;
   $lv->lv_7 = $data;
   $lv->lv_8 = $data;
   $lv->lv_9 = $data;
   $lv->lv_10 = $data;
   $lv->lv_11 = $data;
   $lv->lv_12 = $data;
   $lv->lv_13 = $data;
   $lv->lv_14 = $data;
   $lv->lv_15 = $data;
   $lv->save();
 
}


function UpdateUplevel($fix,$id)
{
    $limit = 15;
    $start = 1;
    while ($id != "" || $id != "0") {
        if (isUserExists($id)) {
            $posid = getPositionId($id);
            if ($posid == "0" || $posid == 0) {
                break;
            }
            
            $parent = MatrixLevel::where('user_id', $posid)->first();
            $lv = 'lv_'.$start;
            $data  = $parent->$lv;
            $data = json_decode($data, true);
            $data[] = $fix;
            $parent->$lv = json_encode($data);
            $parent->save();
            $id = $posid;
            $start++;
            if($start > $limit) {
                break;
            }
        } else {
            break;
            
        }
    }

}





function NewTreeMake(){
$setting = setting();
// Original array

 $level  = $setting->matrix_gen_check;
 $total_member = $setting->set_gen_member;

  $userIds = UserExtra::pluck('user_id');
  
   $userIdsArray = $userIds->toArray();

// $originalArray = ['ashik', 'rahul', 'sagor', 'rana', 'ranu', 'juyel', 'rafi', 'bokul','rakib'];
$originalArray = $userIdsArray;
// Elements to move to the end
// $elementsToMove = ['rahul', 'rana','ranu'];
$elementsToMove = [];
UserExtra::truncate();

$lv = "lv_".$level;

foreach ($originalArray as $key => $user) {
    $check_level = MatrixLevel::where('user_id', $user)->first();
    $data = json_decode($check_level->$lv);
   if(count($data) == $total_member){
     $elementsToMove[] = $user;
   }
    if( $user == 1){
        $u = User::find(1);
        $extra = new UserExtra();
        $extra->user_id = $user;
        $extra->fill_check = 0;
        $extra->root_level = 1;
        $extra->level_cap = 1;
        $extra->left = 0;
        $extra->middle = 0;
        $extra->right = 0;
        $extra->rank = 0;
        $extra->pos_id = 0;
        $extra->position = 0;
        $extra->parent_id = 0;
        $extra->user_name = $u->username;
        $extra->save();
      }
   matrixLUpdate($user);
}


// Separate the elements to move and the rest
$remainingElements = [];
$movingElements = [];

// Iterate through the original array
foreach ($originalArray as $element) {
    if (in_array($element, $elementsToMove)) {
        $movingElements[] = $element; // Collect elements to move
    } else {
        $remainingElements[] = $element; // Collect remaining elements
    }
}

// Merge the arrays: remaining elements followed by the elements to move
$rearrangedArray = array_merge($remainingElements, $movingElements);

processUsersInChunks($rearrangedArray);


}

function processUsersInChunks(array $users, $chunkSize = 100) {
    foreach (array_chunk($users, $chunkSize) as $userChunk) {
        foreach ($userChunk as $user) {
            if ($user != 1) {
                autoMatrixGenerator($user);
            }
        }
    }
}









function isDateMonthsOrMore($user, $months)
{
   $get_user = User::find($user);
    // Parse the submit_point_date using Carbon
    $submitDate = Carbon::parse($get_user->point_submit_date);

    // Get the current date
    $currentDate = Carbon::now();

    // Calculate the date from 'n' months ago (where 'n' is dynamic)
    $nMonthsAgo = $currentDate->copy()->subMonths($months)->startOfMonth();

    // Check if the submit_point_date is before 'n' months ago
    if ($submitDate->lessThan($nMonthsAgo)) {
        return true;
    }

    return false;
}
