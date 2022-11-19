<!DOCTYPE html>
<html>
<head>
	@include('templates.head')
	<title>Edit Karyawan</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" />
	<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.min.js"></script>	
	<style>
		.select2-selection__choice {
  		color: blueviolet !important
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
											<option value={{ $employees->active }}>{{ $employees->active==1 ? 'Ya' : 'Tidak' }}</option>
											<option value=1>Ya</option>		
											<option value=0>Tidak</option>												
										</select>										
									</div><br>
									@if ($employees->akses=='admin')
									<div class="form-group">
										<label for="role">Role</label>
										<select class="select2-multiple form-control" name="role[]" multiple="multiple"
										  id="role">
										  @foreach($categories as $category)
                                            <option value="{{$category->nama_kategori}}"
                                              @foreach ($roles as $role)
                                                {{($category->nama_kategori==$role) ? 'selected' : ''}}
                                              @endforeach
                                              >{{$category->nama_kategori}}
                                            </option>                                                  
                                          @endforeach									  
										    								              
										</select>
									  </div>
									<br>
									@endif
									
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
       
      <script>
        $(document).ready(function() {
            // Select2 Multiple
            $('#role').select2({
                placeholder: "Select",
                allowClear: true
            });

        });

    </script>
	
</body>
</html>
