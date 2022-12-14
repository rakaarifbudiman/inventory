<!DOCTYPE html>
<html>
<head>
  @include('templates.head')
  <title>Barang Masuk</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" />
	<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.min.js"></script>	
	<style>
		.select2-selection__choice {
  		color: blueviolet !important
		}
  
	</style>
</head>
<body class="hold-transition skin-blue sidebar-mini" style="min-height: 400px;">
<div class="wrapper">

  <header class="main-header">
    @include('templates.header')
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    @include('templates.sidebar')
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Barang Masuk
      </h1>

    </section>

    <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
                <div class="box" style="padding: 0 30px">
                    <div class="box-header">
                      <h5 class="box-title">Barang yang akan dipesan</h5>
                    </div>
                    <div class="row">
                      <div class="col-xs-8">
                        <div class="box-body">
                          @include('gudang/validation')
                          <form action="{{ route('purchase.store') }}" method="post">
                            @csrf
                            <div class="row">
                              <div class="col-xs-6">
                                <label>Tanggal</label>
                                <input required="" class="form-control form-control-sm" type="date" name="tgl_purchase" value="{{Carbon\Carbon::parse(now())->format('Y-m-d')}}">
                              </div>
                              <div class="col-xs-6">
                                <label>Pemesan</label>
                                <select class="form-control form-control-sm" name="id_karyawan">
                                  <option value="{{Auth::user()->id}}">{{Auth::user()->name}}</option>
                                  @foreach($employees as $employee)
                                  <option value="{{$employee->id}}">{{$employee->name}}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>                           

                            <div class="row" style="margin-top: 10px;">
                              <div class="col-xs-6">                               
                                <label>Nama Barang</label>
                                <select class="form-control form-control-sm" name="id_produk" id="id_produk">
                                  <option>- Nama barang -</option>
                                  @foreach ($roles as $role)                        
                                      @foreach($products as $product)
                                      <option value="{{$product->id}}" data-id="{{$product->id}}"
                                        {{$role==$product->categories->nama_kategori ? '' : 'hidden'}}>
                                        {{$product->nama_produk}} ({{$product->units->nama_unit}}) - {{$product->categories->nama_kategori}}
                                      </option>
                                      @endforeach
                                  @endforeach
                                </select>
                              </div>
                              <div class="col-xs-6">
                                <label>Jumlah</label>
                                <input class="form-control" type="number" name="qty_purchase" min=0 step=".001">
                              </div>
                            </div>                           
                            <div class="row" style="margin-top: 10px;padding-left: 15px;">
                              <div class="col-xs">
                                <label>Keterangan Pesan</label>
                                <textarea class="form-control" type="text" name="ket_purchase"></textarea>
                              </div>
                            </div>
                            <div class="row" style="margin-top: 10px;padding-left: 15px;">
                              <div class="col-xs">
                                <input class="btn btn-primary" type="submit" value="Tambahkan">
                                {{csrf_field()}}
                              </div>
                            </div>
                          </form>

                        </div>
                      </div>

                      <div class="col-xs-4" style="padding: 20px">
                        <p style="color: salmon; font-style: italic;">Keterangan :</p>
                        <p>
                          Pilih barang yang akan diambil.
                        </p>
                        <p>
                          <b>Stok = <span id="cekstok" class="text-success"></span></b> | Safety Stok = <span id="safetystok"></span> | Max Stok = <span id="maxstok"></span>                                                  
                        </p>                        
                        <img id="img-profile"/>
                        <img>
                      </div>
                    </div>
                  
              </div>
          </div>
      </div>
      @include('gudang/notification')
    @if ($purchases->count()>0)   
      <div class="row">
        <div class="col-xs-12">
          <div class="box" style="padding: 0 30px">
              <div class="box-header">
                <h3 class="box-title">Data Barang yang sedang dipesan</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                
                
                    <table id="example1" class="table table-bordered table-hover">
                      <thead>
                        <?php $no=1; ?>
                        <tr style="background-color: rgb(230, 230, 230);">
                          <th>Action</th>
                          <th>No</th>
                          <th>Tanggal</th>
                          <th>Kode Barang</th>
                          <th>Nama Barang</th>
                          <th>Pemesan</th>
                          <th>Jumlah</th>
                          <th>Keterangan Pemesanan</th>                 
                        </tr>
                      </thead>
                      <tbody>                   
                        @forelse ( $purchases as $purchase )
                          <tr>
                            <td>
                              <a href="purchase/{{$purchase->id}}/show"><button class="btn btn-primary btn-xs">Detail</button></a>
                              @can('edit',$purchase)
                                  <a href="purchase/{{$purchase->id}}/edit"><button class="btn btn-success btn-xs">Terima</button></a>
                                  <button class="btn btn-danger btn-xs" data-purchase={{$purchase->id}} data-toggle="modal" data-target="#delete-purchase"><i class="glyphicon glyphicon-trash"></i> Hapus</button>
                              @endcan
                            </td>   
                            <td>{{ $no++ }}</td>
                            <td>{{ Carbon\Carbon::parse($purchase->tgl_purchase)->format('d-M-y') }}</td>
                            <td>{{ $purchase->products->kode_produk }}</td>
                            <td>{{ $purchase->products->nama_produk }}</td>
                            <td>{{ $purchase->employees->name }}</td>
                            <td><b>{{ number_format($purchase->qty_purchase,$purchase->products->units->dec_unit, '.', ',')}}</b>   {{ $purchase->products->units->nama_unit }}</td>
                            <td>{{ $purchase->ket_purchase }}</td>   
                                             
                          </tr>
                        @empty                      
                        @endforelse                      
                        <tr>                          
                        </tr>
                      </tbody>
                    </table>                                               
              </div>
            <!-- /.box-body -->

          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    @endif
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    @include('templates.control_sidebar')
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ url('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ url('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ url('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ url('assets/bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ url('assets/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ url('assets/dist/js/demo.js') }}"></script>
<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>

<script type="text/javascript">     
  $(document).ready(function (e) {   
    
     $('#id_produk').change(function(){  
      var idx = $(this).val();  
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({              
              type: "post",
              url: "/product/get/image/url",
              data: {
                  idx: idx
              },
              dataType: "json",
              success: function (data) {                   
                   var srcimage = 'image/' + data.image
                   $("#img-profile").addClass('box-img-purchase')
                   $('#img-profile').attr('src', srcimage)  
                      
                   document.getElementById('cekstok').innerText = Math.trunc(data.stok_produk)  
                   document.getElementById('safetystok').innerText = data.safety_stok
                   document.getElementById('maxstok').innerText = data.max_stok
              },
              error: function (data) {
                 
              }
        })        
     });    
  });  
  </script>

<!-- modal -->
<div class="modal fade" id="delete-purchase" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="background-color: rgb(200, 200, 200)">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title text-center" id="myModalLabel">Delete Confirmation</h4>
        </div>
        <form action="{{route('purchase.destroy', 'test')}}" method="post">
          {{method_field('delete')}}
          {{csrf_field()}}
          <div class="modal-body" style="background-color: rgb(230, 230, 230)">
            <p class="text-center">Apakah anda yakin akan menghapus ini ?</p>
            <input type="hidden" name="id_produk" id="del_id_purchase" value="">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Ya, hapus ini</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal">Tidak, kembali</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @include('templates.modal')
</body>
</html>
