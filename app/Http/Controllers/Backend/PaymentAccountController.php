<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\PayAccounts;
use App\Models\Gateway;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\RankCondition;
use Carbon\Carbon;
use App\Models\CompanyReserveFund;
use Image;
use Illuminate\Support\Str;

class PaymentAccountController extends Controller
{
    // Pay Accounts
    
    
    public function royality_sender_form(){
        $gsd = global_user_data();
        
      function ranker($rank){
            return User::where('user_rank',$rank)->get(['name','username','user_rank']);
      }
      function rankRoyalityCond($rank){
            return RankCondition::where('rank_name',$rank)->first('rank_royality');
      }
        $brand_promoters = [];
        $marketing_managers = [];
        $executive_managers = [];
        $assistant_general_managers = [];
        $deputy_general_managers = [];
        $general_managers = [];
        $executive_directors = [];
        $ruby_directors = [];
        $dimond_directors = [];
        $bpc = [];
        $mmc = [];
        $emc = [];
        $agmc = [];
        $dgmc = [];
        $gmc = [];
        $edc = [];
        $rdc = [];
        $ddc = [];
        
        $brand_promoters = ranker('Brand Promoter');
        $bpcc = rankRoyalityCond('Brand Promoter');
        if($brand_promoters){
            $brand_promoters = $brand_promoters;
        }  
        
        $marketing_managers = ranker('Marketing manager');
        $mmc = rankRoyalityCond('Marketing manager');
        if($marketing_managers){
            $marketing_managers = $marketing_managers;
        }
        
        $executive_managers =  ranker('Executive Manager');
        $emc = rankRoyalityCond('Executive Manager');
         if($executive_managers){
            $executive_managers = $executive_managers;
        }
        
        $assistant_general_managers =  ranker('Assistant General Manager');
        $agmc = rankRoyalityCond('Assistant General Manager');
         if($assistant_general_managers){
            $assistant_general_managers = $assistant_general_managers;
        }
        
        $deputy_general_managers = ranker('Deputy General Manager');
        $dgmc = rankRoyalityCond('Deputy General Manager');
         if($deputy_general_managers){
            $deputy_general_managers = $deputy_general_managers;
        }
        
        $general_managers = ranker('General Manager');
        $gmc = rankRoyalityCond('General Manager');
         if($general_managers){
            $general_managers = $general_managers;
        }
        
        $executive_directors = ranker('Executive Director');
        $edc = rankRoyalityCond('Executive Director');
         if($executive_directors){
            $executive_directors = $executive_directors;
        }
        
        $ruby_directors = ranker('Ruby Director');
        $rdc = rankRoyalityCond('Ruby Director');
         if($ruby_directors){
            $ruby_directors = $ruby_directors;
        }
        
        $dimond_directors = ranker('Dimond Director');
        $ddc = rankRoyalityCond('Dimond Director');
        
         if($dimond_directors){
            $dimond_directors = $dimond_directors;
        }
        
        $fund = CompanyReserveFund::where('id',1)->first();
        
        $royality_fund = $fund->royality_fund;
        
       return view('Admin.royality-fund-sender', compact('bpc','brand_promoters','ddc','rdc','edc','gmc','dgmc','agmc','emc','mmc','gsd','royality_fund','marketing_managers','executive_managers','assistant_general_managers','deputy_general_managers','general_managers','executive_directors','ruby_directors','dimond_directors'));
    }
    
    public function royality_fund_sender_action(Request $request){
        
        $royality_fund = CompanyReserveFund::where('id',1)->first()->royality_fund;
      
      function ranker($rank){
            return User::where('user_rank',$rank)->get(['name','username','user_rank']);
        }
      function rankRoyalityCond($rank){
            return RankCondition::where('rank_name',$rank)->first('rank_royality')->rank_royality;
      }
        
     
         $marketing_managers = ranker('Marketing manager');
         $mmc = rankRoyalityCond('Marketing manager');
            if($marketing_managers){
                
                if(count($marketing_managers) != 0){
                    $fa = $royality_fund / 100 * $mmc;
                    $amount = $fa / count($marketing_managers);
                     foreach($marketing_managers as $marketing_manager){
                    $marketing_manager->rank_royality_balance += $amount;
                    $marketing_manager->save();
                   }
                }
                  
        }
        
        // end marketing manager 
        
          
         $executive_managers = ranker('Executive Manager');
         $emc = rankRoyalityCond('Executive Manager');
         if($executive_managers){
                
                if(count($executive_managers) != 0){
                    $fa = $royality_fund / 100 * $emc;
                    $amount = $fa / count($executive_managers);
                     foreach($executive_managers as $executive_manager){
                    $executive_manager->rank_royality_balance += $amount;
                    $executive_manager->save();
                   }
                }
                  
        }
        
           // end Executive Manager 
        
         $assistant_general_managers = ranker('Assistant General Manager');
         $agmc = rankRoyalityCond('Assistant General Manager');
         if($assistant_general_managers){
                
                if(count($assistant_general_managers) != 0){
                    $fa = $royality_fund / 100 * $agmc;
                    $amount = $fa / count($assistant_general_managers);
                     foreach($assistant_general_managers as $assistant_general_manager){
                    $assistant_general_manager->rank_royality_balance += $amount;
                    $assistant_general_manager->save();
                   }
                }
                  
        }
        // end Assistant General Manager
        
        
         $deputy_general_managers = ranker('Deputy General Manager');
         $dgmc = rankRoyalityCond('Deputy General Manager');
         if($deputy_general_managers){
                
                if(count($deputy_general_managers) != 0){
                    $fa = $royality_fund / 100 * $dgmc;
                    $amount = $fa / count($deputy_general_managers);
                     foreach($deputy_general_managers as $deputy_general_manager){
                    $deputy_general_manager->rank_royality_balance += $amount;
                    $deputy_general_manager->save();
                   }
                }
                  
        }
        // end Deputy General Manager
        
          
         $general_managers = ranker('General Manager');
         $gmc = rankRoyalityCond('General Manager');
         if($general_managers){
                
                if(count($general_managers) != 0){
                    $fa = $royality_fund / 100 * $gmc;
                    $amount = $fa / count($general_managers);
                     foreach($general_managers as $general_manager){
                    $general_manager->rank_royality_balance += $amount;
                    $general_manager->save();
                   }
                }
                  
        }
        // end General Manager
        
        
         $executive_directors = ranker('Executive Director');
         $edc = rankRoyalityCond('Executive Director');
         if($executive_directors){
                
                if(count($executive_directors) != 0){
                    $fa = $royality_fund / 100 * $edc;
                    $amount = $fa / count($executive_directors);
                     foreach($executive_directors as $executive_director){
                    $executive_director->rank_royality_balance += $amount;
                    $executive_director->save();
                   }
                }
                  
        }
        // end Executive Director
        
        
         $ruby_directors = ranker('Ruby Director');
         $rdc = rankRoyalityCond('Ruby Director');
         if($ruby_directors){
                
                if(count($ruby_directors) != 0){
                    $fa = $royality_fund / 100 * $rdc;
                    $amount = $fa / count($ruby_directors);
                     foreach($ruby_directors as $ruby_director){
                    $ruby_director->rank_royality_balance += $amount;
                    $ruby_director->save();
                   }
                }
                  
        }
        // end Ruby Director
        
        $dimond_directors = ranker('Dimond Director');
         $ddc = rankRoyalityCond('Dimond Director');
         if($ruby_directors){
                
                if(count($dimond_directors) != 0){
                    $fa = $royality_fund / 100 * $ddc;
                    $amount = $fa / count($dimond_directors);
                     foreach($dimond_directors as $dimond_director){
                    $dimond_director->rank_royality_balance += $amount;
                    $dimond_director->save();
                   }
                }
                  
        }
        // end Dimond Director
        notify()->success('Success');
        return back();
        
    }

    public function pay_accounts(){
        $gsd = global_user_data();
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'account_manage') == 1){
        $pay_accounts = PayAccounts::where('user_id', Auth::id())->with('gateway')->get();
        return view('Admin.pay-account.pay_accounts', compact('pay_accounts','gsd'));
         }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    } 

    public function add_account(){
        $gsd = global_user_data();
        if (Auth::id() == 1 || permission_checker($gsd->role_info,'account_manage') == 1){
        $gateways = Gateway::where('status',1)->get();
        return view('Admin.pay-account.add_pay_account',compact('gateways','gsd'));
        }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    } 
    
    public function payaccount_store(Request $request){
        $gsd = global_user_data();
        if (Auth::id() == 1 || permission_checker($gsd->role_info,'account_manage') == 1){
        $payAccount = new PayAccounts();
        $payAccount->gateway_id = $request->gateway_id;
        $payAccount->user_id = Auth::id();
        $payAccount->account = $request->account_number;
        $payAccount->charge = $request->charge;
        $payAccount->description = $request->account_details;
        if ($request->hasFile('account_qr')) {
            $image = $request->file('account_qr');
            $request->validate([
                'account_qr' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
        
            $dt = Carbon::now()->format('Ymd_His_u');
            $image_name = $dt . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $folder_path = 'payment-account/';
            $image_resized = Image::make($image)->encode();
            Storage::disk('img_disk')->put($folder_path . $image_name, $image_resized->__toString());
            $payAccount->account_qr_code = $image_name;
        }

        $payAccount->status = 1;
      
        $payAccount->save();
        notify()->success('Success');
        return redirect()->route('pay_accounts');
    }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    } 
    
    public function payaccount_edit_account(Request $request){
        $gsd = global_user_data();
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'account_manage') == 1){
        $gateways = Gateway::where('status',1)->get();
        $account = PayAccounts::where('id',$request->id)->first();
        return view('Admin.pay-account.edit_pay_account',compact('gateways','gsd','account'));
    }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    } 
    
    public function payaccount_update_account(Request $request){
       
        $gsd = global_user_data();
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'account_manage') == 1){
        $payAccount = PayAccounts::where('id',$request->id)->first();
        $payAccount->gateway_id = $request->gateway_id;
        $payAccount->user_id = Auth::id();
        $payAccount->account = $request->account_number;
        $payAccount->charge = $request->charge;
        $payAccount->description = $request->account_details;

       
        if ($request->hasFile('account_qr')) {
            $image = $request->file('account_qr');
            $dt = Carbon::now()->format('Ymd_His_u');
            $image_name = $dt . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $folder_path = 'payment-account/';
            if ($payAccount->account_qr_code) {
                $old_path = $folder_path . $payAccount->account_qr_code;
                if (Storage::disk('img_disk')->exists($old_path)) {
                    Storage::disk('img_disk')->delete($old_path);
                }
            }
            $image_resized = Image::make($image)->encode();
            Storage::disk('img_disk')->put($folder_path . $image_name, $image_resized->__toString());
            $payAccount->account_qr_code = $image_name;
        }

        $payAccount->status = 1;
      
        $payAccount->save();
        notify()->success('Success');
        return redirect()->route('pay_accounts');
    }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    } 
    
    public function payaccount_remove_account(Request $request){
        $gsd = global_user_data();
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'account_manage') == 1){
            

            $payAccount = PayAccounts::findOrFail($request->id);
            $folder_path = 'payment-account/';
        
            if ($payAccount->account_qr_code) {
                $file_path = $folder_path . $payAccount->account_qr_code;
        
                if (Storage::disk('img_disk')->exists($file_path)) {
                    Storage::disk('img_disk')->delete($file_path);
                }
        
            }
        PayAccounts::destroy($request->id);
        notify()->success('Remove Success');
        return back();
    }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    }
}
