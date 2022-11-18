<!DOCTYPE html>
<html>
<head>
	@include('templates.head')
	<title>Edit Karyawan</title>
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
		        Data Pasien
		      </h1>

		    <section class="content">
		      	<div class="row">
		        	<div class="col-xs-12">
		          		<div class="box">
		            		<div class="box-header">
		            			<div class="box-header">
					              <h5 class="box-title">Edit Akses Karyawan</h5>
					            </div>
					            <div class="box-body">
					            	@include('gudang/validation')
									@include('gudang/notification')
					            	{!! Form::model($employees,['route'=>['employee.update',$employees->id],'method'=>'PUT']) !!}
				            		<div>
										<label>Nama Karyawan</label>
										<input class="form-control" type="text" name="name" value="{{ $employees->name }}" readonly>
									</div><br>
									<div>
										<label>Akses</label>
										<select class="form-control" name="akses">																					
											<option {{ $employees->akses }}>{{ $employees->akses }}</option>
											<option value="user">User</option>		
											<option value="admin">Admin</option>												
										</select>										
									</div><br>
									<div>
										<label>Aktif ?</label>
										<select class="form-control" name="active">																					
											<option {{ $employees->active }}>{{ $employees->active==1 ? 'Ya' : 'Tidak' }}</option>
											<option value=1>Ya</option>		
											<option value=0>Tidak</option>												
										</select>										
									</div><br>
									<br><br>
									<div>
										<input class="btn btn-primary" type="submit" name="submit" value="Simpan">
										<input type="reset" class="btn btn-danger" value="Reset">
										{{csrf_field()}}
										<input type="hidden" name="_method" value="PUT">
									</div>
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
