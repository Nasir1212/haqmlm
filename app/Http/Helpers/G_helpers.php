<?php
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserExtra;
use App\Models\UserChild;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


function lvh($d){
    return $d * 3;
}
function lv($d,$l){
    $ck = 1;
    while($ck < $l){
       $d = lvh($d);
       $ck++;
      
    }
    return $d;
}




function fix_global_user_data(){
    return User::where('id',Auth::id())->with('role_info')->first();
}

function userSc($id){
            $inner = [];
            $users = UserExtra::where('pos_id', $id)->get();
            if($users){
              foreach($users as $user){
             
                $inner[] =  $user->id;
                $inner[] =  userSc($user->id);
                
              }
            }
            return $inner;
       }

    function single_user_finder($id){
        $user = User::where('id',$id)->first();

          if($user){
          
             $left_store_users = [];
             $middle_store_users = [];
             $right_store_users = [];
             $uls = UserExtra::where('pos_id', $user->id)->where('position',1)->first();
             $ums = UserExtra::where('pos_id', $user->id)->where('position',2)->first();
             $urs = UserExtra::where('pos_id', $user->id)->where('position',3)->first();
             if($uls){
                 
                 $left_store_users =  userSc($uls->id);
             }

             if($ums){
                 
                 $middle_store_users =  userSc($ums->id);
             }
             
            if($urs){
            
             $right_store_users =  userSc($urs->id);
            }
             


             $left_store_users = getThingTo($left_store_users);

             if($uls){
                 array_unshift($left_store_users, $uls->id);
             }

             $middle_store_users = getThingTo($middle_store_users);

             if($ums){
                 array_unshift($middle_store_users, $ums->id);
             }

             $right_store_users = getThingTo($right_store_users);

             if($urs){
                 array_unshift($right_store_users, $urs->id);
             }


             $lc = 0;
             $mc = 0;
             $rc = 0;

             if(count($left_store_users) != 0){
                  foreach($left_store_users as $v){
                    $ulc = User::where('id', $v)->first();
                 if($ulc){
                    $lc++;
                     }
                 }
             }

             $lulist = $user->id."->".count($left_store_users)."==".$lc;

             if(count($middle_store_users) != 0){
                 foreach($middle_store_users as $v){
                   $umc = User::where('id', $v)->first();
                if($umc){
                   $mc++;
                    }
                }
            }

            $mulist = $user->id."->".count($middle_store_users)."==".$mc;
             
             if(count($right_store_users) != 0){
                  foreach($right_store_users as $v){
                 $urc = User::where('id', $v)->first();
                 if($urc){
                    $rc++;
                     }
                 }
             }

             $rulist = $user->id."->".count($right_store_users)."==".$rc;


             $userChild = UserChild::where('user_id',$user->id)->first();
             if($userChild){

             }else{
                 $ucc = new UserChild();
                 $ucc->user_id = $user->id;
                 $ucc->save();
             }
             $userChild->user_l = json_encode($left_store_users);
             $userChild->user_m = json_encode($middle_store_users);
             $userChild->user_r = json_encode($right_store_users);
             $userChild->save();
               
            echo "<pre>";
           echo  "left -".$lulist;
           echo  "middle -".$mulist;
           echo  "right -".$rulist;
            
            echo "</pre>";
           
         }
        
 }


 function userScShortCheck($id, $checkusername){
    $inner = [];
    $users = UserExtra::where('pos_id', $id)->get();
    if($users){
      foreach($users as $user){
       
        $inner[] =  $user->id;
        $inner[] =  userScShortCheck($user->id, $checkusername);
        
      }
    }
    return $inner;
}



function getThingTo(Array $array){
$result = [];
if(! is_array($array)){
    return false;
}
foreach ($array as $key => $value) {
   if(is_array($value)){
    $result = array_merge($result,getThingTo($value));
   }else{
    $result[] = $value;
   }
}
return $result;
}

   function single_user_finder_dcheck($id, $check_username){
       $user = UserExtra::where('user_id',$id)->first();
       if(!$user) return false;
       for($i = 1; $i <= 3; $i++){
           $ux =  UserExtra::where('pos_id', $user->id)->where('position',$i)->first();
           $store_users = userScShortCheck($ux->id, $check_username);
            if (is_array($store_users)) {
                $userx = getThingTo($store_users);
                array_unshift($userx, $ux->id);
                $rtt[]= $userx;
               $FC = UserExtra::whereIn('id',$userx)->where('user_name',$check_username)->exists();
                if ($FC) {
                   return true;
                }
            }
        
       }
       return false;
   }

  
 function single_msg_bulk_http_send($msg,$numbers) {
    $setting = setting();
    $url = $setting->bulk_sms_url_single;
 
  $results = Http::get($url.'?api_key='.$setting->bulk_sms_api.'&type=text&number='.$numbers.'&senderid='.$setting->bulk_sms_id.'&message='.$msg);
  return $results;

} 
   

function single_msg_bulk_send($msg,$numbers) {
    $setting = setting();
    $url = $setting->bulk_sms_url_single;
 
    $message = $msg;
// $number = "88016xxxxxxxx,88019xxxxxxxx";
    $data = [
        "api_key" => $setting->bulk_sms_api,
        "senderid" => $setting->bulk_sms_id,
        "number" => $numbers,
        "message" => $message,
       
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


function bulk_msg_sms_send($mixing) {
   $setting = setting();
   
    $url = $setting->bulk_sms_url_many;
    $api_key = $setting->bulk_sms_api;
    $senderid = $setting->bulk_sms_id;
 
    $messages = json_encode($mixing);
    
    
    
    $data = [
        "api_key" => $api_key,
        "senderid" => $senderid,
        "messages" => $messages
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