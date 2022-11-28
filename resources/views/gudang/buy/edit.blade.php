<!DOCTYPE html>
<html>
<head>
	@include('templates.head')
	<title>Terima Barang</title>

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
		        Penerimaan Barang
		      </h1>

		    <section class="content">
		      	<div class="row">
		        	<div class="col-xs-12">
		          		<div class="box">
		            		<div class="box-header">		            			
					            <div class="box-body">
					            	@include('gudang/validation')
                                    @include('gudang.notification')
                                    <a href="{{ url('/purchase') }}"> <button class="btn btn-danger"><i class="#"></i> Kembali</button></a>
					            	{!! Form::model($purchase,['route'=>['purchase.update',$purchase->id],'method'=>'PUT', 'enctype'=>'multipart/form-data']) !!}
				            		<div class="form-group">
										<label>Kode Produk</label>
										<input class="form-control" type="text" name="kode_produk" value="{{ $purchase->products->kode_produk }}" readonly>
									</div>
									<div class="form-group">
										<label>Nama Produk</label>
										<input class="form-control" type="text" name="nama_produk" value="{{ $purchase->products->nama_produk }}" readonly>
									</div>
									<div class="form-group">
										<label>Kategori Produk</label>
                                        <input class="form-control" type="text" name="categories" value="{{ $purchase->products->categories->nama_kategori }}" readonly>										
									</div><br>
									<div class="form-group">
										<label>Foto Produk</label><br>
										<img src="{{asset('image/'.$purchase->products->image)}}" alt="gambar">										
									</div>
                                    <div class="form-group">
										<label>Dipesan Oleh</label>
                                        <input class="form-control" type="text" name="id_karyawan" value="{{ $purchase->employees->name }}" readonly>										
									</div>
                                    <div class="form-group">
										<label>Dibuat Oleh</label>
                                        <input class="form-control" type="text" name="created_by" value="{{ $purchase->creators->name }}" readonly>										
									</div>
									<div class="form-group">
										<label>Qty Pemesanan</label>
										<input class="form-control" type="number" name="qty_purchase" value="{{ number_format($purchase->qty_purchase,$purchase->products->units->dec_unit, '.', ',')}}" min=0>
									</div>
									<div class="form-group">
										<label>Satuan Produk</label>
                                        <input class="form-control" type="text" name="satuan" value="{{ $purchase->products->units->nama_unit }}" readonly>										
									</div>
									<div class="form-group">
										<label>Tanggal Pemesanan</label>
                                        <input required="" class="form-control form-control-sm" type="date" name="tgl_purchase" value="{{$purchase->tgl_purchase ? Carbon\Carbon::parse($purchase->tgl_purchase)->format('Y-m-d') : ''}}">										
									</div>
                                    <div class="form-group">
										<label>Tanggal Penerimaan</label>
                                        <input required="" class="form-control form-control-sm" type="date" name="tgl_terima" value="{{Carbon\Carbon::parse($purchase->tgl_terima)->format('Y-m-d')}}">										
									</div>	
									<div class="form-group" {{$purchase->products->categories->kode_kategori=='REA' ? '' : 'hidden'}}>
										<label>Nomor Batch</label>
                                        <input class="form-control" type="text" name="no_batch" value="{{ $purchase->id_batch ? $purchase->batches->no_batch : ''}}">										
									</div>
									<div class="form-group" {{$purchase->products->categories->kode_kategori=='REA' ? '' : 'hidden'}}>
										<label>Expired Date</label>
                                        <input class="form-control form-control-sm" type="date" name="expired" value="{{$purchase->expired ? Carbon\Carbon::parse($purchase->expired)->format('Y-m-d') : ''}}">										
									</div>									
									<div class="form-group">
										<label>Keterangan Pemesanan</label>
										<textarea class="form-control" type="text" name="ket_purchase" rows="4">{{ $purchase->ket_purchase }}</textarea>
									</div>
									<div class="form-group">
										<input class="btn btn-primary" type="submit" name="submit" value="Simpan">										
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
