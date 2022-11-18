<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Models\purchase;
use App\Models\Employee;
use App\Models\Product;

class ReportMasukController extends Controller
{
    public function index(Request $request)
    {
        if(isset($_GET['cari'])){
            // dd('disini');
            $tgl_awal = $request->tgl_awal;
            $tgl_akhir = $request->tgl_akhir;
            
            $purchases = purchase::where('status', '1')
            ->whereBetween('purchases.tgl_purchase', [$tgl_awal, $tgl_akhir])
            ->orderBy('purchases.tgl_purchase', 'DESC')
            ->get();    

            if(empty($tgl_awal) || empty($tgl_akhir)){
                // dd('disini');
                return back()->with('pesan', 'Masukkan tanggal!');
            }

            return view('gudang.report.pemesanan', ['purchases'=>$purchases]);

        }

        if(isset($_GET['reset'])){
            $purchases = purchase::where('status', '1')
            ->orderBy('purchases.tgl_purchase', 'DESC')
            ->get();    
            return view('gudang.report.pemesanan', ['purchases'=>$purchases]);
        }

        $purchases = purchase::where('status', '1')
            ->orderBy('purchases.tgl_purchase', 'DESC')
            ->get();    
        
        return view('gudang.report.pemesanan', ['purchases'=>$purchases]);
    }



    public function destroy(Request $request)
    {
        if(Auth::user()->akses !== 'admin'){
            return back()->with('error','Gagal...Kamu tidak punya otorisasi');
        }    
      	$purchases = purchase::find($request->id_purchase);
    	$purchases->delete();
    	return back()->with('pesan', 'Data berhasil dihapus');
    }
}
