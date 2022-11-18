@if (session('pesan'))
<div class="alert alert-info" role="alert">
    <b>Status</b> : {{ session('pesan') }}
</div>
@endif
@if (session('error'))
<div class="alert alert-danger" role="alert">
    <b>Status</b> : {{ session('error') }}
</div>
@endif