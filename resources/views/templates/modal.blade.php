<script>
	$('#delete-sell').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget)
      var del_id_sell = button.data('delsell')
      var modal  = $(this)      
      modal.find('.modal-body #del_id_sell').val(del_id_sell);
  	})

	$('#delete-produk').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget)
      var del_id_produk = button.data('delproduk')
      var modal  = $(this)      
      modal.find('.modal-body #del_id_produk').val(del_id_produk);
  	})

	$('#delete-purchase').on('show.bs.modal', function(event){

		var button = $(event.relatedTarget)

		var del_id = button.data('purchase')		
		var modal  = $(this)		
		modal.find('.modal-body #del_id_purchase').val(del_id);
	})
</script>