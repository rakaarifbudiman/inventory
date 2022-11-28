<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\Auth\ResetPassword;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function password()
    {
        return view('auth.passwords.email');
    }
    public function resetpassword(Request $request)
    {        
        $user = User::where('email',$request->email)->where('active',1)->first();        
        if(!$user==true){
            return back()->with('error','Email tidak ditemukan');
        }
       
        if($user->iccs==1){
            return back()->with('error','User ICCS tidak bisa reset password disini');
        }

        //generate password
        $random = randomPassword();
        $hashpassword = Hash::make($random);
        $user->password = $hashpassword;        
        $user->save();        
        //Send Notif to User        
        $mailData = [
            'name' => $user->name,
            'username' => $user->username,
            'password' => $random,                        
        ];    

        $emailto = $request->email;         
        Mail::to($emailto)            
        ->send(new ResetPassword($mailData));

        return back()->with('pesan','Password baru telah dikirim ke email kamu...');
    }
}
