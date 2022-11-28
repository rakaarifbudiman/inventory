<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Models\Audit;

class AuditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $audits = Audit::orderBy('created_at','DESC')->get();        
        return view('gudang.audit.index', ['audits'=>$audits]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create(){
        
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        
        $this->validate($request, [
            'nama_agama' => 'required',
        ]);

        $agamas = new Audit;
        $agamas->id_agama   = $request->id_agama;
        $agamas->nama_agama = $request->nama_agama;
        $agamas->save();
        // dd('kesini');

        return redirect('audit')->with('pesan', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
        
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_agama){
        
        $agamas = Audit::find($id_agama);
        return view('gudang/audit/edit', compact('agamas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_agama){

        $this->validate($request, [
            'nama_agama' => 'required',
        ]);

        $agamas = Audit::find($id_agama);
        $agamas->nama_agama = $request->nama_agama;
        $agamas->save();
        return redirect('audit')->with('pesan', 'Data berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request){
        
        // dd($request->id_agama);
        $agamas = Audit::find($request->id_agama);
        $agamas->delete();
        return back()->with('pesan', 'Data berhasil dihapus');
    }
}
