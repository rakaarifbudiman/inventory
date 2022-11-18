<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Models\Sell;
use App\Models\Employee;
use App\Models\Product;
use App\Models\User;

class SellController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $sells = Sell::where('status','=', '0')
                        ->where('sells.created_by','=', Auth()->user()->id)
                        ->get();
       
        $employees = User::where('department','LIKE','R&D%')
        ->orwhere('department','LIKE','%Formulation%')
        ->orwhere('department','LIKE','%Packaging%')->get();       
        $products  = Product::all();
        $data = array(
            'employees'  => $employees,
            'products'   => $products,
        );
       
        return view('gudang.sell.index', ['sells'=>$sells], $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        if($request->qty<0){
            return back()->with('error','Gagal... Jumlah pengambilan tidak boleh < 0');
        }

        $product = Product::find($request->id_produk);
        $cekstok = $product->stok_produk - $request->qty;
        if($cekstok<0){
            return back()->with('error','Gagal... Stok tidak cukup');
        }

        $data1= $request->except('_token');   
        $data2= array('created_by'=>Auth()->user()->id);      
        $store = Sell::create(array_merge($data1,$data2));
       
        return redirect('sell')->with('pesan', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        if(Auth::user()->akses !== 'admin'){
            return back()->with('error','Gagal...Kamu tidak punya otorisasi');
        }    
        $sells = Sell::find($id);
        $sells->delete();
        return back()->with('pesan', 'pengambilan dibatalkan!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {        
        $sells = Sell::where('status', '0');        
        $sells->update(['status'=>'1']);
        return back()->with('pesan', 'Data dikirim ke laporan');
    }
    public function updatebyid($id)
    {
        $sells = Sell::find($id);
        $sells->update(['status'=>'1']);        
        return back()->with('pesan', 'Data dikirim ke laporan');
    }  

    
}
