<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Image;
use Illuminate\Support\Str;

class PageController extends Controller
{
     public function page_list(){
        $gsd = global_user_data();
        $pages =  Page::latest('id')->paginate(10);
       
       return view('Admin.page.index',compact('pages','gsd'));
    } 
    public function get_page(){
   
    }

    public function add_page(){
        $gsd = global_user_data();
        return view('Admin.page.create',compact('gsd'));
    }

    public function store_page(Request $request){
        $gsd = global_user_data();
        if (Auth::id() == 1 || perpage_checker($gsd->role_info,'page_manage') == 1){
        
         $page = new Page();
         $page->name = $request->name;
  
         
        if ($request->slug == '') {
            $page->slug = Str::slug($request->name); 
        }else{
            $page->slug = $request->slug;
        }
         
         $page->content = $request->content;
         
         if($request->hasFile('media_file')){
          
            $dt = Carbon::now();
            $micro = $dt->micro;
            $image_obj = $request->file('media_file');
            
      
            $orpath = storage_path('app/public/uploads/page');
            folderCreate($orpath);
            $ex_small_path = storage_path('app/public/uploads/page/extra_small');
            folderCreate($ex_small_path);
            $small_path = storage_path('app/public/uploads/page/small');
            folderCreate($small_path);
            $medium_path = storage_path('app/public/uploads/page/medium');
            folderCreate($medium_path);
            $large_path = storage_path('app/public/uploads/page/large');
            folderCreate($large_path);
            $public_path = 'storage/uploads/page';
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
           
         $page->uploader_id = $gsd->id;
         $page->image_name = $image_name;
         $page->image_path = $public_path.'/';
        }
         $page->status = $request->status;
         $page->save();
         
         notify()->success('Page Created Success !');
         return back();
        }else{
              notify()->error('Perpage Not Allow !');
            return back();
        }
    }

    public function edit_page(Request $request){
        $gsd = global_user_data();
        $page =  Page::where('id',$request->id)->first();
       

       return view('Admin.page.edit',compact('page','gsd'));
    }

    public function update_page(Request $request){
        $gsd = global_user_data();
        if (Auth::id() == 1 || permission_checker($gsd->role_info,'page_manage') == 1){
         $page =  Page::where('id',$request->id)->first();
         $page->name = $request->name;
  
        if ($request->slug == '') {
            $page->slug = Str::slug($request->name); 
        }else{
            $page->slug = $request->slug;
        }
         
         $page->content = $request->content;
         
           if($request->hasFile('media_file')){
          
          if($page){
          fileDelete($page->image_path.$page->image_name);
          fileDelete($page->image_path.'small/'.$page->image_name);
          fileDelete($page->image_path.'large/'.$page->image_name);
          fileDelete($page->image_path.'medium/'.$page->image_name);
          fileDelete($page->image_path.'extra_small/'.$page->image_name);   
        }
        
            $dt = Carbon::now();
            $micro = $dt->micro;
            $image_obj = $request->file('media_file');
         
            $orpath = storage_path('app/public/uploads/page');
            
            $ex_small_path = storage_path('app/public/uploads/page/extra_small');
            $small_path = storage_path('app/public/uploads/page/small');
            $medium_path = storage_path('app/public/uploads/page/medium');
            $large_path = storage_path('app/public/uploads/page/large');
            
            $public_path = 'storage/uploads/page';
      
            
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
           
  
         $page->image_name = $image_name;
         $page->image_path = $public_path.'/';
        }
        $page->status = $request->status;
        $page->updated_by = $gsd->id;
         $page->save();
              notify()->success('Page Updated Success !');
         return back();
     
        }else{
              notify()->error('Permission Not Allow !');
            return back();
        }
    }

    public function remove_page(Request $request){
   
        $gsd = global_user_data();
        if (Auth::id() == 1 || permission_checker($gsd->role_info,'page_manage') == 1){
        $page =  Page::where('id',$request->id)->first();
        if($page){
          fileDelete($page->image_path.$page->image_name);
          fileDelete($page->image_path.'small/'.$page->image_name);
          fileDelete($page->image_path.'large/'.$page->image_name);
          fileDelete($page->image_path.'medium/'.$page->image_name);
          fileDelete($page->image_path.'extra_small/'.$page->image_name);   
        }
         
          
        Page::destroy($request->id);
         notify()->success('Page Remove Success !');
         return back();
        }else{
              notify()->error('Permission Not Allow !');
            return back();
        }
    }
}
