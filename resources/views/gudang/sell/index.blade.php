<!DOCTYPE html>
<html>
<head>
  @include('templates.head')
  <title>Pengambilan Barang</title>
</head>
<body class="hold-transition skin-blue sidebar-mini" style="min-height: 400px;">
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
        Data Pengambilan Barang
      </h1>

    </section>

    <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
                <div class="box" style="padding: 0 30px">
                    <div class="box-header">
                      <h5 class="box-title">Barang yang akan diambil</h5>                    
                    </div>               
                    
                    <div class="row">
                      <div class="col-xs-8">
                        <div class="box-body">
                          @include('gudang/validation')
                          
                          <form action="{{ route('sell.store') }}" method="post">
                            <div class="row">                              
                              <div class="col-xs-6">
                                <label>Tanggal</label>
                                <input required="" class="form-control form-control-sm" type="date" name="tgl_sell" value="{{Carbon\Carbon::parse(now())->format('Y-m-d')}}">
                              </div>
                              <div class="col-xs-6">
                                <label>Pengambil</label>
                                <select class="form-control form-control-sm" name="id_karyawan" style="{{Auth::user()->akses=='admin' ? '' : 'pointer-events: none;' }}">
                                  <option value="{{Auth::user()->id}}">{{Auth::user()->name}}</option>
                                  @foreach($employees as $employee)
                                  <option value="{{$employee->id}}">{{$employee->name}}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>     
                            <div class="col-xs">
                              <label>Pilih Kategori</label>
                              <select class="form-control form-control-sm" name="id_kategori" id="id_kategori">                                  
                                @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->nama_kategori}}</option>
                                @endforeach
                              </select>
                            </div>                      

                            <div class="row" style="margin-top: 10px;">
                              <div class="col-xs-6">
                                <label>Nama Barang</label>
                                <select class="form-control form-control-sm" name="id_produk" id="id_produk">
                                  <option>- Nama barang -</option>
                                  @foreach($products as $product)
                                  <option value="{{old('id_produk',$product->id)}}" data-id="{{$product->id}}">{{$product->nama_produk}} ({{$product->units->nama_unit}}) - {{$product->categories->nama_kategori}}
                                  </option>
                                  @endforeach
                                </select>
                              </div>                              
                              <div class="col-xs-6">
                                <label>Jumlah</label>
                                <input class="form-control" type="number" name="qty" min=0 step=".001">
                              </div>
                              <div class="col-xs-12" id="div-batch">
                                <label>Pilih No Batch</label>
                                <select class="form-control form-control-sm" name="id_batch" id="id_batch">                                  
                                </select>
                              </div>
                            </div>                           
                            <div class="row" style="margin-top: 10px;padding-left: 15px;">
                              <div class="col-xs">
                                <label>Keterangan Ambil</label>
                                <textarea class="form-control" type="text" name="ket_sell"></textarea>
                              </div>
                            </div>
                            <div class="row" style="margin-top: 10px;padding-left: 15px;">
                              <div class="col-xs">
                                <input class="btn btn-primary" type="submit" value="Tambahkan">
                                {{csrf_field()}}
                              </div>
                            </div>
                          </form>

                        </div>
                      </div>

                      <div class="col-xs-4" style="padding: 20px">
                        <p style="color: salmon; font-style: italic;">Keterangan :</p>
                        <p>
                          Pilih barang yang akan diambil.
                        </p>
                        <p>
                          Stok = <span id="cekstok"></span>
                        </p>
                        <img id="img-profile"/>
                        <img>
                      </div>
                    </div>
                  
              </div>
          </div>
      </div>
      @include('gudang/notification')
    @if ($sells->count()>0)   
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
                          <th>No</th>
                          <th>Tanggal</th>
                          <th>Kode Barang</th>
                          <th>Nama Barang</th>
                          <th>Pengambil</th>
                          <th>Jumlah</th>
                          <th>Keterangan Ambil</th>                 
                        </tr>
                      </thead>
                      <tbody>                   
                        @forelse ( $sells as $sell )
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ Carbon\Carbon::parse($sell->tgl_sell)->format('d-M-y') }}</td>
                            <td>{{ $sell->products->kode_produk }}</td>
                            <td>{{ $sell->products->nama_produk }}</td>
                            <td>{{ $sell->employees->name }}</td>
                            <td><b>{{ number_format($sell->qty,$sell->products->units->dec_unit, '.', ',') }}</b>   {{ $sell->products->units->nama_unit }}</td>
                            <td>{{ $sell->ket_sell }}</td>                            
                          </tr>
                        @empty                      
                        @endforelse                      
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
      <!-- /.row -->
    @endif
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
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

<script type="text/javascript">     
  $(document).ready(function (e) {    
     $('#id_produk').change(function(){ 
      var idx = $(this).val();  
      


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({              
              type: "post",
              url: "/product/get/image/url",
              data: {
                  idx: idx
              },
              dataType: "json",
              success: function (data) {                   
                   var srcimage = 'image/' + data.image
                   $("#img-profile").addClass('box-img-sell')
                   $('#img-profile').attr('src', srcimage)                       
                   document.getElementById('cekstok').innerText = data.stok_produk + " " + data.nama_unit
              },
              error: function (data) {
                 
              }
        });
        $.ajax({              
              type: "post",
              url: "/product/get/batch",
              data: {
                  idx: idx
              },
              dataType: "json",
              success: function (data_batch) {                            
                var len = 0;
                if(data_batch != null){
                  len = data_batch.length;
                }

                if(len > 0){
                  // Read data_batch and create <option >
                  for(var i=0; i<len; i++){

                    var id = data_batch[i].id;
                    var name = data_batch[i].no_batch;
                    var stok = data_batch[i].stok;
                    var expired =  moment(data_batch[i].expired).format('DD-MMM-YYYY');

                    var option = "<option value='"+id+"'>"+name+" | Stok = " + stok +" | Expired = " + expired +"</option>"; 

                    $("#id_batch").append(option); 
                  } 
                }             
                   
              },
              error: function (data_batch) {
                 
              }
        })                
     });    


     //load awal
     var idx = $('#id_kategori').val();  
     
     $('#div-batch').addClass('hidden');    
     $('#id_produk').find('option').not(':first').remove();
     $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
     $.ajax({              
              type: "post",
              url: "/product/get/by/category",
              data: {
                  idx: idx
              },
              dataType: "json",
              success: function (data) {                
                var len = 0;
                if(data != null){
                  len = data.length;
                }

                if(len > 0){
                  // Read data and create <option >
                  for(var i=0; i<len; i++){

                    var id = data[i].id;
                    var name = data[i].nama_produk;

                    var option = "<option value='"+id+"'>"+name+"</option>"; 

                    $("#id_produk").append(option); 
                  } 
                }             
                   
              },
              error: function (data) {
                 
              }
        })     
     //pilih kategori
     $('#id_kategori').change(function(){  
      var idx = $(this).val(); 
      //kalau pilih Reagen
      $('#id_batch').find('option').not(':first').remove();
      if(idx==7){
          $('#div-batch').removeClass('hidden');             
      }else{
          $('#div-batch').removeClass('hidden').addClass('hidden');
      }
       // Empty the dropdown
       $('#id_produk').find('option').not(':first').remove();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({              
              type: "post",
              url: "/product/get/by/category",
              data: {
                  idx: idx
              },
              dataType: "json",
              success: function (data) {                
                var len = 0;
                if(data != null){
                  len = data.length;
                }

                if(len > 0){
                  // Read data and create <option >
                  for(var i=0; i<len; i++){

                    var id = data[i].id;
                    var name = data[i].nama_produk;

                    var option = "<option value='"+id+"'>"+name+"</option>"; 

                    $("#id_produk").append(option); 
                  } 
                }             
                   
              },
              error: function (data) {
                 
              }
        })        
     });    
  });  
  </script>

@include('templates.modal')
</body>
</html>
