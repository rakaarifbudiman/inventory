<!DOCTYPE html>
<html>
<head>
	@include('templates.head')
  <title>Laporan Pengambilan</title>

  <style type="text/css">
    .box-body img{
      width: 50px;
    }

    @media print{
      .none{
        display: none;
      }
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
        Laporan Pengambilan Barang
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

              <table id="report_sell_table" class="table table-bordered table-hover">
                <thead>
                  <?php $no=1; ?>
                  <tr style="background-color: rgb(230, 230, 230);">
                    @if(Auth::user()->akses !== 'admin')
                      <th>Action</th>
                    @else
                      <th class="none">Action</th>
                    @endif
                    <th>No</th>
                    <th>Tanggal Pengambilan</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Diambil oleh</th>
                    <th>Dibuat oleh</th>
                    <th>Keterangan Ambil</th>                    
                  </tr>
                </thead>
                <tbody>
                  @foreach($sells as $sell)
                  <tr>
                    <td>
                    @can('edit',$sell)             
                      <button class="btn btn-danger btn-xs" data-delsell={{$sell->id}} data-toggle="modal" data-target="#delete-sell"><i class="glyphicon glyphicon-trash"></i> Hapus</button>                     
                    @endcan
                    </td>
                    <td>{{ $no++ }}</td>
                    <td>{{ Carbon\Carbon::parse($sell->tgl_sell)->format('d-M-y') }}</td>
                    <td>{{ $sell->products->kode_produk }}</td>
                    <td>{{ $sell->products->nama_produk }}</td>
                    <td>{{ number_format($sell->qty,$sell->products->units->dec_unit, '.', ',') }}</td>
                    <td>{{ $sell->products->units->nama_unit }}</td>
                    <td>{{ $sell->employees->name }}</td>
                    <td>{{ $sell->creators->name }}</td>
                    <td>{{ $sell->ket_sell }}</td>
                    
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
    $('#report_sell_table').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    })
  })

  
</script>

<!-- modal -->
<div class="modal fade" id="delete-sell" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="background-color: rgb(200, 200, 200)">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-center" id="myModalLabel">Delete Confirmation</h4>
      </div>
      <form action="{{route('report.destroy', 'test')}}" method="post">
        {{method_field('delete')}}
        {{csrf_field()}}
        <div class="modal-body" style="background-color: rgb(230, 230, 230)">
          <p class="text-center">Apakah anda yakin akan menghapus ini?</p>
          <input type="hidden" name="id_sell" id="del_id_sell" value="">
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
