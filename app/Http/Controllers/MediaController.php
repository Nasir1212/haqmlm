<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Image;
class MediaController extends Controller
{
    public function index(Request $request){
        $gsd = global_user_data();
        if (Auth::id() == 1) {
            if (isset($request->media_typer)) {
                $media_list = Upload::latest('id')->where('media_type', $request->media_typer)->get();
            }else{
                $media_list = Upload::latest('id')->get();
            }
        }else{
            if (isset($request->media_typer)) {
                $media_list = Upload::where('uploader_id', $gsd->id)->latest('id')->where('media_type', $request->media_typer)->get();
            }else{
                $media_list = Upload::where('uploader_id', $gsd->id)->latest('id')->get();
            } 
        }
        
        

        return view('Uploads.index', compact('media_list','gsd'));
   
    }



    public function store(Request $request){
        $gsd = global_user_data();
        if($request->hasFile('media_file')){
           $media = new Upload();
            $dt = Carbon::now();
            $micro = $dt->micro;
            $image_obj = $request->file('media_file');
         
            $orpath = storage_path('app/public/uploads/'.$request->media_type.'/');
           
            $public_path = 'storage/uploads/'.$request->media_type.'/';
            $image_name = $micro.$image_obj->getClientOriginalName();
           
            Image::make($image_obj)->save($public_path.'/'.$image_name);
            $media->path = $public_path;
            $media->name = $image_name;
            $media->media_type = $request->media_type;
            $media->uploader_id = $gsd->id;
            $media->save();
            notify()->success('Media Upload Success!');
            return back();
        }else{
            
            notify()->error('Sorry Something Wrong!');
            return back();
        }

    }

    public function remove(Request $request){
        $media = Upload::where('id', $request->id)->first();
        $orpath = storage_path('app/public/uploads/'.$media->media_type.'/').$media->name;
       
        
        Upload::destroy($media->id);
         unlink($orpath);
        return back();
    }
}
