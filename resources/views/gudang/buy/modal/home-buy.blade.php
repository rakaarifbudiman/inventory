<!-- modal buy-->
<div class="modal fade" id="modalbuy{{$stok->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content" style="background-color: rgb(200, 200, 200)">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title text-center" id="myModalLabel">Masukkan Jumlah Pembelian</h4>
          <h4 class="modal-title text-center" id="myModalLabel1">{{$stok->nama_produk}}</h4>
        </div>
        <form action="{{ route('purchase.store') }}" method="post">
          @csrf
          <div class="modal-body" style="background-color: rgb(230, 230, 230)">            
            <div class="row mb-3">                        
                <div class="col-sm-12">                    
                    <input class="form-control form-control-sm text-center" type="number" id="qty_purchase" name="qty_purchase" value="{{ $stok->max_stok - $cekstok[$index] }}">                                                 
                </div>                                 
            </div>               
            <input class="form-control form-control-sm" type="hidden" name="tgl_purchase" value="{{Carbon\Carbon::parse(now())->format('Y-m-d')}}">
            <input class="form-control form-control-sm" type="hidden" name="id_karyawan" value="{{Auth::user()->id}}">
            <input class="form-control form-control-sm" type="hidden" name="id_produk" value="{{$stok->id}}">         
            
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Lanjut</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">Tidak, kembali</button>
          </div>
        </form>
      </div>
    </div>
  </div>