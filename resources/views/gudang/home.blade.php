<!DOCTYPE html>
<html>
<head>
  @include('templates.head')
  <title>R&D Bersatu</title>
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
        Selamat datang di Sistem Stok R&D        
      </h1>
    </section>
    @include('gudang/notification')
    @if ($sells->count()>0 && Auth()->user()->akses=='admin')
    <!-- Barang Keluar -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box" style="padding: 0 30px">
              <div class="box-header">
                <h3 class="box-title">Data Barang yang diambil</h3>
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
                          <th>Pengambil</th>
                          <th>Dibuat Oleh</th>
                          <th>Jumlah</th>
                          <th>Lokasi</th>
                          <th>Keterangan Ambil</th>                                           
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($sells as $sell)
                        <tr>
                          <td>
                            <form action="{{ url('sell')}}/{{$sell->id}}" method="post">
                              {{method_field('delete')}}
                              {{csrf_field()}}
                              <input class="btn btn-danger btn-sm" type="submit" name="submit" value="Cancel">
                              <a href="/sell/update/by/{{ $sell->id}}" class="btn btn-primary btn-sm">Selesai</a>
                              {{csrf_field()}}
                              <input type="hidden" name="_method" value="DELETE">
                            </form>                            
                          </td>
                          <td>{{ $no++ }}</td>
                          <td>{{ Carbon\Carbon::parse($sell->tgl_sell)->format('d-M-y') }}</td>
                          <td>{{ $sell->products->kode_produk }}</td>
                          <td>{{ $sell->products->nama_produk }}</td>
                          <td>{{ $sell->employees->name }}</td>
                          <td>{{ $sell->creators->name }}</td>
                          <td><b>{{ $sell->qty }}</b>   {{ $sell->products->units->nama_unit }}</td>
                          <td>{{ $sell->products->lokasi }}</td>
                          <td>{{ $sell->ket_sell }}</td>
        
                          
                        </tr>
                        @endforeach
                        <tr>
                          
                        </tr>
                      </tbody>
                    </table>
                    <div style="margin-top: 20px">
                      <a href="{{ route('sell.update') }}" class="btn btn-success"><i class="glyphicon glyphicon-circle-arrow-right"></i> Selesai</a>
                    </div>                
              </div>
            <!-- /.box-body -->
    
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
    <!-- End Barang Keluar -->    
    @endif
    @if (Auth()->user()->akses=='admin' && $minstocks->count()>0)
    <!-- Suggest Barang Abis -->
        <div class="row">
          <div class="col-xs-12">
            <div class="box" style="padding: 0 30px">
                <div class="box-header">
                  <h3 class="box-title">Barang yang akan habis</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  
                  
                      <table id="example1" class="table table-bordered table-hover">
                        <thead>
                          <?php $no=1; ?>
                          <tr style="background-color: rgb(230, 230, 230);">
                            <th>Action</th>
                            <th>No</th>                        
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>                        
                            <th>Stok</th>
                            <th>Lokasi</th>  
                            <th>Saran Qty Pemesanan</th>                                                            
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($minstocks as $index=>$stok)
                            @if($cekstok[$index]<$stok->safety_stok)
                              <tr>
                                <td>                                                     
                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalbuy{{$stok->id}}">Masukkan Pembelian</a>                                                      
                                </td>
                                <td>{{ $no++ }}</td>                        
                                <td>{{ $stok->kode_produk }}</td>
                                <td>{{ $stok->nama_produk }}</td>                        
                                <td><b>{{ $stok->stok_produk }}</b>   {{ $stok->units->nama_unit }}</td>
                                <td>{{ $stok->lokasi }}</td>   
                                <td>{{ $stok->max_stok - $cekstok[$index] }}</td>                   
                              </tr>
                              @include('gudang.buy.modal.home-buy')
                            @endif
                          @endforeach
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
    <!-- End Suggest Barang Abis -->
    @endif
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



@include('templates.scripts')
</body>
</html>
