<?php

namespace App\Http\Controllers;

use Auth;
use Mail;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\Auth\ResetPassword;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('department','LIKE','R&D%')
        ->orwhere('department','LIKE','%Formulation%')
        ->orwhere('department','LIKE','%Packaging%')->get(); 
        return view('gudang.user.index', ['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('gudang.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Validator::make($request->all(),[
            'name' => 'required|between:3,100',
            'username' => 'required|between:3,100',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6',
            'repassword' => 'required|same:password',
            'akses' => 'required',
        ])->validate();
        
        $users = new User;
        $users->name   = $request->name;
        $users->username = $request->username;
        $users->email = $request->email;
        $users->password   = bcrypt($request->password);
        $users->akses = $request->akses;
        $users->save();
        // dd('kesini');

        return redirect('user')->with('pesan', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {       
        if(Auth()->user()->akses=='user'){
            return back()->with('pesan','Kamu tidak memiliki akses administrator');
        }
        $users = User::findOrFail($id);
        return view('gudang/user/edit', compact('users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        \Validator::make($request->all(),[
            'name' => 'required|between:3,100',
            'username' => 'required|between:3,100',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|min:8',
            'repassword' => 'same:password',
            'akses' => 'required',
        ])->validate();
        $users = User::find($id);           
        
        $users->name         = $request->name;
        $users->username = $request->username;
        $users->email   = $request->email;
        $users->akses   = $request->akses;
        $users->active   = $request->active;
        $users->password  = HASH::make($request->password);
        $users->save();
        return back()->with('pesan', 'Data berhasil di update');

        // if(!empty($request->password)){
        //     $field = [
        //         'name' => $request->name,
        //         'username' => $request->username,
        //         'email' => $request->email,
        //         'akses' => $request->akses,
        //         'password' => bcrypt($request->password),
        //     ];
        // }
        // else{
        //     $field = [
        //         'name' => $request->name,
        //         'username' => $request->username,
        //         'email' => $request->email,
        //         'akses' => $request->akses,
        //     ];
        // }
        // $result = User::where('id', $request->id)->update($field);

        // if($result){
        //     return redirect()->route('user.index')->with('result', 'update');
        // }
        // else{
        //     return back()->with('result', 'fail');
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $users = User::find($request->id);
        $users->delete();
        return back()->with('pesan', 'Data berhasil dihapus');
    }
}
