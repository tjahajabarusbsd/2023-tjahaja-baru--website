<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Riwayat Servis</title>
</head>
<body>
    <center>
		<h4>Riwayat Servis</h4>
	</center>

    <table class='table table-bordered'>
		<thead>
			<tr>
				<th>Tanggal</th>
                <th>Invoice</th>
                <th>Kategori Servis</th>
                <th>Total Biaya</th>
            </tr>
		</thead>
		<tbody>
			@foreach($riwayat as $item)
			<tr>
				<td>{{ date("Y-m-d H:i", strtotime($item['event_walkin'])) }}</td>
				<td>{{ $item['invoice'] }}</td>
                <td>{{ $item['svc_cat'] }}</td>
                <td>Rp. {{ number_format($item['cost_total'],0,",",".") }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>