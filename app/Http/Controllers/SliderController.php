<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Image;
use App\Models\Slider;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    public function index(){
        $gsd = global_user_data();
        $sliders =  Slider::latest('id')->paginate(10);
       
       return view('Admin.sliders.index',compact('sliders','gsd'));
   }
   
   public function create(){
       $gsd = global_user_data();
       return view('Admin.sliders.create',compact('gsd'));
   }
   
 
   
   public function store(Request $request){
       $gsd = global_user_data();
       if (Auth::id() == 1 || permission_checker($gsd->role_info,'order_manage') == 1){
       
        $slider = new Slider();
        $slider->name = $request->name;
 
        
       if ($request->slug == '') {
           $slider->slug = Str::slug($request->name); 
       }else{
           $slider->slug = $request->slug;
       }
        
        $slider->target_link = $request->target_link;
        
        if($request->hasFile('media_file')){
         
           $dt = Carbon::now();
           $micro = $dt->micro;
           $image_obj = $request->file('media_file');
        
           $orpath = storage_path('app/public/uploads/slider');
           folderCreate($orpath);
           $ex_small_path = storage_path('app/public/uploads/slider/extra_small');
           folderCreate($ex_small_path);
           $small_path = storage_path('app/public/uploads/slider/small');
           folderCreate($small_path);
           $medium_path = storage_path('app/public/uploads/slider/medium');
           folderCreate($medium_path);
           $large_path = storage_path('app/public/uploads/slider/large');
           folderCreate($large_path);
           
           $public_path = 'storage/uploads/slider';
           folderCreate($public_path);
     
           
           $image_name = $micro.$image_obj->getClientOriginalName();
          
           $img1 = Image::make($image_obj)->save($orpath.'/'.$image_name);
           
           $img2 = Image::make($image_obj)->resize(null, 200, function ($constraint) {
                $constraint->aspectRatio();
           })->save($small_path.'/'.$image_name);
           
           $img3 = Image::make($image_obj)->resize(null, 400, function ($constraint) {
                $constraint->aspectRatio();
           })->save($medium_path.'/'.$image_name);
           
           $img4 = Image::make($image_obj)->resize(null, 600, function ($constraint) {
                $constraint->aspectRatio();
           })->save($large_path.'/'.$image_name);
           
              $img5 = Image::make($image_obj)->resize(null, 50, function ($constraint) {
                $constraint->aspectRatio();
           })->save($ex_small_path.'/'.$image_name);
          
        $slider->created_by = $gsd->id;
        $slider->image_name = $image_name;
        $slider->image_path = $public_path."/";
       }
        
 
        $slider->slider_type = 'home';
        $slider->status = $request->status;
        $slider->save();
        notify()->success('Slider Created Success !');
        return back();
       }else{
             notify()->error('Permission Not Allow !');
           return back();
       }
   }
   
   public function edit(Request $request){
        $gsd = global_user_data();
        $slider =  Slider::where('id',$request->id)->first();
       

       return view('Admin.sliders.edit',compact('slider','gsd'));
   }
   
   public function update(Request $request){
       $gsd = global_user_data();
       if (Auth::id() == 1 || permission_checker($gsd->role_info,'order_manage') == 1){
        $slider =  Slider::where('id',$request->id)->first();
        $slider->name = $request->name;
 
       if ($request->slug == '') {
           $slider->slug = Str::slug($request->name); 
       }else{
           $slider->slug = $request->slug;
       }
        
        $slider->target_link = $request->target_link;
        
          if($request->hasFile('media_file')){
         
         if($slider){
         fileDelete($slider->image_path.$slider->image_name);
         fileDelete($slider->image_path.'small/'.$slider->image_name);
         fileDelete($slider->image_path.'large/'.$slider->image_name);
         fileDelete($slider->image_path.'medium/'.$slider->image_name);
         fileDelete($slider->image_path.'extra_small/'.$slider->image_name);   
       }
       
           $dt = Carbon::now();
           $micro = $dt->micro;
           $image_obj = $request->file('media_file');
        
           $orpath = storage_path('app/public/uploads/slider/');
           
           $ex_small_path = storage_path('app/public/uploads/slider/extra_small/');
           $small_path = storage_path('app/public/uploads/slider/small/');
           $medium_path = storage_path('app/public/uploads/slider/medium/');
           $large_path = storage_path('app/public/uploads/slider/large/');
           
           $public_path = 'storage/uploads/slider/';
     
           
           $image_name = $micro.$image_obj->getClientOriginalName();
          
           $img1 = Image::make($image_obj)->save($orpath.'/'.$image_name);
           
           $img2 = Image::make($image_obj)->resize(null, 200, function ($constraint) {
                $constraint->aspectRatio();
           })->save($small_path.'/'.$image_name);
           
           $img3 = Image::make($image_obj)->resize(null, 400, function ($constraint) {
                $constraint->aspectRatio();
           })->save($medium_path.'/'.$image_name);
           
           $img4 = Image::make($image_obj)->resize(null, 600, function ($constraint) {
                $constraint->aspectRatio();
           })->save($large_path.'/'.$image_name);
           
              $img5 = Image::make($image_obj)->resize(null, 50, function ($constraint) {
                $constraint->aspectRatio();
           })->save($ex_small_path.'/'.$image_name);
          
 
        $slider->image_name = $image_name;
        $slider->image_path = $public_path;
       }
       $slider->status = $request->status;
       $slider->updated_by = $gsd->id;
        $slider->save();
             notify()->success('Slider Updated Success !');
        return back();
    
       }else{
             notify()->error('Permission Not Allow !');
           return back();
       }
   }
   
   public function remove(Request $request){
   
   $gsd = global_user_data();
       if (Auth::id() == 1 || permission_checker($gsd->role_info,'order_manage') == 1){
       $slider =  Slider::where('id',$request->id)->first();
       if($slider){
         fileDelete($slider->image_path.$slider->image_name);
         fileDelete($slider->image_path.'small/'.$slider->image_name);
         fileDelete($slider->image_path.'large/'.$slider->image_name);
         fileDelete($slider->image_path.'medium/'.$slider->image_name);
         fileDelete($slider->image_path.'extra_small/'.$slider->image_name);   
       }
        
         
       Slider::destroy($request->id);
        notify()->success('Slider Remove Success !');
        return back();
       }else{
             notify()->error('Permission Not Allow !');
           return back();
       }
   }
}
