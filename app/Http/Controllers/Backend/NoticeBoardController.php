<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NoticeBoard;
use App\Models\User;
use App\Jobs\SendBulkSmsJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

class NoticeBoardController extends Controller
{
    
    
    
    
     public function sms_sender_option(){
        $gsd = global_user_data();
       $Notice = NoticeBoard::where('id',1)->first();
       return view('Admin.sms.sender',compact('Notice','gsd'));
    }
    
    
      public function sms_sending_records(){
        $gsd = global_user_data();
       $Notice = NoticeBoard::where('id',1)->first();
       return view('Admin.sms.records',compact('Notice','gsd'));
    }
    
public function sms_sending_action(Request $request)
{
    $gsd = global_user_data();
    $phoneNumbers = [];

    if ($request->sms_type == 'auto') {
        $users = User::all();

        foreach ($users as $user) {
            // Validate phone numbers
            if (!empty($user->phone) && is_numeric($user->phone) && strlen($user->phone) >= 11) {
                $phoneNumbers[] = $user->phone;
            }
        }

        // Remove duplicates
        $uniqueNumbers = array_unique($phoneNumbers);

        if (!empty($uniqueNumbers)) {
            // Dispatch job for background SMS sending
            SendBulkSmsJob::dispatch($request->sms_body, $uniqueNumbers);
            notify()->success('SMS is being sent in the background!');
        } else {
            notify()->error('No valid phone numbers found for sending SMS.');
        }
    } else {
        $manualNumbers = array_filter(explode(',', $request->manual_sms_numbers), 'trim');

        if (empty($manualNumbers)) {
            notify()->error('Manual phone numbers are required!');
        } else {
            // Dispatch job for background SMS sending
            SendBulkSmsJob::dispatch($request->sms_body, $manualNumbers);
              Artisan::call('queue:work', [
        '--stop-when-empty' => true
    ]);
            notify()->success('SMS is being sent in the background!');
        }
    }

    return back();
}

    
    
    
    
    
    public function index(){
        $gsd = global_user_data();
       $Notice = NoticeBoard::where('id',1)->first();
       return view('Admin.NoticeBoard.index',compact('Notice','gsd'));
    }
    
    
    
    
    
    
    
    
    
    public function update(Request $request){
        $gsd = global_user_data();
   if (Auth::id() == 1 || permission_checker($gsd->role_info,'notice_manage') == 1){
       $Notice = NoticeBoard::where('id',1)->first();
       $Notice->content = $request->notice;
       $Notice->save();
       return back();
   }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    }
}
