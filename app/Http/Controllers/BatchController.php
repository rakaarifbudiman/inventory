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
}
