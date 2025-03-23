<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Setting;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request)
    {
        $login_permission  = Setting::where('id', 1)->first();
        if($login_permission->user_login_switch == 1){
            return view('auth.login');
        }else{
        
        return redirect('/');
        }
        
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        session(['check_auth_id'=> Auth::id()]);
        
       $cck = User::where('id',Auth::id())->first();
       
       if($cck->status == 3){
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            session(['check_auth_id'=> '']);
            notify()->error('This account is banned please contact with admin.');
            return redirect('/');
       }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        session(['check_auth_id'=> '']);
        return redirect('/');
    }
}
