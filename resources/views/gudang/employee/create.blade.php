<!DOCTYPE html>
<html>
<head>
	@include('templates.head')
	<title>Tambah Karyawan</title>
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

		    <section class="content">
		      	<div class="row">
		        	<div class="col-xs-12">
		          		<div class="box">
		            		<div class="box-header">
		            			<div class="box-header">
					              <h5 class="box-title">Tambah data karyawan</h5>
					            </div>
					            <div class="box-body">
					            	@include('gudang/validation')
					            	@include('gudang/notification')
					            	<form action="{{ url('/employee') }}" method="post">
					            		<div>
											<label>Username</label>
											<input required="" class="form-control" type="text" name="username">
										</div><br>
										<div>
											<label>Nama</label>
											<input required="" class="form-control" type="text" name="name">
										</div><br>
										<div>
											<label>Department</label>
											<select class="form-control" name="department">
												<option>- Pilih Department -</option>
												@foreach($department as $data)
												<option value="{{$data->department}}">{{$data->department}}</option>
												@endforeach
											</select>											
										</div><br>
										<div>
											<label>Email</label>
											<input class="form-control" type="email" name="email">
										</div><br>										
										<div>
											<label>Akses</label>
											<select class="form-control" name="akses">
												<option>- Pilih Tipe Akses -</option>												
												<option value="user">User</option>	
												<option value="admin">Admin</option>												
											</select>
										</div><br>
										<br><br>
										<div>
											<input class="btn btn-primary" type="submit" name="submit" value="Tambahkan">
											{{csrf_field()}}
											<input type="reset" class="btn btn-danger" value="Reset">
										</div>
					            	</form>
					            </div>
		            		</div>
		        		</div>
		    		</div>
				</div>
			</section>
		</div>
		<!-- /.content-wrapper -->

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			@include('templates.control_sidebar')
		</aside>
	</div>
@include('templates.scripts')
</body>
</html>
