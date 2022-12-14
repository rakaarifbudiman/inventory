<!DOCTYPE html>
<html>
<head>
	@include('templates.head')
	<title>Edit Data Produk</title>

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
		        Data Produk
		      </h1>

		    <section class="content">
		      	<div class="row">
		        	<div class="col-xs-12">
		          		<div class="box">
		            		<div class="box-header">
		            			<div class="box-header">
					              <h5 class="box-title">Edit data produk</h5>
					            </div>
					            <div class="box-body">
					            	@include('gudang/validation')
									@include('gudang/notification')
					            	{!! Form::model($products,['route'=>['product.update',$products->id],'method'=>'PUT', 'enctype'=>'multipart/form-data']) !!}
				            		<div class="form-group">
										<label>Kode Produk</label>
										<input class="form-control" type="text" name="kode_produk" value="{{ $products->kode_produk }}">
									</div>
									<div class="form-group">
										<label>No Katalog</label>
										<input class="form-control" type="text" name="no_catalog" value="{{ $products->no_catalog }}">
									</div>
									<div class="form-group">
										<label>Nama Produk</label>
										<input class="form-control" type="text" name="nama_produk" value="{{ $products->nama_produk }}">
									</div>
									<div class="form-group">
										<label>Kategori Produk</label>
										{{ Form::select('id_kategori', \App\Models\Category::pluck('nama_kategori', 'id'), NULL, ['class'=>'form-control']) }}
									</div><br>
									<div class="form-group">
										<label>Jenis Reagen</label>
										{{ Form::select('jenis_reagen', ['Padat'=>'Padat','Cair'=>'Cair'], $products->jenis_reagen, ['class'=>'form-control']) }}
									</div><br>									
									<div class="form-group">
										<label>Foto Produk</label><br>
										<img src="{{asset('image/'.$products->image)}}" alt="gambar">
										<input type="file" name="image" value="{{ $products->image }}" class="form-control">
										<!-- <input class="form-control" type="text" name="image" value="{{ $products->image }}"> -->
									</div>
									<div class="form-group">
										<label>Stok Produk</label>
										<input class="form-control" type="number" name="stok_produk" value="{{ $products->stok_produk }}">
									</div><br>
									<div class="form-group">
										<label>Satuan Produk</label>
										{{ Form::select('id_unit', \App\Models\Unit::pluck('nama_unit', 'id'), NULL, ['class'=>'form-control','style'=>'pointer-events: none;']) }}
									</div>
									<div class="form-group">
										<label>Safety Stok</label>
										<input required="" class="form-control" type="number" name="safety_stok" value="{{$products->safety_stok}}">
									</div>
									<div class="form-group">
										<label>Max Stok</label>
										<input required="" class="form-control" type="number" name="max_stok" value="{{$products->max_stok}}">
									</div>
									<div class="form-group">
										<label>Lokasi</label>
										<input class="form-control" type="text" name="lokasi" value="{{ $products->lokasi }}">
									</div>
									<div class="form-group" {{$products->categories->nama_kategori=='Reagen' ? '' : 'hidden'}}>
										<label>Expired Date</label>
										<input class="form-control" type="date" name="expired" value="{{$products->expired==null ? '' : Carbon\Carbon::parse($products->expired)->format('Y-m-d')}}">
									</div>
									<div class="form-group">
										<label>Keterangan</label>
										<textarea class="form-control" type="text" name="ket_produk" rows="4">{{ $products->ket_produk }}</textarea>
									</div>
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
