<?php

namespace App\Http\Controllers;

use Mail;
use App\Models\User;
use App\Models\Agama;
use App\Http\Requests;
use App\Models\Gender;
use App\Models\Category;
use App\Models\Employee;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\Auth\UserActivation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $employees = User::where('department','LIKE','R&D%')
        ->orwhere('department','LIKE','%Formulation%')
        ->orwhere('department','LIKE','%Packaging%')
        ->orderBy('active', 'DESC')
        ->orderBy('akses', 'ASC')
        ->orderBy('department', 'ASC')
        ->orderBy('username', 'ASC')
        ->get();
        return view('gudang.employee.index', ['employees'=>$employees]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        if(Auth()->user()->akses=='user'){
            return back()->with('pesan','Kamu tidak memiliki akses administrator');
        }
        $department = DB::connection('mysql2')->table('iccs_be.departments')
        ->where('department','LIKE','R&D%')
        ->orwhere('department','LIKE','%Formulation%')
        ->orwhere('department','LIKE','%Packaging%')->orderBy('department')->get();

        return view('gudang.employee.create', compact('department'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){        
        //generate password           
        $random = randomPassword();
        $hashpassword = Hash::make($random);
        $employees = new User;      
        $employees->username         = $request->username;
        $employees->name = $request->name;
        $employees->department   = $request->department;
        $employees->email   = $request->email;
        $employees->akses  = $request->akses;  
        $employees->active   = 1;
        $employees->password   = $hashpassword;    
        $employees->save();    

            //Send Notif to User        
            $mailData = [
                'name' => $employees->name,
                'username' => $employees->username,
                'password' => $random,                        
            ];    

            $emailto = $request->email;         
            Mail::to($emailto)            
            ->send(new UserActivation($mailData));
      return redirect('employee')->with('pesan', 'Data berhasil ditambahkan');
  }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {        
        return view('gudang.employee.show', ['employees' => User::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){       
        if(Auth()->user()->akses=='user'){
            return back()->with('pesan','Kamu tidak memiliki akses administrator');
        }
        $employees = User::findOrFail($id);
        $roles = explode(';',$employees->role);  
        //$contains = Str::containsAll($employees->role, ['ATK']);       
        
        $categories = Category::all();
        return view('gudang/employee/edit', compact('employees','categories','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        
        $employees = User::find($id);
        $employees->akses           = $request->akses;   
        $employees->active           = $request->active;   
        if($employees->username=='admin'){
            $employees->role= collect($request->input('role'))->implode(';').';All';
            
        }else{
            $employees->role= collect($request->input('role'))->implode(';');
        }           
        $employees->save();
        return redirect('employee')->with('pesan', 'Data berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request){
        if(Auth()->user()->akses=='user'){
            return back()->with('pesan','Kamu tidak memiliki akses administrator');
        }
        $employees = User::find($request->id_karyawan);
        $employees->delete();
        return back()->with('pesan', 'Data berhasil dihapus');
    }
}
