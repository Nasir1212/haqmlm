<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index(){
        $gsd = global_user_data();
        $faqs =  Faq::latest('id')->paginate(10);
       
       return view('Admin.faqs.index',compact('faqs','gsd'));
   }
   
   public function create(){
       $gsd = global_user_data();
       return view('Admin.faqs.create',compact('gsd'));
   }
   
 
   
   public function store(Request $request){
       $gsd = global_user_data();
       if (Auth::id() == 1 || permission_checker($gsd->role_info,'faq_manage') == 1){
       
        $faq = new Faq();
        $faq->name = $request->name;
        $faq->content = $request->content;
        $faq->uploader_id = $gsd->id;
        $faq->status = $request->status;
        $faq->save();
        notify()->success('faq Created Success !');
        return back();
       }else{
             notify()->error('Perfaq Not Allow !');
           return back();
       }
   }
   
   public function edit(Request $request){
        $gsd = global_user_data();
        $faq =  Faq::where('id',$request->id)->first();
       

       return view('Admin.faqs.edit',compact('faq','gsd'));
   }
   
   public function update(Request $request){
       $gsd = global_user_data();
       if (Auth::id() == 1 || permission_checker($gsd->role_info,'faq_manage') == 1){
        $faq =  Faq::where('id',$request->id)->first();
        $faq->name = $request->name;
        $faq->content = $request->content;
       $faq->status = $request->status;
       $faq->updated_by = $gsd->id;
        $faq->save();
             notify()->success('faq Updated Success !');
        return back();
    
       }else{
             notify()->error('Perfaq Not Allow !');
           return back();
       }
   }
   
   public function remove(Request $request){
   
   $gsd = global_user_data();
       if (Auth::id() == 1 || permission_checker($gsd->role_info,'faq_manage') == 1){
        Faq::destroy($request->id);
        notify()->success('faq Remove Success !');
        return back();
       }else{
             notify()->error('Perfaq Not Allow !');
           return back();
       }
   }
}
