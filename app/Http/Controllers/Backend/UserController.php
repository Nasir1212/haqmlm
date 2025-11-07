<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Mail\DepositMail;
use App\Models\CompanyAccount;
use App\Models\Deposit;
use App\Models\MatrixLevel;
use App\Models\NonWorkingGenCondition;
use App\Models\PayAccounts;
use App\Models\PointSubmitHistory;
use App\Models\User;
use App\Models\UserChild;
use App\Models\UserExtra;
use App\Models\UserNominee;
use App\Models\UserMatrixingDate;
use App\Models\PointSaleHistory;
use App\Models\OutPointHistory;
use App\Models\CountTotalSubmittedPoint;
use App\Models\Withdraw;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Image;

class UserController extends Controller
{


  public function user_unilevel_tree_y(Request $request){
        $gsd = global_user_data();
        $user = User::where('username',$request->id)->first();
        $tree = json_encode($this->buildTree($user));

      
        return view('Admin.user.unilevel-tree-y',compact('user','tree','gsd'));
    }


    protected function buildTree($user)
    {
        $ct = 0;
        $ctt = 0;
        $child = UserChild::where('user_id',$user->id)->first();
        if($child){
            if($child->down_users != ''){
                $ct = count(json_decode($child->down_users));
            
            }
            
             if($child->downline_total_user != ''){
              
                 $ctt = count(json_decode($child->downline_total_user));
            }
           
           
        }
        $tree = [
            'id' => $user->id,
            'username' => $user->username,
            'phone' => $user->phone,
            'email' => $user->email,
            'user_rank' => $user->user_rank,
            'user_down' => $ct,
            'total_user_down' => $ctt,
            'children' => [],
        ];

        foreach ($user->downline as $child) {
            $tree['children'][] = $this->buildTree($child);
        }

        return $tree;
    }

public function trx_pin_option(Request $request){
    $page_title = 'User Transaction Password Setup';
    $gsd = global_user_data();
    $user = User::where('username',$request->username)->first();
    if(Auth::id() == $user->id || Auth::id() == 1){
        return view('Admin.user.transaction-password', compact('user','gsd','page_title','gsd'));
     }else{
        notify()->error('Your Username Incorrect!');
        return back();
     }
    
}

public function trx_pin_action(Request $request){
    $user = User::where('username',$request->user)->first();
    if(Auth::id() == $user->id || Auth::id() == 1){

        if (Auth::id() == 1) {
            $user->trx_password = $request->new_password;
            $user->save();
            notify()->success('Your Transaction Password Setup Successfully!');
            return back();
        }else{
            if($user->trx_password == Null || $user->trx_password == ''){
                $user->trx_password = $request->new_password;
                $user->save();
                notify()->success('Your Transaction Password Setup Successfully!');
                return back();
            }else{
                if($user->trx_password == $request->current_password){
                    if($request->new_password == $request->confirm_password){
                        $user->trx_password = $request->new_password;
                        $user->save();
                        notify()->success('Your Transaction Password Change Successfully!');
                        return back();
                    }else{
                        notify()->error('Sorry Your New Password and Confirm Password Not Match!');
                        return back();
                    }
                    
                }else{
                    notify()->error('Sorry your Current Password Not Match!');
                    return back();
                }
                
            }
        }

        
    }
}


public function my_down_line(Request $request){
     $gsd = global_user_data();
     $no_load = 0;
     $childl = [];
     $childm = [];
     $childr = [];
     $page_title = "My Downline User";
     if(Auth::id() == 1){
         if(isset($request->username)){
             $user = User::where('username',$request->username)->first();
             if($user){
                 $child = UserChild::where('user_id',$user->id)->first();
                 if($child){
                 if($child->user_l == '' || $child->user_r == '' || $child->user_m == ''){
                     $no_load = 1;
                 }
                }else{
                    $no_load = 1;
                 }
            }
             
             
         }else{
             $child =  UserChild::where('user_id',$gsd->id)->first();
             if($child){
             if($child->user_l == '' || $child->user_r == '' || $child->user_m == ''){
                 $no_load = 1;
             }
            }else{
                $no_load = 1;
             }
         }
       
     }else{
         $child =  UserChild::where('user_id',$gsd->id)->first();
         if($child){
            if($child->user_l == '' || $child->user_r == '' || $child->user_m == ''){
                $no_load = 1;
            }
         }else{
            $no_load = 1;
         }
         
     }
     
     
     if($no_load == 0){
         $childl = json_decode($child->user_l);
         if(!empty($childl)){
             $childl = User::whereIn('id',$childl)->get(['username','id','name','invest_status']);
         }

         $childm = json_decode($child->user_m);
         if(!empty($childm)){
             $childm = User::whereIn('id',$childm)->get(['username','id','name','invest_status']);
         }
         
         
         $childr = json_decode($child->user_r);
         if(!empty($childr)){
             $childr = User::whereIn('id',$childr)->get(['username','id','name','invest_status']); 
         }
     }
     
      return view('Admin.user.my-child', compact('childr','no_load','childl','childm','page_title','gsd'));
}

public function my_down_line_reset(Request $request){
     $gsd = global_user_data();
     if(Auth::id() == 1){
         $user = User::where('username',$request->username)->first();
         if($user){
            if($gsd->matrix_activation_status == 0){
                notify()->error('Sorry you cant not access it Becasuse you are inactive for it please activate then access it !');
                return back();
            }
            single_user_finder($user->id);
         }else{
            notify()->error('User Not Found!');
            return back();
         }
        
     }else{
         single_user_finder($gsd->id);
     }
     
     return back();
      
}

 public function userdt(Request $request, $username){
      $page_title = 'All Users';
      $gsd = global_user_data();
  
     $user = User::where('username',$username)->first();
     return view('Admin.user.user-detail', compact('user','gsd','page_title','gsd'));
     
 }
    public function User_ban(Request $request){

        $user = User::where('id',$request->id)->first();
        $user->status = 3;
        $user->save();
        return back();
    } 

    public function User_active(Request $request){
        $user = User::where('id',$request->id)->first();
        $user->status = 1;
        $user->save();
        return back();
    }  
    
    public function User_lock(Request $request){
        $user = User::where('id',$request->id)->first();
        $user->lock_status = 1;
        $user->save();
        return back();
       
    }  
    
    public function User_unlock(Request $request){
        $user = User::where('id',$request->id)->first();
        $user->lock_status = 0;
        $user->save();
        return back();
       
    } 

    public function Users(Request $request){
        $page_title = 'All Users';
        $gsd = global_user_data();

        if($request->filled(['date','e_date'])){
            [$year, $month] = explode('-', $request->date);
            [$eyear, $emonth] = explode('-', $request->e_date);
            $users = User::where('id', '!=', 1)->whereMonth('created_at', '>=', $month)
            ->whereYear('created_at', '>=', $year)
            ->whereMonth('created_at', '<=', $emonth)
            ->whereYear('created_at', '<=', $eyear)
            ->paginate(20);
        }
       else if($request->filled('date')){
            [$year, $month] = explode('-', $request->date);
            $users = User::where('id', '!=', 1)->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->paginate(20);
        }
        else if(isset($request->username)){
            $users = User::where('id', '!=', 1)->where('username',$request->username)->orWhere('phone',$request->username)->orWhere('email',$request->username)->orWhere('name',$request->username)->paginate(20);
        }else{
            $users = User::where('id', '!=', 1)->latest('id')->paginate(20);
        }
        
        return view('Admin.user.users', compact('users','page_title','gsd'));
    } 

    public function locked_Users(Request $request){
        $gsd = global_user_data();
        $page_title = 'Locked Users';
        if($request->filled(['date','e_date'])){
            [$year, $month] = explode('-', $request->date);
            [$eyear, $emonth] = explode('-', $request->e_date);
            $users = User::where('lock_status',1)->whereMonth('created_at', '>=', $month)
            ->whereYear('created_at', '>=', $year)
            ->whereMonth('created_at', '<=', $emonth)
            ->whereYear('created_at', '<=', $eyear)
            ->paginate(20);
        }else if($request->filled('date')){
            [$year, $month] = explode('-', $request->date);
            $users = User::where('lock_status',1)->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->paginate(20);
        }else{
       $users = User::where('lock_status',1)->paginate(20);
        }
        return view('Admin.user.users', compact('users','page_title','gsd'));
    } 

    
    public function Active_User(Request $request){
        $gsd = global_user_data();
        $page_title = 'Active Users';
        if($request->filled(['date','e_date'])){
            [$year, $month] = explode('-', $request->date);
            [$eyear, $emonth] = explode('-', $request->e_date);
            $userIds = UserMatrixingDate::whereMonth('created_at', '>=', $month)
                    ->whereYear('created_at', '>=', $year)
                    ->whereMonth('created_at', '<=', $emonth)
                    ->whereYear('created_at', '<=', $eyear)
                    ->pluck('user_id'); // UserExtra::pluck('user_id');
                    $userIdsArray = $userIds->toArray();
                     $matrix_inac_users =  User::whereIn('id',$userIdsArray)->paginate(20);// $accusers - $matrix_ac_users;
 
        }
       else if(isset($request->date)){
                      [$year, $month] = explode('-', $request->date);
                        $userIds = UserMatrixingDate::whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->pluck('user_id'); // UserExtra::pluck('user_id');
                    $userIdsArray = $userIds->toArray();
                     $matrix_inac_users =  User::whereIn('id',$userIdsArray)->paginate(20);// $accusers - $matrix_ac_users;
                     
                }else{
                    $userIds = $userIds = UserExtra::pluck('user_id');
                    $userIdsArray = $userIds->toArray();
                    $matrix_inac_users = User::whereIn('id',$userIdsArray)->paginate(20); //$accusers - $matrix_ac_users;
                }
        //$users = User::where('status',1)->paginate(20);
         $users = $matrix_inac_users;
        return view('Admin.user.users', compact('users','page_title','gsd'));
    } 

    public function free_user(Request $request){
        $gsd = global_user_data();
        $page_title = 'Free Users';
        $userIds = UserMatrixingDate::all()
        ->pluck('user_id'); // UserExtra::pluck('user_id');
        $userIdsArray = $userIds->toArray();
        if($request->filled(['date','e_date'])){
        [$year, $month] = explode('-', $request->date);
        [$eyear, $emonth] = explode('-', $request->e_date);
        $matrix_ac_users =  User::whereNotIn('id',$userIdsArray)
        ->whereMonth('created_at', '>=', $month)
        ->whereYear('created_at', '>=', $year)
        ->whereMonth('created_at', '<=', $emonth)
        ->whereYear('created_at', '<=', $eyear)
        ->paginate(200);// $accusers - $matrix_ac_users;

          
        }else if(isset($request->date)){
        [$year, $month] = explode('-', $request->date);
        $matrix_ac_users =  User::whereNotIn('id',$userIdsArray)
        ->whereMonth('created_at', $month)
        ->whereYear('created_at', $year)
        ->paginate(200);// $accusers - $matrix_ac_users;
        }else{
        $matrix_ac_users = User::whereNotIn('id',$userIdsArray)
        ->paginate(200); //$accusers - $matrix_ac_users;
        }
        //$users = User::where('status',1)->paginate(20);
         $users = $matrix_ac_users;

        return view('Admin.user.users', compact('users','page_title','gsd'));
    }
    public function Band_User(Request $request){
        $gsd = global_user_data();
        $page_title = 'Banned  Users';
        if($request->filled(['date','e_date'])){
            [$year, $month] = explode('-', $request->date);
            [$eyear, $emonth] = explode('-', $request->e_date);
            $users = User::where('status',3)->whereMonth('created_at', '>=', $month)
            ->whereYear('created_at', '>=', $year)
            ->whereMonth('created_at', '<=', $emonth)
            ->whereYear('created_at', '<=', $eyear)
            ->paginate(20);
        }else if($request->filled('date')){
            [$year, $month] = explode('-', $request->date);
            $users = User::where('status',3)->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->paginate(20);
        }else{
        $users = User::where('status',3)->paginate(20);
        }
        return view('Admin.user.users', compact('users','page_title','gsd'));

    }

    public function total_point_sale(Request $request){

        $gsd = global_user_data();
        $page_title = 'Total Point Sale';
        if($request->filled(['date','e_date'])){
            [$year, $month] = explode('-', $request->date);
            [$eyear, $emonth] = explode('-', $request->e_date);
            $deposits = PointSaleHistory::with('user')
            ->whereMonth('created_at', '>=', $month)
            ->whereYear('created_at', '>=', $year)
            ->whereMonth('created_at', '<=', $emonth)
            ->whereYear('created_at', '<=', $eyear)
            ->where('status',1)
            ->paginate(20)
            ->appends(request()->query());
        }else if($request->filled('date')){
            [$year, $month] = explode('-', $request->date);
            $deposits = PointSaleHistory::with('user')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('status',1)
            ->paginate(20)
            ->appends(request()->query());
        }else{
            $deposits = PointSaleHistory::with('user')
            ->where('status',1)->paginate(20)
            ->appends(request()->query());
        }
    //    return $deposits;
        return view('Admin.user.total-point-sale', compact('deposits','page_title','gsd'));
    }

    public function out_bonus_history(Request $request){
        $gsd = global_user_data();
        $page_title = 'Total Point Out History';
        if($request->filled(['date','e_date'])){
            [$year, $month] = explode('-', $request->date);
            [$eyear, $emonth] = explode('-', $request->e_date);
            $deposits = OutPointHistory::with('user')
            ->whereMonth('created_at', '>=', $month)
            ->whereYear('created_at', '>=', $year)
            ->whereMonth('created_at', '<=', $emonth)
            ->whereYear('created_at', '<=', $eyear)
            
            ->paginate(20)
            ->appends(request()->query());

            

        }else if($request->filled('date')){
            [$year, $month] = explode('-', $request->date);
    $deposits = OutPointHistory::with('user')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
           
            ->paginate(20)
            ->appends(request()->query());
        }else{
        $deposits = OutPointHistory::with('user')
                    ->paginate(20)
                ->appends(request()->query());
        }
       // return $deposits;  
        return view('Admin.user.out-bonus-history', compact('deposits','page_title','gsd'));
    }
    
    public function total_submitted_point_sale(Request $request){
            $gsd = global_user_data();
            $page_title = 'Total Submitted Point Sale';
            if($request->filled(['date','e_date'])){
            [$year, $month] = explode('-', $request->date);
            [$eyear, $emonth] = explode('-', $request->e_date);
            $records = CountTotalSubmittedPoint::whereMonth('created_at', '>=', $month)
            ->whereYear('created_at', '>=', $year)
            ->whereMonth('created_at', '<=', $emonth)
            ->whereYear('created_at', '<=', $eyear)
            ->paginate(20)
            ->appends(request()->query());
            }else if($request->filled('date')){
            [$year, $month] = explode('-', $request->date);
            $records = CountTotalSubmittedPoint::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->paginate(20)
            ->appends(request()->query());
            }else{
            $records = PointSubmitHistory::latest('id')->paginate(20);
            }
            // return $records;
      return view('Admin.user.total-submitted-point-sale', compact('records','page_title','gsd'));


}

public function delivered_bonus_history(Request $request){
    $gsd = global_user_data();
    $page_title = 'Delivered Bonus History';
    if($request->filled(['date','e_date'])){
        [$year, $month] = explode('-', $request->date);
        [$eyear, $emonth] = explode('-', $request->e_date);
        $deposits = Withdraw::with('user')
        ->where('status','Approve')
        ->whereMonth('created_at', '>=', $month)
        ->whereYear('created_at', '>=', $year)
        ->whereMonth('created_at', '<=', $emonth)
        ->whereYear('created_at', '<=', $eyear)
        ->paginate(20)
        ->appends(request()->query());

        

    }else if($request->filled('date')){
        [$year, $month] = explode('-', $request->date);
        $deposits = Withdraw::with('user')
        ->where('status','Approve')
        ->whereMonth('created_at', $month)
        ->whereYear('created_at', $year)
       
        ->paginate(20)
        ->appends(request()->query());
    }else{
    $deposits = Withdraw::with('user')
            ->where('status','Approve')
            ->paginate(20)
            ->appends(request()->query());
    }
 //   return $deposits;  
    return view('Admin.user.delivered-bonus-history', compact('deposits','page_title','gsd'));



}

    public function my_refer(Request $request)
{
    $gsd = global_user_data();
    $empty_message = 'No user found';
    // Get all referred users recursively
    $userIds = $this->getAllReferredUserIds($gsd->id);
    // Get the selected month and year or default to current
    $monthYear = $request->month_year ?? now()->format('Y-m');
      // Query users with filters
    $usersQuery = User::where('ref_id', Auth::id())->latest();
     if ($request->has('month_year')) {
        $usersQuery->whereYear('created_at', Carbon::parse($monthYear)->year)
                   ->whereMonth('created_at', Carbon::parse($monthYear)->month);
    }
    $users = $usersQuery->paginate(5)->appends(['month_year' => $monthYear]);
    // Fetching network users
    $tucUsers = User::whereIn('id', $userIds); 
    if ($request->has('month_year')) {
        $tucUsers->whereYear('created_at', Carbon::parse($monthYear)->year)
                 ->whereMonth('created_at', Carbon::parse($monthYear)->month);
    }

    $tucUsers = $tucUsers->get();
    $paid = $tucUsers->where('matrix_activation_status', 1)->count();
    $tuc = $tucUsers->count();
    $free = $tuc - $paid;

    // Sponsor users
    $sp_users  = User::where('sponsor_id', Auth::id());

    if ($request->has('month_year')) {
        $sp_users ->whereYear('created_at', Carbon::parse($monthYear)->year)
                ->whereMonth('created_at', Carbon::parse($monthYear)->month);
    }

    $sp_users  = $sp_users ->get();
    $sp_paid = $sp_users ->where('matrix_activation_status', 1)->count();
    $sp_total = $sp_users ->count();
    $sp_free = $sp_total - $sp_paid;
    $sponsors_info = [
        'users' => $sp_users,
        'total' => $sp_total,
        'paid' => $sp_paid,
        'free' => $sp_free
    ];
    return view('Admin.user.my-refer', compact('users', 'empty_message', 'gsd', 'tuc', 'paid', 'free', 'monthYear','sponsors_info'));
}




// Recursive function to get all referred user IDs
private function getAllReferredUserIds($id)
{
    $users = User::where('ref_id', $id)->pluck('id')->toArray();
    
    foreach ($users as $userId) {
        $users = array_merge($users, $this->getAllReferredUserIds($userId));
    }

    return $users;
}

//      public function my_refer(Request $request){
//         $gsd = global_user_data();
//         $empty_message = 'No user found';
        
        


//         function tuserScShortCheck($idd){
//     $inner = [];
//     $users = User::where('ref_id', $idd)->get();
//     if($users){
//       foreach($users as $user){
       
//         $inner[] =  $user->id;
//         $inner[] =  tuserScShortCheck($user->id);
        
//       }
//     }
//     return $inner;
// }

    
//     function tgetThingTo(Array $array){
//         $result = [];
//         if(! is_array($array)){
//             return false;
//         }
//         foreach ($array as $key => $value) {
//            if(is_array($value)){
           
//             $result = array_merge($result,tgetThingTo($value));
//            }else{
           
//             $result[] = $value;
//            }
//         }
//         return $result;
//      }
     
//     $root_user = User::where('id',$gsd->id)->first();
//     $store_users = tuserScShortCheck($root_user->id);
//     $userx = tgetThingTo($store_users);   

 
  
//           if(isset($request->month_year)){
//                 $monthYear = $request->month_year ?? now()->format('Y-m');
//         $users = User::where('ref_id', Auth::id())
//             ->whereYear('created_at', Carbon::parse($monthYear)->year)
//             ->whereMonth('created_at', Carbon::parse($monthYear)->month)
//             ->latest()
//             ->paginate(5);
         
//             $tuc = User::whereIn('id',$userx)
//             ->whereYear('created_at', Carbon::parse($monthYear)->year)
//             ->whereMonth('created_at', Carbon::parse($monthYear)->month)->get(); 
             
//         $paid = $tuc->where('matrix_activation_status', 1)->count();
//         $free = $tuc->count() - $paid;
//         $tuc = $tuc->count();
//         $users->appends(['month_year' => $monthYear]);         
//         $tuc = User::whereIn('id',$userx)
//         ->whereYear('created_at', Carbon::parse($monthYear)->year)
//         ->whereMonth('created_at', Carbon::parse($monthYear)->month)->get(); 
             
//         $paid = $tuc->where('matrix_activation_status', 1)->count();
//         $free = $tuc->count() - $paid;
//         $tuc = $tuc->count();
//         $users->appends(['month_year' => $monthYear]);

//         $sp_users = User::where('sponsor_id',Auth::id())
//         ->whereYear('created_at', Carbon::parse($monthYear)->year)
//         ->whereMonth('created_at', Carbon::parse($monthYear)->month)
//         ->get(); 
//         $sp_paid = $sp_users->where('matrix_activation_status', 1)->count();
//         $sp_total = $sp_users->count();
//         $sp_free = $sp_total - $sp_paid; 
     
//         return view('Admin.user.my-refer',compact('users','empty_message','gsd','tuc','paid','free','monthYear'));

//           }else{
//           $monthYear = $request->month_year ?? now()->format('Y-m');
//         $users = User::where('ref_id', Auth::id())->latest()
//             ->paginate(5);
          
//         $tuc = User::whereIn('id',$userx)->get(); 
//         $paid = $tuc->where('matrix_activation_status', 1)->count();
//         $free = $tuc->count() - $paid;
//         $tuc = $tuc->count();


//         $sp_users = User::where('sponsor_id',Auth::id())->get();
//         $sp_paid = $sp_users->where('matrix_activation_status', 1)->count();
//         $sp_total = $sp_users->count();
//         $sp_free = $sp_total - $sp_paid; 
    
//         return view('Admin.user.my-refer',compact('users','empty_message','gsd','tuc','paid','free','monthYear'));
//           }      
//     }
    

    public function Approve_acounts(){
        $gsd = global_user_data();
        $page_title = 'Active Accounts';
        $users = User::where('new_submited_point_status',1)->paginate(20);
        $action = 0;
        return view('Admin.user.point_submited_accounts', compact('action','users','page_title','gsd'));
    } 

    public function Pending_acounts(){
        $gsd = global_user_data();
        $page_title = 'Active Accounts';
        $users = User::where('new_submited_point_status',2)->paginate(20);
        $action = 1;
        return view('Admin.user.point_submited_accounts', compact('action','users','page_title','gsd'));
    } 

public function account_approve_option(Request $request){
    $gsd = global_user_data();
    $page_title = 'Account active option';
    $user = User::where('username',$request->username)->first();
    $last_user = UserExtra::latest('id')->first();


    return view('Admin.user.account-active-option', compact('last_user','user','page_title','gsd'));
}

public function   placement_join_check(Request $request) {

    $position = $request->position == 'Left' ? 1 : ($request->position == 'Middle' ? 2 : 3);
    $placement_user = $request->placement_username ? UserExtra::where('user_name', $request->placement_username)->first() : null;
    $pos = $placement_user ? getPosition($placement_user->id, $position) : null;
    $join_under = $pos ? User::find($pos['pos_id']) : null;
    $get_position = $pos ? ($pos['position'] == 1 ? 'Left' : ($pos['position'] == 2 ? 'Middle' : 'Right')) : null;
    return response()->json([$join_under ? $join_under->username : null, $get_position]);
}


public function placement_user_check(Request $request){
    $users = UserExtra::where('user_name','LIKE', "%$request->placement_username%")->get();
    $tb = '';
    if($users){
        $tb = '<ul id="users">';

        foreach ($users as $key => $user) {
            $tb .= '<li class="user" data-name="'.$user->user_name.'">'.$user->user_name.'</li>';
        }
        $tb .= '</ul>';
    }else{
        $tb = '';
    }

    return response()->json($tb);
}

public function account_approve_action(Request $request){
    $gsd = global_user_data();
    if($request->position == ''){
        notify()->error('Position Required');
        return back();
    }

    $user = User::where('username',$request->username)->where('new_submited_point_status',2)->first();
      $ca = CompanyAccount::where('id',1)->first();
      $ca->point += $user->submitted_point;
      $ca->save();
    
                if($user->matrix_activation_status == 0){
                    if(isMatrixUserExists($user->id)){

                    }else{
                        $puser = UserExtra::where('user_name',$request->placement)->first();
                        $pos = getPosition($puser->user_id, $request->position);

                        $parent_id = User::find($pos['pos_id']);
    

                        if ($request->position == 'Left'){
                            $r_position = 1;
                    
                        }
                    
                        if ($request->position == 'Middle'){
                            $r_position = 2;
                    
                        }
                    
                    
                        if($request->position == 'Right'){
                            $r_position = 3;
                        }

                        $userMatrix = new UserExtra();
                        $userMatrix->user_id = $user->id;
                        $userMatrix->user_name = $user->username;
                        $userMatrix->pos_id = $parent_id->id;
                        $userMatrix->position = $r_position;
                        $userMatrix->status = 1;
                        $userMatrix->save();

                        $user->matrix_activation_status = 1;
                        $user->invest_status = 1;
                        $user->distribute_status = 1;
                        $user->submit_check = 1;
                        $user->new_submited_point_status = 1;
                        $user->save();

                        updatePaidCount($user->id);
                        referralComission($user->id);
                     
                    }
                 
                }
                   
                notify()->success('Matrix Joining Success');
                return back();
}


    public function User_details( Request $request, $username){
        $gsd = global_user_data();
        $connected_accounts = User::where('uniqe_key_code', $gsd->uniqe_key_code)->get();
        
        if(Auth::id() == 1){
            $user = User::where('username',$username)->first();
        }else{
            $user = User::where('username',$gsd->username)->first();
        }
       
        return view('Admin.user.user_details', compact('user','gsd','connected_accounts'));
    }


    public function Account_setup(Request $request, $username){
        $gsd = global_user_data();

        $connected_accounts = User::where('uniqe_key_code', $gsd->uniqe_key_code)->get();
       
        if (permission_checker($gsd->role_info,'user_manage') == 1){
            $user = User::where('username', $username)->with('nominee')->first();
        }else{
            $user = User::where('username',$gsd->username)->with('nominee')->first();
        }

        $address = json_decode($user->address);
   
        return view('Admin.user.user_account_setup', compact('user', 'address', 'gsd','connected_accounts'));
    }

    public function user_profile_update(Request $request){
        
        $gsd = global_user_data();

        $user = User::where('username',$request->username)->first();
        if(Auth::id() != 1){
            if($user->client_update_count < 2){
                $user->client_update_count +=1;
            }else{
                    notify()->error('Your profile can be self update can only 2 Time! if you want any information change please contact with admin.');
               return back();
            }
        }
        
        $user->first_name = $request->firstName;
        $user->last_name = $request->lastName;
            $user->father_name = $request->fatherName;
        $user->mother_name = $request->motherName;
        $user->identity_number = $request->identity_number;
        $user->email = $request->email;
        $user->phone = $request->phone;
         
        $user->birth_of_date = $request->birth_date;
        $user->religion = $request->religion;
        $address = [
            'house_holding'=>$request->house_holding,
            'country'=>$request->country,
            'city'=>$request->city,
            'state'=>$request->state,
            'upzila'=>$request->upzila,
            'village'=>$request->village,
            'zip_code'=>$request->zip_code
            
        ];
     
       
        if($request->password != '' || $request->password != null){
              $user->password =  Hash::make($request->password);
        }
    
        $user->address = json_encode($address);

        if($request->profile_pic != ''){
            $pf = explode('users/',$request->profile_pic);
            $user->user_pic_path = $pf[0].'users/';
            $user->user_pic = $pf[1];
        }
        $user->save();

        $Nominee = UserNominee::where('parent_id',$user->id)->first();
        if($Nominee){
            $Nominee->name = $request->nName;
            $Nominee->father_name = $request->nfather_name;
            $Nominee->mother_name = $request->nmother_name;
            $Nominee->email = $request->nemail;
            $Nominee->relation = $request->nrelation;
            $Nominee->birth_of_date = $request->nbirth_date;
            $Nominee->identity_number = $request->nidentity_number;
           
            if($request->nprofile_pic != ''){
                $pf = explode('users/',$request->nprofile_pic);
                $Nominee->pic_path = $pf[0].'users/';
                $Nominee->profile_pic = $pf[1];
            }
            $Nominee->save();
        }

        notify()->success('Profile Update successfull!');
        return back();
    }



public function user_tree_jump(Request $request){
    $gsd = global_user_data();
    if($request->username != ''){
         if(Auth::id() == 1){
         
         return redirect()->route('user_tree', ['id'=>$request->username]);
           
    }else{
       notify()->error('Sorry Not Allow');
                return back();
    }
  
    }else{
         notify()->error('Please Provide Username');
                return back();
    }
  
   
   
}

public function user_unilevel_tree_jump(Request $request){
    $gsd = global_user_data();  
    if($request->username != ''){
         if(Auth::id() == 1){
         return redirect()->route('user_unilevel_tree', ['id'=>$request->username]);
           
    }else{
        $get_tree_user =   $this->getDownlineUsers($gsd->id);
        if(in_array($request->username, $get_tree_user)){
            return redirect()->route('user_unilevel_tree', ['id'=>$request->username]);
        }else{
            return redirect()->back()->with('error', 'Sorry, Not Allowed');

        }
    }
  
    }else{
         notify()->error('Please Provide Username');
                return back();
    }
  
   
   
}

public function getDownlineUsers($userId, &$downlineUsers = [])
{
    $users = User::where('ref_id', $userId)->get();
    foreach ($users as $user) {
        $downlineUsers[] = $user->username;
        $this->getDownlineUsers($user->id, $downlineUsers); // Recursive call
    }
    return $downlineUsers;
}

public function  user_unilevel_tree(Request $request, $id){
    $gsd = global_user_data();
    $setting = setting();
    $company_name = $setting->company_name;

    $current = Carbon::now()->subMonth();
    
    
   
        
 function tuserScShortCheck($idd){
    $inner = [];
    $users = User::where('ref_id', $idd)->get();
    if($users){
      foreach($users as $user){
       
        $inner[] =  $user->id;
        $inner[] =  tuserScShortCheck($user->id);
        
      }
    }
   
    return $inner;
}

    
    function tgetThingTo(Array $array){
        $result = [];
        if(! is_array($array)){
            return false;
        }
        foreach ($array as $key => $value) {
           if(is_array($value)){
            $result = array_merge($result,tgetThingTo($value));
           }else{
            $result[] = $value;
           }
        }
        return $result;
     }
     
    $root_user = User::where('id',$gsd->id)->first();
    $fuser = User::where('username',$id)->first();
    
    $store_users = tuserScShortCheck($root_user->id);
     $userx = tgetThingTo($store_users);
     array_unshift($userx, $root_user->id);
    if($fuser){
       
        if(in_array($fuser->id, $userx)){
            
        }else{
             notify()->error('Sorry user not found!');
                    return back();
        }
    }else{
        notify()->error('Sorry user not found!');
                    return back();
    }
       
    
    
    
    
  //  $userss = User::where('username',$id)->with(['childrenn'])->first();
    $tree  = User::where('username', $request->id)
    ->with([
        'childrenn' => function ($query) {
            $query->with([
                'childrenn' => function ($query) {  
                    $query->with('childrenn'); // Fetch third-level children
                }
            ]);
        }
    ])
    ->first();

    // $tree = $tree->toArray();
//   dd($tree['childrenn']);    
    // $tcd = ['total_child'=>count($userss->childrenn)];
    //  $ptp = ['team_point'=>$userss->downlineTotalPoints($current)];
    //  $ucd = [];
    // foreach($userss->childrenn as $child){ 
        
    //     $usercself = User::where('username',$child->username)->with(['childrenn'])->first();
    //     $usf = count($usercself->childrenn);
    //   $totalPoints = $child->downlineTotalPoints($current);
    //   $ucd[] = array_merge($child->toArray(), ['team_point'=>$totalPoints,'total_child'=>$usf]);
      
    //   unset($ucd['childrenn']);
    // };
   
    
    // $ucdr = ['children'=>$ucd];
    // $mergedData = array_merge($userss->toArray(), $ucdr);
    // $mergedData = array_merge($mergedData, $ptp);
    // $mergedData = array_merge($mergedData, $tcd);
    
    // unset($mergedData['childrenn']);

    
    //  $tree = json_encode($mergedData);
     
     
    return view('Admin.user.unilevel-tree',compact('company_name','tree','gsd'));
}

private function calculateTTP($user)
{
    $sum_ttp = 0;

    if (\Carbon\Carbon::parse($user["point_submit_date"])->gt(\Carbon\Carbon::now()->subDays(7))) {
        $sum_ttp += $user["submitted_point"];
    }

    // Recursively add children points
    if ($user->childrenn->count() > 0) {
        foreach ($user->childrenn as $child) {
            $sum_ttp += $this->calculateTTP($child); // Recursive call
        }
    }

    return $sum_ttp;
}
  public function fetch_total_team_point (Request $request,$id){
    $user = User::where('username', $id)->with('childrenn')->first();
    
    if (!$user) {
        return 0; // Return 0 if the user does not exist
    }

    return $this->calculateTTP($user);
  }
    public function user_unilevel_gen_tree(Request $request, $id){
        $gsd = global_user_data();
        $user = User::where('username',$id)->first();
        $args = [[$user->id,$user->username,$user->invest_status]];
        $gen = $request->gen ? $request->gen : 1;
        $i = 0;
        function gensQ($prev){
            $ngen = [];
            foreach ($prev as $key => $value) {
               $gens = User::where('ref_id', $value[0])->get();
               if ($gens) {
                 foreach ($gens as $key => $gen) {
                    $ngen[] = [$gen->id,$gen->username,$gen->invest_status];
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
        
     $curl =  url()->current();
        return view('Admin.user.unilevel-gen-tree',compact('gsd','curl','gdata'));
    }
    public function user_tree(Request $request, $id){
        
     
        $gsd = global_user_data();

        if($gsd->matrix_activation_status == 0){
            notify()->error('Sorry, you cant not access it Becasuse you are inactive for it. please activate then access it !');
            return back();
        }
        $user_id =  User::where('username', $id)->first();
        $left_user = 'fresh';
        $middle_user = 'fresh';
        $right_user = 'fresh';
        $left_user_left = 'fresh';
        $left_user_middle = 'fresh';
        $left_user_right = 'fresh';
        $middle_user_left = 'fresh';
        $middle_user_middle = 'fresh';
        $middle_user_right = 'fresh';
        $right_user_left = 'fresh';
        $right_user_middle = 'fresh';
        $right_user_right = 'fresh';
        $up_user = 0;
      
       
   

     $user = UserExtra::where('user_id', $user_id->id)->with(['user','matrix_Levels'])->first();
//   dd($user);
     
     $lvc = 0;

 $lvc = UserExtra::where('root_level',$user->root_level)->latest('level_cap')->first();


     $lvc = $lvc->level_cap;

    

     
    $dfl = lv(3,$user->root_level - 1);
 
     
    

      if($user->pos_id != 0){
          $up_user = parent_username($user->pos_id);
      }
     
      
      
// second line
       $left_user = getTreeChild($user->user_id,1);
  
       $middle_user = getTreeChild($user->user_id,2);

       $right_user = getTreeChild($user->user_id,3);
       
// third line
       if($left_user != 'Not Found' && $left_user != 'fresh'){
            $left_user_left =  getTreeChild($left_user->user_id,1);
            $left_user_middle =  getTreeChild($left_user->user_id,2);
            $left_user_right =  getTreeChild($left_user->user_id,3);
       }


       if($middle_user != 'Not Found' && $middle_user != 'fresh'){
            $middle_user_left =  getTreeChild($middle_user->user_id,1);
            $middle_user_middle =  getTreeChild($middle_user->user_id,2);
            $middle_user_right =  getTreeChild($middle_user->user_id,3);
        }  

     
       if($right_user != 'Not Found' && $right_user != 'fresh'){
            $right_user_left =  getTreeChild($right_user->user_id,1);
            $right_user_middle =  getTreeChild($right_user->user_id,2);
            $right_user_right =  getTreeChild($right_user->user_id,3); 
       }  

       return view('Admin.user.user-tree',compact('dfl','lvc','up_user','gsd','user','left_user','middle_user','right_user','left_user_left','left_user_middle','left_user_right','middle_user_left','middle_user_middle','middle_user_right','right_user_left','right_user_middle','right_user_right'));
    }



    public function FullEditor(Request $request){
        $gsd = global_user_data();
        if(Auth::id() != 1){
            notify()->error('Permission Not Allow!');
            return back();
        }else{
            $spn = '';
            if($request->type == 'id'){
                $user = User::where('id', $request->arg)->with(['nominee','sponsor'])->first();
                
            }else{
                $user = User::where('username', $request->arg)->with(['nominee','sponsor'])->first();
            }
            if($user->sponsor_id != ''){
              $spnc = User::where('id', $user->sponsor_id)->first();
              if($spnc){
                   $spn = $spnc->username;   
              }
            
            }
            
            $userExtraInfo = UserExtra::where('user_id', $user->id)->first();
            $address = json_decode($user->address);
        
            
            return view('Admin.user.user-full-controll',compact('address','userExtraInfo','gsd','user','spn')); 
        }

        
    }


    public function FullUpdate(Request $request){
        
  
        if(Auth::id() != 1){
            notify()->error('Permission Not Allow!');
            return back();
        }else{
       $address = [
            'house_holding'=>$request->house_holding,
            'country'=>$request->country,
            'city'=>$request->city,
            'state'=>$request->state,
            'upzila'=>$request->upzila,
            'village'=>$request->village,
            'zip_code'=>$request->zip_code
            
        ];
    
        $user = User::where('username', $request->username)->first();
        $user->name = $request->name;
      
        $user->father_name = $request->fatherName;
        $user->mother_name = $request->motherName;
        if(User::where('username', $request->old_username)->exists()){
            
        }else{
            $user->username = $request->old_username;
        }
        
        
        $ruser = User::where('username', $request->ref_usern)->first();
        $spuser = User::where('username', $request->sponsor_username)->first();
        $user->ref_id =  $ruser->id;
        if($spuser){
             $user->sponsor_id =  $spuser->id;
        }
       
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->balance = $request->main_balance;
        $user->point = $request->point;
        $user->lock_point = $request->lock_point;
        $user->address = $address;
        
     
       
        if($request->password != '' || $request->password != null){
            $user->password =  Hash::make($request->password);
      }
  
      $user->address = json_encode($address);

      if($request->profile_pic != ''){
          $pf = explode('users/',$request->profile_pic);
          $user->user_pic_path = $pf[0].'users/';
          $user->user_pic = $pf[1];
      }
        $user->save();
         $Nominee = UserNominee::where('parent_id',$user->id)->first();
        if($Nominee){
            $Nominee->name = $request->nName;
            $Nominee->mother_name = $request->nmother_name;
             $Nominee->father_name = $request->nfather_name;
            $Nominee->email = $request->nemail;
            $Nominee->birth_of_date = $request->nbirth_date;
           $Nominee->identity_number = $request->nidentity_number;
           $Nominee->relation = $request->nrelation;
            if($request->nprofile_pic != ''){
                $pf = explode('users/',$request->nprofile_pic);
                $Nominee->pic_path = $pf[0].'users/';
                $Nominee->profile_pic = $pf[1];
            }
            $Nominee->save();
        }

      
        notify()->success('Account Update Successfully!');

        return back();
        }
        
    }

    public function user__check(Request $request){
        $users = User::where('username','LIKE', "%$request->username%")->get();
        $tb = '';
        if($users){
            $tb = '<ul id="users">';
    
            foreach ($users as $key => $user) {
                $tb .= '<li class="user" data-name="'.$user->name.'" data-us_name="'.$user->username.'">'.$user->username.' -- '.$user->name.'</li>';
            }
            $tb .= '</ul>';
        }else{
            $tb = '';
        }
    
        return response()->json($tb);
    }


public function  last_user_tree(Request $request){

    $left_user = 'fresh';
    $middle_user = 'fresh';
    $right_user = 'fresh';
    $left_user_left = 'fresh';
    $left_user_middle = 'fresh';
    $left_user_right = 'fresh';
    $middle_user_left = 'fresh';
    $middle_user_middle = 'fresh';
    $middle_user_right = 'fresh';
    $right_user_left = 'fresh';
    $right_user_middle = 'fresh';
    $right_user_right = 'fresh';
    $up_user = 0;
   
    $user = UserExtra::where('user_name', $request->username)->with(['user'])->first();


    $left_user = getTreeChild($user->id,1);
    $middle_user = getTreeChild($user->id,2);
    $right_user = getTreeChild($user->id,3);

    if($left_user != 'Not Found' && $left_user != 'fresh'){
        $left_user_left =  getTreeChild($left_user->id,1);
        $left_user_middle =  getTreeChild($left_user->id,2);
        $left_user_right =  getTreeChild($left_user->id,3);
    }

    if($middle_user != 'Not Found' && $middle_user != 'fresh'){
        $middle_user_left =  getTreeChild($middle_user->id,1);
        $middle_user_middle =  getTreeChild($middle_user->id,2);
        $middle_user_right =  getTreeChild($middle_user->id,3);
    }

    if($right_user != 'Not Found' && $right_user != 'fresh'){
        $right_user_left =  getTreeChild($right_user->id,1);
        $right_user_middle =  getTreeChild($right_user->id,2);
        $right_user_right =  getTreeChild($right_user->id,3);
    }



    return response()->json([
        'up_user' => $up_user,
        'user' => $user,
        'left_user' => $left_user,
        'middle_user' => $middle_user,
        'right_user' => $right_user,
        'left_user_left' => $left_user_left,
        'left_user_middle' => $left_user_middle,
        'left_user_right' => $left_user_right,
        'middle_user_left' => $middle_user_left,
        'middle_user_middle' => $middle_user_middle,
        'middle_user_right' => $middle_user_right,
        'right_user_left' => $right_user_left,
        'right_user_middle' => $right_user_middle,
        'right_user_right' => $right_user_right,
    ]);
}



}


