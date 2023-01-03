<!DOCTYPE html>
<html>
<head>
	@include('templates.head')
	<title>Edit Data Batch</title>

	<style type="text/css">
		.content img{
			width: 80px;
			margin-bottom: 5px;
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
		        Data Batch Produk
		      </h1>

		    <section class="content">
		      	<div class="row">
		        	<div class="col-xs-12">
		          		<div class="box">
		            		<div class="box-header">		            			
					            <div class="box-body">
					            	@include('gudang/validation')
									@include('gudang/notification')
					            	{!! Form::model($batch,['route'=>['batch.update',$batch->id],'method'=>'PUT', 'enctype'=>'multipart/form-data']) !!}
				            		<div class="form-group">
										<label>Kode Produk</label>
										<input class="form-control" type="text" name="kode_produk" value="{{ $batch->products->kode_produk }}" readonly>
									</div>
									<div class="form-group">
										<label>Nama Produk</label>
										<input class="form-control" type="text" name="nama_produk" value="{{ $batch->products->nama_produk }}" readonly>
									</div>		
                                    <div class="form-group">
										<label>Nomor Batch</label>
										<input class="form-control" type="text" name="no_batch" value="{{ $batch->no_batch }}">
									</div>				
									<div class="form-group">
										<label>Stok Batch</label>
										<input class="form-control" type="number" name="stok" value="{{ $batch->stok }}">
									</div><br>
									<div class="form-group">
										<label>Satuan Produk</label>
										<input class="form-control" type="text" name="nama_unit" value="{{ $batch->products->units->nama_unit }}" readonly>
									</div>									
									<div class="form-group">
										<label>Lokasi</label>
										<input class="form-control" type="text" name="lokasi" value="{{ $batch->products->lokasi }}" readonly>
									</div>
									<div class="form-group" {{$batch->products->categories->nama_kategori=='Reagen' ? '' : 'hidden'}}>
										<label>Expired Date</label>
										<input class="form-control" type="date" name="expired" value="{{$batch->expired==null ? '' : Carbon\Carbon::parse($batch->expired)->format('Y-m-d')}}">
									</div>
									<div class="form-group">
										<label>Keterangan</label>
										<textarea class="form-control" type="text" name="ket_batch" rows="4">{{ $batch->ket_batch }}</textarea>
									</div>
                                    <input class="form-control" type="hidden" name="id" value="{{ $batch->id }}">
                                    <input class="form-control" type="hidden" name="id_produk" value="{{ $batch->id_produk }}">
									<div class="form-group">
										<input class="btn btn-primary" type="submit" name="submit" value="Simpan">
										<a href="{{ url('/product') }}" class="btn btn-success">Kembali</a>										
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
