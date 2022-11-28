<?php

namespace App\Http\Controllers;

use App\Models\Sell;
use App\Models\User;
use App\Models\Batch;
use App\Http\Requests;
use App\Models\Product;
use App\Models\Category;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
                        ->where('created_by','=', Auth()->user()->id)
                        ->get();       
        $employees = User::where('department','LIKE','R&D%')
                        ->where('active',1)
                        ->orWhere(function($query) {
                            $query->where('department','LIKE','%Formulation%')
                            ->where('active',1);       
                        })->orWhere(function($query) {
                            $query->where('department','LIKE','%Packaging%')
                            ->where('active',1);       
                        })->get();         
        $products  = Product::all();
        $categories = Category::orderBy('order','ASC')->get();
        $data = array(
            'employees'  => $employees,
            'products'   => $products,
        );
       
        return view('gudang.sell.index', ['sells'=>$sells,
        'categories'=>$categories], $data);
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
        if($request->qty<0 || !$request->qty){
            return back()->with('error','Gagal... Jumlah pengambilan tidak boleh < 0');
        }
        if($request->id_produk=='- Nama barang -'){
            return back()->with('error','Gagal... Barang harus dipilih');
        }
        
        $product = Product::find($request->id_produk);
        $cekstok = $product->stok_produk - $request->qty;
        
        if($product->units->dec_unit==0){
            $this->validate($request, [
                'qty' => 'integer',
            ]);
        }
        

        if($cekstok<0){
            return back()->with('error','Gagal... Stok tidak cukup');
        }

        if($request->id_batch!=null){           
            $batch = Batch::find($request->id_batch);  
            $cekstok_batch = $batch->stok - $request->qty;   
            if($cekstok_batch<0){
                return back()->with('error','Gagal... Stok Batch tidak cukup');
            }                 
            $batch->stok = $batch->stok - $request->qty;
            $batch->status= $cekstok_batch<=0 ? 0 :1;   
                                   
            $batch->save();            
        }
        

        $data1= $request->except('_token');   
        $data2= array('created_by'=>Auth()->user()->id);      
        $store = Sell::create(array_merge($data1,$data2));
       
        return back()->with('pesan', 'Data berhasil ditambahkan');
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
        $this->authorize('edit',$sells);
            if($sells->id_batch!=null){           
                $batch = Batch::find($sells->id_batch);                              
                $batch->stok = $batch->stok + $sells->qty;
                $batch->status= ($batch->stok + $sells->qty)>0 ? 1 :0;                                     
                $batch->save();            
            }
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
        $sells = Sell::where('status', '0')->where('created_by','=', Auth()->user()->id);        
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
