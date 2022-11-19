<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Http\Requests;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sell;
use App\Models\Category;
use App\Models\Unit;
use File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $products = Product::orderBy('kode_produk', 'DESC')->get(); 
        
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

        return view('gudang.product.create', compact('categories', 'units'));
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
    

            if(empty($tgl_awal) || empty($tgl_akhir)){               
                return back()->with('pesan', 'Masukkan tanggal!');
            }

            return view('gudang.product.show', [
                'products' => $products,
                'sells' => $sells,
                'purchases'=>$purchases]);

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

            return view('gudang.product.show', [
                'products' => $products,
                'sells' => $sells,
                'purchases'=>$purchases]);
        }

        $sells = Sell::where('status', '1')
            ->where('id_produk', $id_produk)
            ->orderBy('sells.id', 'DESC')
            ->get();            
    
        $purchases = Purchase::where('status', '1')
                ->where('id_produk', $id_produk)
                ->orderBy('purchases.id', 'DESC')
                ->get();               

        return view('gudang.product.show', [
            'products' => $products,
            'sells' => $sells,
            'purchases'=>$purchases]);
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
        $products->id_unit     = $request->id_unit;
        $products->lokasi      = $request->lokasi;
        $products->ket_produk  = $request->ket_produk;

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
        $data = Product::where('id',$request->idx)->first(); 
        return response()->json($data);        
    }
}
