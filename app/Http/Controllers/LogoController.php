<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogoSetting;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class LogoController extends Controller
{
    public function Index(){
        
         $gsd = global_user_data();
         $page_title = "Logo Updater";
        if(Auth::id() == 1){
        $logo_setting = logoSetting::where('id',1)->first();
        
        return view('Admin.settings.logo-changer',compact('page_title','logo_setting','gsd'));
        }else{
            return back();
        }
    
    }

    public function Update(Request $request){
        

        $logo_setting = logoSetting::where('id',1)->first();

     
        if(!empty($request->thumbnail)){
            
            try {
        
                $localImagePath = 'assets/';
                $imageName = 'logo.png'; // Rename the image
                $orginal_file = public_path($localImagePath.$imageName);
                if(file_exists($orginal_file)){
                    unlink($orginal_file);
                  }
                  
              $request->thumbnail->move(public_path('assets'), $imageName);
                  
                //   File::copy(public_path($orginal_file), public_path($localImagePath.$imageName));
            } catch (\Exception $e) {
              
            }


            $logo_setting->name = $imageName;
            $logo_setting->path = $localImagePath;
            
          }

        $logo_setting->save();
        return back();
    }
}
