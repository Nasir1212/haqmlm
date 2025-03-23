<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;
use Carbon\Carbon;
use Image;
class ContentFilemanager extends Controller
{

    public function index(Request $request){
        $gsd = global_user_data();
        $datas = Upload::latest()->paginate(5);
        return view('filemanager',compact('datas','gsd'));
   } 
   
   public function Selector(Request $request){
        $data = "ready";
        
   } 
   public function file_upload(Request $request){
        $data = "file_browse";
     
   }
    public function file_browse(Request $request){
        $gsd = global_user_data();
        $datas = Upload::latest()->paginate(5);
        return view('filemanager',compact('datas','gsd'));
        
   }

    public function Upload(Request $request){
           $gsd = global_user_data();
            $upload = new Upload();
            $dt = Carbon::now();
            $micro = $dt->micro;
            $image_obj = $request->file('upload');
         
            $orpath = storage_path('app/public/uploads/content-details/');
            $public_path = 'storage/uploads/content-details/';
            $image_name = $micro.$image_obj->getClientOriginalName();
           
            Image::make($image_obj)->save($orpath.'/'.$image_name);
            $upload->path = $public_path;
            $upload->name = $image_name;
            $upload->media_type = $request->media_type;
            $upload->uploader_id = $gsd->id;
            $upload->save();

            $url = asset('storage/uploads/content-details/'.$image_name); 
            $response = [
                'url' => $url,
                'uploaded' => $url
            ];
   
        return response()->json($response);
    }
}
