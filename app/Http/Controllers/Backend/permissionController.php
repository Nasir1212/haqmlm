<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class permissionController extends Controller
{
    public function roles(){
       $gsd = global_user_data();
        if (Auth::id() == 1 || permission_checker($gsd->role_info,'permission_manage') == 1){
        $roles = Role::all();
        return view('Admin.role.role', compact('roles','gsd'));
        }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    }
    
    public function staff_members(Request $request){
       $gsd = global_user_data();
       $stp = '';
 if (Auth::id() == 1 || permission_checker($gsd->role_info,'permission_manage') == 1){
       if(isset($request->username)){

           $staff_members = User::where('username',$request->username)->with('role_info')->select(['username','name','access_id','id'])->get();
          
          if($staff_members){
            if( $staff_members[0]->access_id == 2){
                $stp = "General user";
               }else{
                $stp = "Staff";
               }
          }else{
            notify()->error('User not found!');
            return back();
          }
          
         

       }else{
        if(isset($request->user_type)){
            $staff_members = User::where('access_id',2)->with('role_info')->select(['username','name','access_id','id'])->get();
            $stp = "General user";
          }else{
           $staff_members = User::where('access_id','!=',2)->with('role_info')->select(['username','name','access_id','id'])->get();
           $stp = "Staff";
          }
       }
      
       
        return view('Admin.role.staff', compact('staff_members','gsd','stp'));
        
    }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    }

    public function role_store(Request $request){
      $gsd = global_user_data();
       if (Auth::id() == 1 || permission_checker($gsd->role_info,'permission_manage') == 1){
       $role = new Role();
       $role->name = $request->name;
       $role->access_module = json_encode($request->permissions);
       $role->save();
       $roles = Role::all();
       notify()->success('Role Create successfull!');
       return view('Admin.role.role', compact('roles','gsd'));
       
    }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    }

    public function role_creator(){
       $gsd = global_user_data();
        if (Auth::id() == 1 || permission_checker($gsd->role_info,'permission_manage') == 1){
        return view('Admin.role.role_creator', compact('gsd'));
        
    }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    }




    public function role_edit($id){
       $gsd = global_user_data();
        if (Auth::id() == 1 || permission_checker($gsd->role_info,'permission_manage') == 1){
        $role = Role::where('id', $id)->first();
        $role_id = $role->id;
        $role_name = $role->name;
        $r_modules = json_decode($role->access_module);
      
        return view('Admin.role.role_editor', compact('role_id','role_name','r_modules','gsd'));
        
    }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    }


public function role_setup_form(Request $request){
       $gsd = global_user_data();
        if (Auth::id() == 1 || permission_checker($gsd->role_info,'permission_manage') == 1){
       $roles = Role::all();
       $user = User::where('username',$request->username)->with('role_info')->first();
       
        return view('Admin.role.role_setup', compact('roles','user','gsd'));
        
}else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    }


    public function role_set(Request $request){
        $gsd = global_user_data();
       if (Auth::id() == 1 || permission_checker($gsd->role_info,'permission_manage') == 1){
        $user = User::where('username',$request->username)->first();
        $user->access_id = $request->access_id;
        $user->save();
        notify()->success('Role setup successfull!');
         return back();
         
    }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
     }

    public function role_update(Request $request){
       $gsd = global_user_data();
        if (Auth::id() == 1 || permission_checker($gsd->role_info,'permission_manage') == 1){
        $role = Role::where('id', $request->r_id)->first();
        $role->name = $request->name;
        $role->access_module = json_encode($request->permissions);
        $role->save();
        $roles = Role::all();
        notify()->success('Role Update successfull!');
        return view('Admin.role.role', compact('roles','gsd'));
        
    }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    }

    public function remove_role($id){
            $gsd = global_user_data();
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'permission_manage') == 1){
        Role::destroy($id);
        $msg = '';
        notify()->success('Role Remove successfull!');
        return back();
        
    }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    }
}
