<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Models\Sell;
use App\Models\Employee;
use App\Models\Product;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        if(isset($_GET['cari'])){
            // dd('disini');
            $tgl_awal = $request->tgl_awal;
            $tgl_akhir = $request->tgl_akhir;
            
            $sells = Sell::where('status', '1')
            ->whereBetween('sells.tgl_sell', [$tgl_awal, $tgl_akhir])
            ->orderBy('sells.id', 'DESC')
            ->get();    

            if(empty($tgl_awal) || empty($tgl_akhir)){
                // dd('disini');
                return back()->with('pesan', 'Masukkan tanggal!');
            }

            return view('gudang.report.pengambilan', ['sells'=>$sells]);

        }

        if(isset($_GET['reset'])){
            $sells = Sell::where('status', '1')
            ->orderBy('sells.id', 'DESC')
            ->get();    
            return view('gudang.report.pengambilan', ['sells'=>$sells]);
        }

        $sells = Sell::where('status', '1')
            ->orderBy('sells.id', 'DESC')
            ->get();    
        
        return view('gudang.report.pengambilan', ['sells'=>$sells]);
    }



    public function destroy(Request $request)
    {
        if(Auth::user()->akses !== 'admin'){
            return back()->with('error','Gagal...Kamu tidak punya otorisasi');
        }    
      	$sells = Sell::find($request->id_sell);
    	$sells->delete();
    	return back()->with('pesan', 'Data berhasil dihapus');
    }
}
