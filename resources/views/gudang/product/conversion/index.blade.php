<!DOCTYPE html>
<html>
<head>
	@include('templates.head')
  <title>Data Satuan</title>
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
        Data Satuan
      </h1>

    </section>

    <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
                <div class="box" style="padding: 0 30px">
                  <div class="box-header">
                    <div class="box-header">
                      <h5 class="box-title">Tambah satuan</h5>
                    </div>
                    <div class="box-body">
                      @include('gudang/validation')
                      <form action="{{ url('/unit') }}" method="post">
                        <div>
                          <label>Satuan</label>
                          <!-- <input class="form-control" type="text" name="nama_unit"> -->
                          {!!Form::text('nama_unit', null, ['class'=>'form-control'])!!}
                        </div>
                        <div>
                          <label>Desimal</label>
                          <!-- <input class="form-control" type="text" name="nama_unit"> -->
                          {!!Form::number('dec_unit', null, ['class'=>'form-control'])!!}
                        </div><br><br>
                        <div>
                          <input class="btn btn-primary" type="submit" name="submit" value="Tambahkan">
                          {{csrf_field()}}
                        </div>
                      </form>
                    </div>
                  </div>
              </div>
          </div>
      </div>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box" style="padding: 0 30px">
            <div class="box-header">
              <div class="box-header">
                <h3 class="box-title">Data satuan</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                @include('gudang/notification')
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <?php $no=1; ?>
                    <tr style="background-color: rgb(230, 230, 230);">
                      <th>No</th>
                      <th>Dari</th>
                      <th>Ke</th>
                      <th>Nilai Konversi</th>                 
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($conversions as $konversi)
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{ $konversi->from_units->nama_unit }}</td>
                      <td>{{ $konversi->to_units->nama_unit }}</td>
                      <td>{{ $konversi->nilai_konversi }}</td>
                      <td>
                        <a href="{{ url('unit') }}/{{$konversi->id}}/edit"><button class="btn btn-warning btn-xs">Edit</button></a>
                        <button class="btn btn-danger btn-xs" data-delid={{$konversi->id}} data-toggle="modal" data-target="#delete"><i class="glyphicon glyphicon-trash"></i> Hapus</button>
                      </td>
                    </tr>
                    @empty
                    @endforelse
                  </tbody>
                </table>
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
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="background-color: rgb(200, 200, 200)">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span> 
        </button>
        <h4 class="modal-title text-center" id="myModalLabel">Delete Confirmation</h4>
      </div>
      <form action="{{route('unit.destroy', 'test')}}" method="post">
        {{method_field('delete')}}
        {{csrf_field()}}
        <div class="modal-body" style="background-color: rgb(230, 230, 230)">
          <p class="text-center">Apakah anda yakin akan menghapus ini?</p>
          <input type="hidden" name="id_unit" id="del_id" value="">
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


