<!DOCTYPE html>
<html>
<head>
	@include('templates.head')
  <title>Detail Data Karyawan</title>
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
        Data Karyawan
      </h1>
    </section>
    @include('gudang/notification')
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Detail Data Karyawan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div>
                <a href="{{ url('/employee') }}"> <button class="btn btn-primary btn-sm"><i class="#"></i> Kembali</button></a>
              </div><br>
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                  	<th class="col-md-2">Username</th>
                  	<td>{{ $employees->username }}</td>
                  </tr>
                  <tr>
                  	<th class="col-md-2">Nama Karyawan</th>
                  	<td>{{ $employees->name }}</td>
                  </tr>
                  <tr>
                  	<th class="col-md-2">Department</th>
                  	<td>{{ $employees->department }}</td>
                  </tr>
                  <tr>
                  	<th class="col-md-2">Akses</th>
                  	<td>{{ $employees->akses }}</td>
                  </tr>
                  <tr>
                  	<th class="col-md-2">Email</th>
                  	<td>{{ $employees->email }}</td>
                  </tr>                  
                </thead>
              </table><br>
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
