<?php

namespace App\Http\Controllers;

use App\Models\Sell;
use App\Models\User;
use App\Models\Batch;
use App\Models\Product;
use App\Models\Employee;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $sells = Sell::where('status','=', '0')
                        ->orderBy('sells.id')
                        ->get();        
        $minstocks = Product::whereColumn('stok_produk','<','safety_stok')->get();       
        $minbatches = Batch::where('expired','<=',now())->where('stok','>',0)->where('status',1)->get(); 
        foreach($minstocks as $product){
            $cekpurchase = Purchase::
            select("id_produk", DB::raw("sum(qty_purchase) as total_purchase"))
            ->groupBy('id_produk')
            ->where('status',0)
            ->where('id_produk',$product->id)
            ->first();
        
            if($cekpurchase){
                $cekstok[] = $product->stok_produk + $cekpurchase->total_purchase;
                
            }else{
                $cekstok[] = $product->stok_produk;
            }       
            
        }
       
        if($minstocks->count()>0){
            return view('gudang.home',['sells'=>$sells,
            'minstocks'=>$minstocks,
            'cekstok'=>$cekstok,
            'minbatches'=>$minbatches
            ]);
        }else{
            return view('gudang.home',['sells'=>$sells,
            'minstocks'=>$minstocks,
            'minbatches'=>$minbatches        
        ]);
        }

        
       
    }
}
