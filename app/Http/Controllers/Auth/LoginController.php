<?php

namespace App\Http\Controllers\Auth;

use \Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
    protected $redirectTo = '/home';
    // protected $username = 'username';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username(){
      return 'username';
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function authenticated(Request $request, $user)
    {       
        DB::table('logins')->insert([
          'username' => $user->username, 
          'ip' => $request->ip(), 
          'user-agent' => $request->header('User-Agent'),
          'created_at' => now()
        ]);    
    }
}
