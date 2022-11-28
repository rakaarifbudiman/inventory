<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserSettingController extends Controller
{

    public function form(){
    	$users = User::where('id', Auth::id())->first();
    	return view('gudang.user.setting', ['users'=>$users]);
    }

    public function update(Request $request){
    	$id = Auth::id();
    	\Validator::make($request->all(), [
    		'name' => 'required|between:3,100',
    		'username' => 'required|between:3,100',
    		'email' => 'required|email|unique:users,email,'.$id,
    		'password' => 'nullable|min:8',
    		'repassword' => 'same:password'
    	])->validate();
		
		if(Auth::user()->iccs==1){
            return redirect('/')->with('error','User ICCS tidak bisa reset password disini');
        }
		
    	if(!empty($request->password)){
    		$field = [
    			'name' => $request->name,
    			'username' => $request->username,
    			'email' => $request->email,
    			'password' => HASH::make($request->password),
    		];
    	}
    	else{
    		$field = [
    			'name' => $request->name,
    			'username' => $request->username,
    			'email' => $request->email,
    		];
    	}

    	$result = User::where('id', $id)->update($field);

    	if($result){
    		return back()->with('result', 'success');
    	}
    	else{
    		return back()->with('result', 'fail');
    	}
    }
}
