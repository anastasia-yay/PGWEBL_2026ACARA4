@extends('layouts.template')
@section('content')
<div class="container mt-3">
<div class="card">
<div class="card-header">
<h3>Tabel Data</h3>
</div>
<div class="card-body">

<table class="table table-bordered table-striped">
<thead>

<tr>
<td>ID</td>
<td>Nama</td>
<td>Alamat</td>
</tr>

</thead>
<tbody>

<tr>
<td>1</td>
<td>John Doe</td>
<td>Jl. Merdeka No.123</td>
</tr>

<tr>
<td>2</td>
<td>Jane Smith</td>
<td>Jl. Pahlawan No.45</td>
</tr>

<tr>
<td>3</td>
<td>Peter Jones</td>
<td>Jl. Sudirman No.789</td>
</tr>

</tbody>

</table>

</div>
</div>
</div>

@endsection
