<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BatchController extends Controller
{
    public function getbatch(Request $request)
    {        
        $data_batch = Batch::where('id_produk',$request->idx)
        ->where('status',1)->orderBy('expired','ASC')->get();        
        return response()->json($data_batch);        
    }

    public function edit($id_produk)
    {
        $batch = Batch::findOrFail($id_produk);         
        return view('gudang/batch/edit', compact('batch'));
    }

    public function update(Request $request, $id_produk)
    {      

        $products = Product::find($request->id_produk);
        $this->authorize('edit',$products);   
        $batch = Batch::find($request->id);
        //$olds= getoldvalues('mysql','batches',$batch);
        $batch->no_batch=$request->no_batch;
        $batch->stok=$request->stok;
        $batch->expired=$request->expired;      
        $batch->ket_batch=$request->ket_batch;      
        $batch->save();
       
        return redirect('product')->with('pesan', 'Data berhasil di update');
    }
}
