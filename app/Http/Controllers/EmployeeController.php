<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Models\Employee;
use App\Models\Agama;
use App\Models\Gender;
use App\Models\User;

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
        //dd($request->all());
      $employees = new User;      
      $employees->username         = $request->username;
      $employees->name = $request->name;
      $employees->department   = $request->department;
      $employees->email   = $request->email;
      $employees->akses  = $request->akses;  
      $employees->active   = 1;
      $employees->password   = bcrypt('12345678');    
      $employees->save();     

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
        return view('gudang/employee/edit', compact('employees'));
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
