<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
//    protected $redirectTo =  "/home";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    /*protected function attemptLogin(Request $request)
    {
        if(is_numeric($request->input('email'))){
            $field = 'mobile_no';
        }elseif(filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        }
        $credentials = [$field => $request->input('email'), 'password' => $request->input('password')];
        return $this->guard()->attempt(
            $credentials, $request->has('remember')
        );
    }*/
    protected function redirectTo(){
        if(auth()->user() !== '' && auth()->user()->role == "ADMIN"):
            $red = "/admin/categories";
        else:
            $red = "/home";
        endif;
        return $red;
    }
}
