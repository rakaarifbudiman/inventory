<!-- modal sell expired-->
<div class="modal fade" id="modalsell{{$batch->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content" style="background-color: rgb(200, 200, 200)">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title text-center" id="myModalLabel">Musnahkan Batch Expired ?</h4>
          <h4 class="modal-title text-center" id="myModalLabel1">{{$batch->products->nama_produk}}</h4>
        </div>
        <form action="{{ route('sell.store') }}" method="post">
          @csrf
          <div class="modal-body" style="background-color: rgb(230, 230, 230)">            
            <div class="row">                        
                <div class="col-sm-8">                    
                    <input class="form-control form-control-sm text-center" type="number" id="qty" name="qty" value="{{number_format($batch->stok,$batch->products->units->dec_unit, '.', ',')}}" min=0>                                                 
                </div>  
                <div class="col-sm-4">    
                    <input class="form-control form-control-sm text-center" type="text" value="{{$batch->products->units->nama_unit}}" readonly>               
                   
                </div>                               
            </div>               
            <input class="form-control form-control-sm" type="hidden" name="tgl_sell" value="{{Carbon\Carbon::parse(now())->format('Y-m-d')}}">
            <input class="form-control form-control-sm" type="hidden" name="id_karyawan" value="{{Auth::user()->id}}">
            <input class="form-control form-control-sm" type="hidden" name="id_produk" value="{{$batch->id_produk}}">    
            <input class="form-control form-control-sm" type="hidden" name="id_batch" value="{{$batch->id}}">   
            <input class="form-control form-control-sm" type="hidden" name="ket_sell" value="Pemusnahan Batch Expired">   
            
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Lanjut</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">Tidak, kembali</button>
          </div>
        </form>
      </div>
    </div>
  </div>