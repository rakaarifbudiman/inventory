<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Auth;

class PurchaseController extends Controller
{
    public function index()
    {        
        $purchases = Purchase::where('status','=', '0')                        
                        ->get();       
        $employees = User::where('department','LIKE','R&D%')
        ->orwhere('department','LIKE','%Formulation%')
        ->orwhere('department','LIKE','%Packaging%')->get();       
        $products  = Product::all();
        $data = array(
            'employees'  => $employees,
            'products'   => $products,
        );
       
        return view('gudang.buy.index', ['purchases'=>$purchases], $data);
    }

    public function store(Request $request)
    {  
        if($request->qty_purchase<0){
            return back()->with('error','Gagal... Qty Pemesanan tidak boleh < 0');
        }

        $product = Product::find($request->id_produk);
        $cekpurchase = Purchase::
            select("id_produk", DB::raw("sum(qty_purchase) as total_purchase"))
            ->groupBy('id_produk')
            ->where('status',0)
            ->where('id_produk',$request->id_produk)
            ->first();
        
        if($cekpurchase){
            $cekstok = $product->stok_produk + $request->qty_purchase + $cekpurchase->total_purchase;
        }else{
            $cekstok = $product->stok_produk + $request->qty_purchase;
        }        
        
        if($cekstok> $product->max_stok){
            return back()->with('error','Gagal... Pemesanan melebihi maksimal stok');
        }

        $data1= $request->except('_token');   
        $data2= array('created_by'=>Auth()->user()->id);      
        $store = Purchase::create(array_merge($data1,$data2));
       
        return back()->with('pesan', 'Data berhasil ditambahkan');
    }

    public function destroy(Request $request)
    {           
        if(Auth()->user()->akses !== 'admin'){
            return back()->with('error','Gagal...Kamu tidak punya otorisasi');
        }    
        $purchases = Purchase::find($request->id_produk);       
        $purchases->delete();
        return back()->with('pesan', 'pemesanan dibatalkan!');
    }

    public function show($id_produk)
    {
        $purchase = Purchase::findOrFail($id_produk);
        return view('gudang.buy.show', [            
            'purchase'=>$purchase]);
    }

    public function edit($id_produk)
    {
        if(Auth::user()->akses !== 'admin'){
            return back()->with('error','Gagal...Kamu tidak punya otorisasi');
        }
        $purchase = Purchase::findOrFail($id_produk);        
        return view('gudang.buy.edit', compact('purchase'));
    }

    public function update(Request $request, $id_produk)
    {
        if(Auth::user()->akses !== 'admin'){
            return back()->with('error','Gagal...Kamu tidak punya otorisasi');
        }
        $purchase = Purchase::find($id_produk);
        $purchase->tgl_purchase = $request->tgl_purchase;
        $purchase->tgl_terima = $request->tgl_terima;
        $purchase->qty_purchase = $request->qty_purchase;
        $purchase->status = 1;
        $purchase->ket_purchase = $request->ket_purchase;     
        $purchase->save();
       
        return redirect('/purchase')->with('pesan', 'Barang berhasil di terima');
    }
    
}
