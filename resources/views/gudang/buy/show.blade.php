<!DOCTYPE html>
<html>
<head>
	@include('templates.head')
  <title>Detail Data Produk</title>
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
        Detail Pemesanan Barang
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body">                          
                <div class="card-body">
                  <div class="row">
                      <div class="col-lg-4">                                        
                          <p class="card-text"><b>{{ $purchase->products->kode_produk }} &emsp;: {{ $purchase->products->nama_produk }}</b><br>
                            <b>Kategori</b> &emsp;: {{ $purchase->products->categories->nama_kategori }}<br>
                            <b>Tanggal Pemesanan</b> &emsp;: {{ Carbon\Carbon::parse($purchase->tgl_purchase)->format('d-M-y') }}<br>
                            <b>Tanggal Terima</b> &emsp;: {{ $purchase->tgl_terima ? Carbon\Carbon::parse($purchase->tgl_terima)->format('d-M-y') : null}}<br>
                            <b>Dipesan oleh</b> &emsp;: {{ $purchase->employees->name }}<br>
                            <b>Dibuat oleh</b> &emsp;: {{ $purchase->creators->name }}<br>
                            <b>Qty</b> &emsp;: <span class="bg-success"> {{ $purchase->qty_purchase }} {{ $purchase->products->units->nama_unit }}</span><br>                            
                            <b>Status</b> &emsp;: {{ $purchase->status==1 ?'Sudah Masuk Laporan' : 'Belum Masuk Laporan' }}<br>
                            <b>Keterangan</b> &emsp;: {{ $purchase->ket_purchase }}
                          </p>
                          <div>
                            <a href="{{ url('/purchase') }}"> <button class="btn btn-success btn-sm"><i class="#"></i> Kembali</button></a>
                          </div><br>
                      </div>
                      <div class="col-lg-8">
                        <img class="card-img-top" src="{{asset('image/'.$purchase->products->image)}}" style="width: 200px;height: 200px;">
                      </div>
                  </div>
                </div>
              
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
</body>
</html>
