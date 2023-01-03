<!DOCTYPE html>
<html>
<head>
	@include('templates.head')
  <title>Halaman Produk</title>

  <style type="text/css">
    .box-body img{
      width: 50px;
    }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
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
        Data Barang
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">            
            <!-- /.box-header -->
            <div class="box-body">
              @include('gudang/notification')
              <div>
								@if(Auth::user()->akses == 'admin')
                <a href="{{ route('product.create') }}"> <button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-plus"></i> Tambah data produk</button></a>
								@endif
              </div><br>
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                  <?php $no=1; ?>
                  <tr style="background-color: rgb(230, 230, 230);">
                    <th>Action</th>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>No Katalog</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Foto</th>
                    <th>Stok</th>
                    <th>Satuan</th>
                    <th>Safety Stok</th>
                    <th>Max Stok</th>
                    <th>Lokasi</th>
                    <th>Keterangan</th>                    
                  </tr>
                </thead>
                <tbody>
                  @foreach($products as $product)
                  <tr>
                    <td>
                      <a href="product/{{$product->id}}/show"><button class="btn btn-primary btn-xs">Detail</button></a>
											@can('edit',$product)
                        <a href="product/{{$product->id}}/edit"><button class="btn btn-warning btn-xs">Edit</button></a>
                        {{-- <a href="product_conversion/{{$product->id}}/edit"><button class="btn btn-success  btn-xs">Conversions</button></a> --}}
                        <button class="btn btn-danger btn-xs" data-delproduk={{$product->id}} data-toggle="modal" data-target="#delete-produk"><i class="glyphicon glyphicon-trash"></i> Hapus</button>
                      @endcan	                      
											
                    </td>
                    <td>{{ $no++ }}</td>
                    <td>{{ $product->kode_produk }}</td>
                    <td>{{ $product->no_catalog }}</td>
                    <td>{{ $product->nama_produk }}</td>
                    <td>{{ $product->categories->nama_kategori }}</td>
                    <td><img src="{{asset('image/'.$product->image)}}" alt="gambar"></td>
                    <td>{{ number_format($product->stok_produk,$product->units->dec_unit, '.', ',') }}</td>
                    <td>{{ $product->units->nama_unit }}</td>
                    <td>{{ $product->safety_stok }}</td>
                    <td>{{ $product->max_stok }}</td>
                    <td>{{ $product->lokasi }}</td>
                    <td>{{ $product->ket_produk }}</td>                    
                  </tr>
                  @endforeach
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

<!-- modal -->
<div class="modal fade" id="delete-produk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="background-color: rgb(200, 200, 200)">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-center" id="myModalLabel">Delete Confirmation</h4>
      </div>
      <form action="{{route('product.destroy', 'test')}}" method="post">
        {{method_field('delete')}}
        {{csrf_field()}}
        <div class="modal-body" style="background-color: rgb(230, 230, 230)">
          <p class="text-center">Apakah anda yakin akan menghapus ini?</p>
          <input type="hidden" name="id_produk" id="del_id_produk" value="">
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
