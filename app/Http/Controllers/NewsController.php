<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
   public function index(){
    $gsd = global_user_data();
        $news = News::latest('id')->paginate(20);
        return view('Admin.news.index',compact('gsd','news'));
   }
   public function add(){
    $gsd = global_user_data();
    if (Auth::id() == 1 || permission_checker($gsd->role_info,'newsfeed_manage') == 1){
    return view('Admin.news.create',compact('gsd'));
    
    }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
   }
   public function store(Request $request){
         $gsd = global_user_data();
       if (Auth::id() == 1 || permission_checker($gsd->role_info,'newsfeed_manage') == 1){
    $news = new News();
    if($news->slug != ''){
        $news->slug = $request->slug;
    }else{
        $news->slug = $request->title;
    }
    
    $news->title = $request->title;
    $news->content = $request->content;
    $news->featured_img = $request->img;
    $news->status = ($request->status == 1) ? 1:0;
    $news->save();
    notify()->success('News Post Success');
    return back();
       }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
   }
   public function edit(Request $request){
       $gsd = global_user_data();
       if (Auth::id() == 1 || permission_checker($gsd->role_info,'newsfeed_manage') == 1){
    $news = News::where('id',$request->id)->first();
    return view('Admin.news.edit',compact('gsd','news'));
    
    
 }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
   }
   public function update(Request $request){
           $gsd = global_user_data();
       if (Auth::id() == 1 || permission_checker($gsd->role_info,'newsfeed_manage') == 1){
       
    $news = News::where('id',$request->id)->first();
    if($news->slug != ''){
        $news->slug = $request->slug;
    }else{
        $news->slug = $request->title;
    }
    $news->title = $request->title;
    $news->content = $request->content;
    $news->featured_img = $request->img;
    $news->status = ($request->status == 1) ? 1:0;
    $news->save();
    notify()->success('News Update Success');
    return back();
       }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
   }
   public function remove(Request $request){
         $gsd = global_user_data();
       if (Auth::id() == 1 || permission_checker($gsd->role_info,'newsfeed_manage') == 1){
    News::destroy($request->id);
    notify()->success('News Remove Success');
    return back();
    
   }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
   }
}
