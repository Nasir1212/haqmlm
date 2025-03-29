<?php

namespace App\Http\Controllers;
use App\Models\PointSubmitHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\WgbTransaction;
use App\Models\SpbTransaction;
use App\Models\NwmtgTransaction;
use App\Models\NwmtbTransaction;
use App\Models\ReferBonusTransaction;
use App\Models\DirectBonusTransaction;
use App\Models\User;
use App\Models\BalanceTransferRecord;
use App\Models\AdminBalanceSendRecord;
use Carbon\Carbon;
use Mpdf\Mpdf;
class ReportController extends Controller
{

public function Transaction_report_sheet(Request $request){
 
    
    $setting = setting();

    $gsd = global_user_data();
    if($request->date){
        if(isset($request->username)){
            $user = User::where('username',$request->username)->first(['username','id','name','sponsor_id']);
            
            if(Auth::id() == 1){
                if($user){
                    $refer = User::where('id',$user->sponsor_id)->first(['username','id','name']);
                    $now = Carbon::parse($request->date);
                    $ddt = $now->format('F Y');
                    $now =  $now->addMonth();
                    
                    $pointhistory = PointSubmitHistory::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->first();
                    $DirectBonusTransaction = DirectBonusTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $ReferBonusTransaction = ReferBonusTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $NwmtbTransaction = NwmtbTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $NwmtgTransaction = NwmtgTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $WgbTransaction = WgbTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $SpbTransaction = SpbTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $monthly_income = ['SpbTransaction'=>$SpbTransaction,'DirectBonusTransaction'=>$DirectBonusTransaction,'ReferBonusTransaction'=>$ReferBonusTransaction,'NwmtbTransaction'=>$NwmtbTransaction,'NwmtgTransaction'=>$NwmtgTransaction,'WgbTransaction'=>$WgbTransaction];
                    // $pdf = PDF::loadView('Admin.report-pdf',compact('monthly_income','setting','ddt','user','refer','pointhistory'))->setOptions([ 'mode'=>'UTF-8',
                    //     'format' => 'A4','dpi' => 150,'images' => true, "isJavascriptEnabled"=>true, "enable_php" => true, 'isHtml5ParserEnabled', true ]);
                   // return $pdf->stream('product.pdf');
               return     $html = view('Admin.report-pdf',compact('monthly_income','setting','ddt','user','refer','pointhistory'))->render();
                    
                          
        //             $mpdf = new Mpdf([
        //     'mode' => 'utf-8', // Enable UTF-8
        //     'format' => 'A4',
        //     'default_font' => 'dejavusans', // Default font, for English
        // ]);
     // Use the custom Bangla font in the HTML content
      //  $mpdf->WriteHTML($html);
    
        // Return the PDF as a download response
        // return response()->stream(
        //     function () use ($mpdf) {
        //         $mpdf->Output();
        //     },
        //     200,
        //     [
        //         'Content-Type' => 'application/pdf',
        //         'Content-Disposition' => 'attachment; filename="invoice.pdf"',
        //     ]
        // );
                    
                    
                    
                }else{
                    // user not found
                }
                
            }else{
                // admin or not allow
            }
        

        }else{
            $user = $gsd;
        
            $refer = User::where('id',$gsd->sponsor_id)->first(['username','id','name']);
            $now = Carbon::parse($request->date);
            $ddt = $now->format('F Y');
            $now =  $now->addMonth();
            $pointhistory = PointSubmitHistory::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->first();
            $DirectBonusTransaction = DirectBonusTransaction::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
            $ReferBonusTransaction = ReferBonusTransaction::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
            $NwmtbTransaction = NwmtbTransaction::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
            $NwmtgTransaction = NwmtgTransaction::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
            $WgbTransaction = WgbTransaction::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
             $SpbTransaction = SpbTransaction::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
            $monthly_income = ['SpbTransaction'=>$SpbTransaction,'DirectBonusTransaction'=>$DirectBonusTransaction,'ReferBonusTransaction'=>$ReferBonusTransaction,'NwmtbTransaction'=>$NwmtbTransaction,'NwmtgTransaction'=>$NwmtgTransaction,'WgbTransaction'=>$WgbTransaction];
            // $pdf = PDF::loadView('Admin.report-pdf',compact('monthly_income','setting','ddt','user','refer','pointhistory'))->setOptions([ 'mode'=>'UTF-8',
            //     'format' => 'A4','dpi' => 150,'images' => true, "isJavascriptEnabled"=>true, "enable_php" => true, 'isHtml5ParserEnabled', true ]);
           // return $pdf->stream('product.pdf');
            
           return  $html = view('Admin.report-pdf',compact('monthly_income','setting','ddt','user','refer','pointhistory'))->render();
            
            
                    $mpdf = new Mpdf([
            'mode' => 'utf-8', // Enable UTF-8
            'format' => 'A4',
            'default_font' => 'dejavusans', // Default font, for English
        ]);
     // Use the custom Bangla font in the HTML content
        $mpdf->WriteHTML($html);
    
        // Return the PDF as a download response
        return response()->stream(
            function () use ($mpdf) {
                $mpdf->Output();
            },
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="invoice.pdf"',
            ]
        );
            
        }
    }else{
      
        $refer = User::where('id',$gsd->sponsor_id)->first(['username','id','name']);
        $user = $gsd;
        $now = Carbon::now();
        $ddt = $now->format('F Y');
        $pointhistory = PointSubmitHistory::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->first();
        $DirectBonusTransaction = DirectBonusTransaction::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
        $ReferBonusTransaction = ReferBonusTransaction::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
        $NwmtbTransaction = NwmtbTransaction::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
        $NwmtgTransaction = NwmtgTransaction::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
        $WgbTransaction = WgbTransaction::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
        $SpbTransaction = SpbTransaction::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
        $monthly_income = ['SpbTransaction'=>$SpbTransaction,'DirectBonusTransaction'=>$DirectBonusTransaction,'ReferBonusTransaction'=>$ReferBonusTransaction,'NwmtbTransaction'=>$NwmtbTransaction,'NwmtgTransaction'=>$NwmtgTransaction,'WgbTransaction'=>$WgbTransaction];
    
    
        // $pdf = PDF::loadView('Admin.report-pdf',compact('monthly_income','setting','ddt','refer','user','pointhistory'))->setOptions([ 'mode'=>'UTF-8',
        //     'format' => 'A4','dpi' => 150,'images' => true, "isJavascriptEnabled"=>true, "enable_php" => true, 'isHtml5ParserEnabled', true ]);
           
         //  return $pdf->stream('product.pdf');
           
      return     $html = view('Admin.report-pdf',compact('monthly_income','setting','ddt','refer','user','pointhistory'))->render();
              
                    $mpdf = new Mpdf([
            'mode' => 'utf-8', // Enable UTF-8
            'format' => 'A4',
            'default_font' => 'dejavusans', // Default font, for English
        ]);
     // Use the custom Bangla font in the HTML content
        $mpdf->WriteHTML($html);
    
        // Return the PDF as a download response
        return response()->stream(
            function () use ($mpdf) {
                $mpdf->Output();
            },
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="invoice.pdf"',
            ]
        );
           
    }

}


    public function Transaction_list(Request $request){
     
       $gsd = global_user_data();
       $trx_cond = $request->remark;
       $monthly_income_part = 0;
       $monthly_income = [];
       $userinfo = 0;
    
        if(Auth::id() == 1){

            if($trx_cond == 'income_filter'){
                $monthly_income_part = 1;
                $now = Carbon::parse($request->date)->addMonth();
                if(isset($request->username)){
                    $user = User::where('username',$request->username)->with('sponsor')->first();
                    if($user){
                        $userinfo = 1;
                 
                    $DirectBonusTransaction = DirectBonusTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $ReferBonusTransaction = ReferBonusTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $NwmtbTransaction = NwmtbTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $NwmtgTransaction = NwmtgTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $WgbTransaction = WgbTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $SpbTransaction = SpbTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $monthly_income = ['DirectBonusTransaction'=>$DirectBonusTransaction,'ReferBonusTransaction'=>$ReferBonusTransaction,'NwmtbTransaction'=>$NwmtbTransaction,'NwmtgTransaction'=>$NwmtgTransaction,'WgbTransaction'=>$WgbTransaction,'SpbTransaction'=>$SpbTransaction];
                    return view('Admin.transactions',compact('monthly_income','gsd','monthly_income_part','user','userinfo'));      
                }
              }    
            }



            if(isset($request->username)){
                $user = User::where('username',$request->username)->with('sponsor')->first();
                if($user){
                    $userinfo = 1;
                    if($trx_cond ==  'point_history'){
                        $monthly_income_part = 2;
                       $pointHistory = PointSubmitHistory::where('user_id',$gsd->id)->with('user')->latest('id')->paginate(20);
                       $pointHistory->appends(['username' => $request->username, 'remark' => $trx_cond ]);
                       return view('Admin.transactions',compact('pointHistory','gsd','monthly_income_part','user','userinfo'));
                    }

                    if($trx_cond == 'monthly_income'){

                        $monthly_income_part = 1;
                        $now = Carbon::now()->addMonth();
                     
                        $DirectBonusTransaction = DirectBonusTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                        $ReferBonusTransaction = ReferBonusTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                        $NwmtbTransaction = NwmtbTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                        $NwmtgTransaction = NwmtgTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                        $WgbTransaction = WgbTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                        $SpbTransaction = SpbTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                        $monthly_income = ['DirectBonusTransaction'=>$DirectBonusTransaction,'ReferBonusTransaction'=>$ReferBonusTransaction,'NwmtbTransaction'=>$NwmtbTransaction,'NwmtgTransaction'=>$NwmtgTransaction,'WgbTransaction'=>$WgbTransaction,'SpbTransaction'=>$SpbTransaction];
                        return view('Admin.transactions',compact('monthly_income','gsd','monthly_income_part','user','userinfo'));
                    }


                    if($trx_cond == 'auto_point_submit_history'){
                        $transactions = Transaction::where('remark','auto_pv_submit')->where('user_id',$user->id)->with('userdata')->latest('id')->paginate(20);
                    }
                    if($trx_cond == 'refer_bonus'){
                        $transactions = ReferBonusTransaction::where('user_id',$user->id)->with('userdata')->latest('id')->paginate(20);
                    }
                    if($trx_cond == 'direct_bonus'){
                        $transactions = DirectBonusTransaction::where('user_id',$user->id)->with('userdata')->latest('id')->paginate(20);
                    }

                    if($trx_cond == 'working_bonus'){
                        $transactions = WgbTransaction::where('user_id',$user->id)->with('userdata')->latest('id')->paginate(20);
                    }
                    if($trx_cond == 'sponsor_bonus'){
                        $transactions = SpbTransaction::where('user_id',$user->id)->with('userdata')->latest('id')->paginate(20);
                    }
                    if($trx_cond == 'non_working_gen_bonus'){
                        $transactions = NwmtgTransaction::where('user_id',$user->id)->with('userdata')->latest('id')->paginate(20);
                    }

                    if($trx_cond == 'non_working_matrix_bonus'){
                        $transactions = NwmtbTransaction::where('user_id',$user->id)->with('userdata')->latest('id')->paginate(20);
                    } 
                    
                    if($trx_cond == 'life_tile_insentive' || $trx_cond == 'qualify_yearly_bonus' || $trx_cond == 'death_benefit' || $trx_cond == 'withdraw' || $trx_cond == 'deposit'){
                        $transactions = Transaction::where('user_id',$user->id)->with('userdata')->latest('id')->paginate(20);
                    }

                    $transactions->appends(['username' => $request->username,'remark' => $trx_cond]);
                }else{
                    notify()->error('User Not Found!');
                    return back();
                }
                
            }else{
                $user = [];
                if($trx_cond == 'working_bonus'){
                    $transactions = WgbTransaction::with('userdata')->latest('id')->paginate(20);
                }
             if($trx_cond == 'sponsor_bonus'){
                    $transactions = SpbTransaction::with('userdata')->latest('id')->paginate(20);
                }
                if($trx_cond == 'non_working_gen_bonus'){
                    $transactions = NwmtgTransaction::with('userdata')->latest('id')->paginate(20);
                }

                if($trx_cond == 'non_working_matrix_bonus'){
                    $transactions = NwmtbTransaction::with('userdata')->latest('id')->paginate(20);
                } 
                
                if($trx_cond == 'auto_point_submit_history'){
                    $transactions = Transaction::where('remark','auto_pv_submit')->with('userdata')->latest('id')->paginate(20);
                }

                if($trx_cond == 'refer_bonus'){
                    $transactions = ReferBonusTransaction::with('userdata')->latest('id')->paginate(20);
                }
                if($trx_cond == 'direct_bonus'){
                    $transactions = DirectBonusTransaction::with('userdata')->latest('id')->paginate(20);
                }
                if($trx_cond ==  'point_history'){
                    $monthly_income_part = 2;
                   $pointHistory = PointSubmitHistory::latest('id')->paginate(20);
                   
                   $pointHistory->appends(['remark' => $trx_cond ]);
                   return view('Admin.transactions',compact('pointHistory','gsd','monthly_income_part','userinfo'));
                }
                if($trx_cond == 'monthly_income'){
                    $monthly_income_part = 1;
                    $now = Carbon::now()->addMonth();
                 
                    $DirectBonusTransaction = DirectBonusTransaction::whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $ReferBonusTransaction = ReferBonusTransaction::whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $NwmtbTransaction = NwmtbTransaction::whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $NwmtgTransaction = NwmtgTransaction::whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $WgbTransaction = WgbTransaction::whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $SpbTransaction = SpbTransaction::whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $monthly_income = ['DirectBonusTransaction'=>$DirectBonusTransaction,'ReferBonusTransaction'=>$ReferBonusTransaction,'NwmtbTransaction'=>$NwmtbTransaction,'NwmtgTransaction'=>$NwmtgTransaction,'WgbTransaction'=>$WgbTransaction,'SpbTransaction'=>$SpbTransaction];
                   $dwnhidden = 1;
                    return view('Admin.transactions',compact('monthly_income','gsd','monthly_income_part','dwnhidden','userinfo'));
                }

                if($trx_cond == 'life_tile_insentive' || $trx_cond == 'qualify_yearly_bonus' || $trx_cond == 'death_benefit' || $trx_cond == 'withdraw' || $trx_cond == 'deposit'){
                    $transactions = Transaction::with('userdata')->latest('id')->paginate(20);
                }


                if($trx_cond ==  'date_point_history'){
                    $monthly_income_part = 2;
                    $userinfo = 1;
                    $user = User::where('id',$gsd->id)->with('sponsor')->first();
                    $now = Carbon::parse($request->date);
                    $pointHistory = PointSubmitHistory::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->latest('id')->paginate(20);
                    $pointHistory->appends(['remark' => $trx_cond,'date'=>$request->date]);
                   
                    return view('Admin.transactions',compact('pointHistory','gsd','monthly_income_part','userinfo','user'));
                }

                if($trx_cond == 'income_filter'){
                    $monthly_income_part = 1;
                    $now = Carbon::parse($request->date)->addMonth();
                    if(isset($request->username)){
                        $user = User::where('username',$request->username)->with('sponsor')->first();
                        if($user){
                            $userinfo = 1;
                     
                        $DirectBonusTransaction = DirectBonusTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                        $ReferBonusTransaction = ReferBonusTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                        $NwmtbTransaction = NwmtbTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                        $NwmtgTransaction = NwmtgTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                        $WgbTransaction = WgbTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                        $SpbTransaction = SpbTransaction::where('user_id',$user->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                        $monthly_income = ['DirectBonusTransaction'=>$DirectBonusTransaction,'ReferBonusTransaction'=>$ReferBonusTransaction,'NwmtbTransaction'=>$NwmtbTransaction,'NwmtgTransaction'=>$NwmtgTransaction,'WgbTransaction'=>$WgbTransaction,'SpbTransaction'=>$SpbTransaction];
                        return view('Admin.transactions',compact('monthly_income','gsd','monthly_income_part','userinfo','user'));      
                    }
                }  
                }
           

                if($trx_cond == 'self_pv_submit'){
                    $transactions = DirectBonusTransaction::where('user_id',$gsd->id)->with('userdata')->latest('id')->paginate(20);
                }

                  $transactions->appends(['remark' => $trx_cond]);
                 
            }
           
             }else{
                $userinfo = 1;
                $user = User::where('id',$gsd->id)->with('sponsor')->first();
                if($trx_cond == 'working_bonus'){
                    $transactions = WgbTransaction::where('user_id',$gsd->id)->with('userdata')->latest('id')->paginate(20);
                }
            if($trx_cond == 'sponsor_bonus'){
                    $transactions = SpbTransaction::where('user_id',$gsd->id)->with('userdata')->latest('id')->paginate(20);
                }

                if($trx_cond == 'non_working_gen_bonus'){
                    $transactions = NwmtgTransaction::where('user_id',$gsd->id)->with('userdata')->latest('id')->paginate(20);
                }

                if($trx_cond == 'non_working_matrix_bonus'){
                    $transactions = NwmtbTransaction::where('user_id',$gsd->id)->with('userdata')->latest('id')->paginate(20);
                } 
                if($trx_cond == 'auto_point_submit_history'){
                    $transactions = Transaction::where('remark','auto_pv_submit')->where('user_id',$gsd->id)->with('userdata')->latest('id')->paginate(20);
                }
                if($trx_cond == 'refer_bonus'){
                    $transactions = ReferBonusTransaction::where('user_id',$gsd->id)->with('userdata')->latest('id')->paginate(20);
                }
                if($trx_cond == 'direct_bonus'){
                    $transactions = DirectBonusTransaction::where('user_id',$gsd->id)->with('userdata')->latest('id')->paginate(20);
                }
               

                if($trx_cond == 'life_tile_insentive' || $trx_cond == 'qualify_yearly_bonus' || $trx_cond == 'death_benefit' || $trx_cond == 'withdraw' || $trx_cond == 'deposit'){
                    $transactions = Transaction::where('user_id',$gsd->id)->with('userdata')->latest('id')->paginate(20);
                }

                if($trx_cond ==  'point_history'){
                 
                    $monthly_income_part = 2;
                   $pointHistory = PointSubmitHistory::where('user_id',$gsd->id)->latest('id')->paginate(20);
                 dd(Transaction::where('remark','point_history')->get());
                   $pointHistory->appends(['remark' => $trx_cond]);
                   
                   return view('Admin.transactions',compact('pointHistory','gsd','monthly_income_part','userinfo','user'));
                }

                if($trx_cond == 'monthly_income'){
                    $monthly_income_part = 1;
                    $now = Carbon::now()->addMonth();
                    $ddt = $now->format('F Y');
                    $userinfo = 1;
                    $DirectBonusTransaction = DirectBonusTransaction::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $ReferBonusTransaction = ReferBonusTransaction::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $NwmtbTransaction = NwmtbTransaction::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $NwmtgTransaction = NwmtgTransaction::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $WgbTransaction = WgbTransaction::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $SpbTransaction = SpbTransaction::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $monthly_income = ['DirectBonusTransaction'=>$DirectBonusTransaction,'ReferBonusTransaction'=>$ReferBonusTransaction,'NwmtbTransaction'=>$NwmtbTransaction,'NwmtgTransaction'=>$NwmtgTransaction,'WgbTransaction'=>$WgbTransaction,'SpbTransaction'=>$SpbTransaction];
                    return view('Admin.transactions',compact('monthly_income','gsd','monthly_income_part','userinfo','user'));
                }

                if($trx_cond == 'income_filter'){
                    $monthly_income_part = 1;
                    $now = Carbon::parse($request->date)->addMonth();
                    $userinfo = 1;
                    $DirectBonusTransaction = DirectBonusTransaction::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $ReferBonusTransaction = ReferBonusTransaction::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $NwmtbTransaction = NwmtbTransaction::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $NwmtgTransaction = NwmtgTransaction::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $WgbTransaction = WgbTransaction::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $SpbTransaction = SpbTransaction::where('user_id',$gsd->id)->whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                    $monthly_income = ['DirectBonusTransaction'=>$DirectBonusTransaction,'ReferBonusTransaction'=>$ReferBonusTransaction,'NwmtbTransaction'=>$NwmtbTransaction,'NwmtgTransaction'=>$NwmtgTransaction,'WgbTransaction'=>$WgbTransaction,'SpbTransaction'=>$SpbTransaction];
                    return view('Admin.transactions',compact('monthly_income','gsd','monthly_income_part','userinfo','user'));
                }
                
            
                $transactions->appends(['remark' => $trx_cond]);
       
        }
       
       
        return view('Admin.transactions',compact('monthly_income','transactions','gsd','monthly_income_part','userinfo','user'));
    }
    
     public function balance_transfer_records(Request $request){
       $gsd = global_user_data();
        if (Auth::id() == 1 || permission_checker($gsd->role_info,'balance_transfer_record_check') == 1){
            // Initialize the base query
$query = BalanceTransferRecord::latest('id')->with(['sender', 'receiver']);

if (isset($request->date)) {
    // Filter by date if provided
    $query->whereDate('created_at', $request->date);
} elseif (isset($request->name)) {
    // Find user by name if provided
    $user = User::where('username', $request->name)->first();
    
    if ($user) {
        // Filter by user ID if user is found
        $query->where(function($q) use ($user) {
            $q->where('sender_id', $user->id)
              ->orWhere('receiver_id', $user->id);
        });
    } else {
        // Handle case where user is not found (optional)
        $query->whereRaw('1 = 0'); // No results
    }
}

// Execute the query and get results
$btsrs = $query->get();

        
        }else{
          
              
              $query = BalanceTransferRecord::latest('id')->with(['sender', 'receiver']);

// Check if a date is provided
if (isset($request->date)) {
    // Filter by date and sender/receiver ID
    $query->whereDate('created_at', $request->date)
          ->where(function($q) use ($gsd) {
              $q->where('sender_id', $gsd->id)
                ->orWhere('receiver_id', $gsd->id);
          });
} else {
    // Filter by sender/receiver ID only
    $query->where(function($q) use ($gsd) {
        $q->where('sender_id', $gsd->id)
          ->orWhere('receiver_id', $gsd->id);
    });
}

// Execute the query and get results
$btsrs = $query->get();
              
              
        }
       
       return view('Admin.report.balance-transfer',compact('btsrs','gsd'));
        
    }
    
    
}
