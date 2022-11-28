<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductConversion;
use App\Http\Controllers\Controller;

class ProductConversionController extends Controller
{
    public function edit($id_produk){        
        $conversions = ProductConversion::where('id_produk',$id_produk)->get();
        return view('gudang/product/conversion/index', compact('conversions'));
    }
}
