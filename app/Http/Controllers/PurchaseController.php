<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Batch;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PurchaseController extends Controller
{
    public function index()
    {        
        $purchases = Purchase::where('status','=', '0')
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
        $roles = explode(';',Auth::user()->role); 
        $data = array(
            'employees'  => $employees,
            'products'   => $products,
        );
       
        return view('gudang.buy.index', ['purchases'=>$purchases,'roles'=>$roles], $data);
    }

    public function store(Request $request)
    {  
        if($request->id_produk=='- Nama barang -'){
            return back()->with('error','Gagal... Barang harus dipilih');
        }

        if($request->qty_purchase<0){
            return back()->with('error','Gagal... Qty Pemesanan tidak boleh < 0');
        }
        
        $product = Product::find($request->id_produk);
        if($product->units->dec_unit==0){
            $this->validate($request, [
                'qty_purchase' => 'integer',
            ]);
        }
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
        $this->authorize('edit',$purchases);
        if($purchases->id_batch!=null){           
            $batch = Batch::find($purchases->id_batch);                   
            $batch->stok = $batch->stok - $purchases->qty_purchase;
            $batch->status= ($batch->stok - $purchases->qty_purchase)<=0 ? 0 :1;                             
            $batch->save();         
        }    
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
        $this->authorize('edit',$purchase);
        return view('gudang.buy.edit', compact('purchase'));
    }

    public function update(Request $request, $id_produk)
    {
        if(Auth::user()->akses !== 'admin'){
            return back()->with('error','Gagal...Kamu tidak punya otorisasi');
        }
        $this->validate($request, [
            'expired' => 'required_with:no_batch',
        ]);
        $purchase = Purchase::find($id_produk);
        
        if($request->no_batch!=null){           
            $cekbatch = Batch::where('no_batch',$request->no_batch)->first();
                $batch = Batch::UpdateOrInsert(
                ['id_produk' => $purchase->products->id,
                'no_batch'=>$request->no_batch],[
                'expired' => $request->expired,
                'status' => 1,
                'stok' => $cekbatch==null ? $request->qty_purchase : ($request->qty_purchase + $cekbatch->stok),
                'ket_batch' => $cekbatch==null ? $request->ket_purchase : 
                ($request->ket_purchase==null ? '' : ($cekbatch->ket_batch . '; '. $request->ket_purchase)),                
                    ]);    
            $cekbatch = Batch::where('no_batch',$request->no_batch)->first();       
            $purchase->id_batch = $cekbatch->id;          
        }
        $purchase->tgl_purchase = $request->tgl_purchase;
        $purchase->tgl_terima = $request->tgl_terima;
        $purchase->qty_purchase = $request->qty_purchase;
        $purchase->status = 1;
        $purchase->ket_purchase = $request->ket_purchase;     
        $purchase->save();
       
        return redirect('/purchase')->with('pesan', 'Barang berhasil di terima');
    }
    
}
