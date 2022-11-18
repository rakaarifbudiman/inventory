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
        Data Produk
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
                        <div class="box-header">
                          <h3 class="box-title">Detail data produk</h3>
                        </div>                        
                          <p class="card-text"><b>{{ $products->kode_produk }} : {{ $products->nama_produk }}</b><br>
                            <b>Kategori</b> : {{ $products->categories->nama_kategori }}<br>
                            <b>Stok</b> : <span class="bg-success"> {{ $products->stok_produk }} {{ $products->units->nama_unit }}</span><br>
                            <b>Safety Stok</b> : {{ $products->safety_stok }}<br>
                            <b>Max Stok</b> : {{ $products->max_stok }}<br>
                              <b>Lokasi</b> : {{ $products->lokasi }}<br>
                                <b>Keterangan</b> : {{ $products->ket_produk }}
                          </p>
                          <div>
                            <a href="{{ url('/product') }}"> <button class="btn btn-success btn-sm"><i class="#"></i> Kembali</button></a>
                          </div><br>
                      </div>
                      <div class="col-lg-8">
                        <img class="card-img-top" src="{{asset('image/'.$products->image)}}" style="width: 200px;height: 200px;">
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
      <!-- Main content Stok Masuk-->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Laporan barang masuk</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              @include('gudang/notification')

              <div style="margin-bottom: 10px;" class="print mb-4 none">
                <form class="form-inline" action="#" method="get">
                  <div class="form-group">
                    Dari Tanggal :
                    <input type="date" name="tgl_awal" class="form-control input-sm"> 
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Sampai Tanggal :
                    <input type="date" name="tgl_akhir" class="form-control input-sm">
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm" name="cari">Filter</button>
                    <button type="submit" class="btn btn-danger btn-sm" name="reset">Reset</button>                    
                  </div>
                </form>
              </div>

              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <?php $no=1; ?>
                  <tr style="background-color: rgb(230, 230, 230);">
                    <th>No</th>
                    <th>Tanggal Pemesanan</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Dipesan oleh</th>
                    <th>Dibuat oleh</th>
                    <th>Keterangan Pemesanan</th>
                    @if(Auth::user()->akses !== 'admin')
                      <th style="display: none;" class="none">Action</th>
                    @else
                      <th class="none">Action</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                  @foreach($purchases as $purchase)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ Carbon\Carbon::parse($purchase->tgl_purchase)->format('d-M-y') }}</td>
                    <td>{{ $purchase->products->kode_produk }}</td>
                    <td>{{ $purchase->products->nama_produk }}</td>
                    <td>{{ $purchase->qty_purchase }}</td>
                    <td>{{ $purchase->products->units->nama_unit }}</td>
                    <td>{{ $purchase->employees->name }}</td>
                    <td>{{ $purchase->creators->name }}</td>
                    <td>{{ $purchase->ket_purchase }}</td>
                    @if(Auth::user()->akses !== 'admin')
                    <td style="display: none;" class="none">
                      <button style="display: none;" class="btn btn-danger btn-xs" data-delid={{$purchase->id_purchase}} data-toggle="modal" data-target="#delete"><i class="glyphicon glyphicon-trash"></i> Hapus</button> 
          					</td>
                    @else
                    <td class="none">
                      <button class="btn btn-danger btn-xs" data-delid={{$purchase->id_purchase}} data-toggle="modal" data-target="#delete"><i class="glyphicon glyphicon-trash"></i> Hapus</button> 
                    </td>
                    @endif
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
      <!-- /.content Stok Masuk-->

      <!-- Main content Stok Keluar-->     
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Laporan pengambilan barang</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <?php $no=1; ?>
                  <tr style="background-color: rgb(230, 230, 230);">
                    <th>No</th>
                    <th>Tanggal Pengambilan</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Diambil oleh</th>
                    <th>Dibuat oleh</th>
                    <th>Keterangan Ambil</th>
                    @if(Auth::user()->akses !== 'admin')
                      <th style="display: none;" class="none">Action</th>
                    @else
                      <th class="none">Action</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                  @foreach($sells as $sell)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ Carbon\Carbon::parse($sell->tgl_sell)->format('d-M-y') }}</td>
                    <td>{{ $sell->products->kode_produk }}</td>
                    <td>{{ $sell->products->nama_produk }}</td>
                    <td>{{ $sell->qty }}</td>
                    <td>{{ $sell->products->units->nama_unit }}</td>
                    <td>{{ $sell->employees->name }}</td>
                    <td>{{ $sell->creators->name }}</td>
                    <td>{{ $sell->ket_sell }}</td>
                    @if(Auth::user()->akses !== 'admin')
                    <td style="display: none;" class="none">
                      <button style="display: none;" class="btn btn-danger btn-xs" data-delid={{$sell->id_sell}} data-toggle="modal" data-target="#delete"><i class="glyphicon glyphicon-trash"></i> Hapus</button> 
          					</td>
                    @else
                    <td class="none">
                      <button class="btn btn-danger btn-xs" data-delid={{$sell->id_sell}} data-toggle="modal" data-target="#delete"><i class="glyphicon glyphicon-trash"></i> Hapus</button> 
                    </td>
                    @endif
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
      <!-- /.content Stok Keluar-->
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
