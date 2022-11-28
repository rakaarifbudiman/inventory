<?php

namespace App\Http\Controllers;

use Auth;
use File;
use App\Models\Sell;
use App\Models\Unit;
use App\Models\Batch;
use App\Http\Requests;
use App\Models\Product;
use App\Models\Category;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\ProductConversion;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $products = Product::orderBy('id_kategori', 'ASC')->orderBy('kode_produk', 'ASC')->get(); 
        
        return view('gudang.product.index', ['products'=>$products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->akses !== 'admin'){
            return back()->with('error','Gagal...Kamu tidak punya otorisasi');
        }
        $product = Product::all();       
        $categories = Category::all();
        $units = Unit::all();
        $roles = explode(';',Auth::user()->role);         
        return view('gudang.product.create', compact('categories', 'units','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        if(Auth::user()->akses !== 'admin'){
            return back()->with('error','Gagal...Kamu tidak punya otorisasi');
        }
        if($request->stok_produk<0 || $request->safety_stok<0 || $request->max_stok<0){
            return back()->with('error','Gagal... Stok/Safety Stok/Max Stok tidak boleh < 0');
        }

      $this->validate($request, [
          'image' => 'required|image|mimes:jpg,jpeg,png,JPG,JPEG,PNG|max:2000',
          'id_kategori'=>'required|numeric'
      ]);

      $products = new Product;
      $products->id   = $request->id_produk;
      $products->kode_produk = $request->kode_produk;
      $products->nama_produk = $request->nama_produk;
      $products->id_kategori = $request->id_kategori;
      $products->stok_produk = $request->stok_produk;
      $products->max_stok = $request->max_stok;
      $products->safety_stok = $request->safety_stok;      
      $products->id_unit     = $request->id_unit;
      $products->lokasi      = $request->lokasi;
      $products->ket_produk  = $request->ket_produk;
      $products->id_supplier  = 1;
      $products->expired  = $request->expired;

      if($request->hasFile('image')){
        $file = $request->file('image');
        $fileName = time().'.'.$file->getClientOriginalExtension();
        $destinationPath = public_path('/image');
        $file->move($destinationPath, $fileName);
        $products->image = $fileName;
      }

      $products->save();
      // dd('kesini');

      return redirect('product')->with('pesan', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_produk,Request $request)
    {
        $products = Product::findOrFail($id_produk);        
        
        if(isset($_GET['cari'])){
            // dd('disini');
            $tgl_awal = $request->tgl_awal;
            $tgl_akhir = $request->tgl_akhir;
            
            $sells = Sell::where('status', '1')
            ->where('id_produk', $id_produk)
            ->whereBetween('sells.tgl_sell', [$tgl_awal, $tgl_akhir])
            ->orderBy('sells.id', 'DESC')
            ->get();   
            
            $purchases = purchase::where('status', '1')
                ->where('id_produk', $id_produk)
                ->whereBetween('purchases.tgl_purchase', [$tgl_awal, $tgl_akhir])
                ->orderBy('purchases.id', 'DESC')
                ->get();   

            $batches = Batch::where('status', '1')
                ->where('id_produk', $id_produk)                
                ->orderBy('expired', 'ASC')
                ->orderBy('stok', 'ASC')
                ->get();    
    
            $total_purchase = Purchase::select('id_produk', DB::raw('SUM(qty_purchase) as total'))
                ->whereBetween('purchases.tgl_purchase', [$tgl_awal, $tgl_akhir])
                ->where('id_produk', $id_produk)
                ->groupBy('id_produk')->first();
            $total_sell = Sell::select('id_produk', DB::raw('SUM(qty) as total'))
                ->whereBetween('sells.tgl_sell', [$tgl_awal, $tgl_akhir])
                ->where('id_produk', $id_produk)
                ->groupBy('id_produk')->first();
            if(empty($tgl_awal) || empty($tgl_akhir)){               
                return back()->with('pesan', 'Masukkan tanggal!');
            }

            return view('gudang.product.show', [
                'products' => $products,
                'sells' => $sells,
                'purchases'=>$purchases,
                'batches'=>$batches,
                'total_purchase'=>$total_purchase,
                'total_sell'=>$total_sell]);

        }

        if(isset($_GET['reset'])){
            $sells = Sell::where('status', '1')
            ->where('id_produk', $id_produk)
            ->orderBy('sells.id', 'DESC')            
            ->get();                

            $purchases = Purchase::where('status', '1')
                ->where('id_produk', $id_produk)
                ->orderBy('purchases.id', 'DESC')
                ->get();  

            $batches = Batch::where('status', '1')
                ->where('id_produk', $id_produk)                
                ->orderBy('expired', 'ASC')
                ->orderBy('stok', 'ASC')
                ->get();      
            $total_purchase = Purchase::select('id_produk', DB::raw('SUM(qty_purchase) as total'))->where('id_produk', $id_produk)->groupBy('id_produk')->first();
            $total_sell = Sell::select('id_produk', DB::raw('SUM(qty) as total'))->where('id_produk', $id_produk)->groupBy('id_produk')->first();
            return view('gudang.product.show', [
            'products' => $products,
            'sells' => $sells,
            'purchases'=>$purchases,
            'batches'=>$batches,
            'total_purchase'=>$total_purchase,
            'total_sell'=>$total_sell]);
        }

        $sells = Sell::where('status', '1')
            ->where('id_produk', $id_produk)
            ->orderBy('sells.id', 'DESC')
            ->get();            
    
        $purchases = Purchase::where('status', '1')
                ->where('id_produk', $id_produk)
                ->orderBy('purchases.id', 'DESC')
                ->get();   
        $total_purchase = Purchase::select('id_produk', DB::raw('SUM(qty_purchase) as total'))->where('id_produk', $id_produk)->groupBy('id_produk')->first();
        $total_sell = Sell::select('id_produk', DB::raw('SUM(qty) as total'))->where('id_produk', $id_produk)->groupBy('id_produk')->first();
        $batches = Batch::where('status', '1')
                ->where('id_produk', $id_produk)                
                ->orderBy('expired', 'ASC')
                ->orderBy('stok', 'ASC')
                ->get();             

        return view('gudang.product.show', [
            'products' => $products,
            'sells' => $sells,
            'purchases'=>$purchases,
            'batches'=>$batches,
            'total_purchase'=>$total_purchase,
            'total_sell'=>$total_sell]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_produk, Product $products)
    {
        if(Auth::user()->akses !== 'admin'){
            return back()->with('error','Gagal...Kamu tidak punya otorisasi');
        }
        $products = Product::findOrFail($id_produk);        
        return view('gudang/product/edit', compact('products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_produk)
    {
        if(Auth::user()->akses !== 'admin'){
            return back()->with('error','Gagal...Kamu tidak punya otorisasi');
        }

        if($request->stok_produk<0 || $request->safety_stok<0 || $request->max_stok<0){
            return back()->with('error','Gagal... Stok/Safety Stok/Max Stok tidak boleh < 0');
        }

        $products = Product::find($id_produk);
        $olds= getoldvalues('mysql','products',$products);
        $old_stok = $olds["old"]["stok_produk"];   

        $products->kode_produk = $request->kode_produk;
        $products->nama_produk = $request->nama_produk;
        $products->id_kategori = $request->id_kategori;
        $products->stok_produk = $request->stok_produk;
        /* $products->id_unit     = $request->id_unit; */
        $products->lokasi      = $request->lokasi;
        $products->ket_produk  = $request->ket_produk;
        $products->expired  = $request->expired;

        if($request->hasFile('image')){
            $file = $request->file('image');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('/image');
            $file->move($destinationPath, $fileName);
            $products->image = $fileName;
        }
        
            if($old_stok>$request->stok_produk){
                $sell = Sell::create([
                    'tgl_sell'=>now(),
                    'id_karyawan'=>Auth()->user()->id,
                    'id_produk'=>$id_produk,
                    'qty'=>$old_stok - $request->stok_produk,
                    'status'=>1,
                    'created_by'=>Auth()->user()->id,
                    'ket_sell'=>'Update Stok Manual'
                ]);
            }elseif($old_stok<$request->stok_produk){
                $purchase = Purchase::create([
                    'tgl_purchase'=>now(),
                    'tgl_terima'=>now(),
                    'id_karyawan'=>Auth()->user()->id,
                    'id_produk'=>$id_produk,
                    'qty_purchase'=>$request->stok_produk - $old_stok,
                    'status'=>1,
                    'created_by'=>Auth()->user()->id,
                    'ket_purchase'=>'Update Stok Manual'
                ]);
            }
        $products->save();
       
        return redirect('product')->with('pesan', 'Data berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(Auth::user()->akses !== 'admin'){
            return back()->with('error','Gagal...Kamu tidak punya otorisasi');
        }
        
      $products = Product::find($request->id_produk);      
      $sell =Sell::where('id_produk',$products->id)->count();
      $purchase = Purchase::where('id_produk',$products->id)->count();   
        if($sell>0 || $purchase>0){
            return back()->with('error','Gagal...produk tidak bisa dihapus karena sudah ada transaksi pembelian ('.$purchase.')/pengambilan ('.$sell.')');
        }

      File::delete(('/image/'.$products->image));
      $products->delete();

      return back()->with('pesan', 'Data berhasil dihapus');
    }

    public function getimageurl(Request $request)
    {        
        $data = Product::join('units','products.id_unit', '=', 'units.id')->where('products.id',$request->idx)->first(); 
        //$unit=$data->units->nama_unit;
        return response()->json($data);        
    }

    public function getnewnumber(Request $request)
    {
        $lastid = Product::where('id_kategori',$request->idx)
        ->max('kode_produk');
        $lastno = intval(substr($lastid,-3));  
        $category = Category::find($request->idx); 
             
        $data = $category->kode_kategori. sprintf("%03s", ($lastno==0 or $lastno==NULL) ? 1 : abs($lastno+1));    
        return response()->json($data);  
    }

    public function getcategory(Request $request)
    {        
        $data = Product::where('id_kategori',$request->idx)->get();        
        return response()->json($data);        
    }
}
