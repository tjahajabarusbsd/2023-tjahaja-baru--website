<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Riwayat Servis</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		
		.page-break {
			page-break-after: always;
		}
		
	</style>
    <center>
		<h1>Riwayat Servis</h1>
	</center>

	@foreach($riwayat as $item)
	<div class="page-break">
		<dl>
			<dt>Tempat Servis</dt>
			<dd>{{ $item['kode'] }}</dd>
			<dt>Kategori Servis</dt>
			<dd>{{ $item['svc_cat'] }}</dd>
			<dt>Mekanik</dt>
			<dd>{{ $item['mechanic_name'] }}</dd>
			<dt>Unit</dt>
			<dd>{{ $item['prod_nm'] }}</dd>
		</dl>

		<h5>Paket Servis</h5>
		<table class='table table-bordered'>
			<thead>
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Biaya</th>
				</tr>
			</thead>
			<tbody>
				@php $i=1 @endphp
				@php 
					$svc_pac = json_decode($item['svc_pac']);
					$svc_cost = json_decode($item['svc_cost']);
				@endphp
				@foreach($svc_pac as $index => $paket_servis)
				<tr>
					<td>{{ $i++ }}</td>
					<td>{{ $paket_servis }}</td>
					<td>Rp. {{ number_format($svc_cost[$index], 0, ",", ".") }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>

		<h5>Part Terpakai</h5>
		<table class='table table-bordered'>
			<thead>
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Jumlah</th>
					<th>Biaya</th>
				</tr>
			</thead>
			<tbody>
				@php $i=1 @endphp
				@php 
					$part_name = $item['part_name'];
					$part_qty = json_decode($item['part_qty']);
					$part_cost = json_decode($item['part_cost']);
				@endphp
				@foreach($part_qty as $index => $part_terpakai)
				<tr>
					<td>{{ $i++ }}</td>
					<td>{{ $part_name[$index] }}</td>
					<td>{{ $part_terpakai }}</td>
					<td>Rp. {{ number_format($part_cost[$index], 0, ",", ".") }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>

		<dl>
			<dt>Total Biaya Servis</dt>
			<dd>Rp. {{ number_format($item['cost_total'],0,",",".") }}</dd>
		</dl>
	</div>
	@endforeach
</body>
</html>