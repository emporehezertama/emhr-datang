<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * [credentials description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    protected function credentials(Request $request)
    {
        if($request->get('email')){
            return ['nik'=>$request->get('email'),'password'=>$request->get('password')];
        }
        return $request->only($this->username(), 'password');
    }
    
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function redirectTo()
    {
        // if user have role
        if (auth()->user()->access_id == 1) // Admin
        {
            return $this->redirectTo = '/administrator';
        }
        elseif (auth()->user()->access_id == 2) // karyawan
        {
            return $this->redirectTo = '/karyawan';
        }
        
        return $this->redirectTo = '/';
    }
}
