@extends('layouts.master')

@section('title', 'Tjahaja Baru | News')

@section('meta_og')
	<meta property="og:title" content="Tjahaja Baru | News">
	<meta property="og:description" content="Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru. Official Website for Yamaha motor West Sumatra, Indonesia.">
	<meta property="og:type" content="website">
@endsection

@section('main_class', 'article')

@section('additional_css')
	<link rel="stylesheet" href="{{ asset('css/article.css') }}" />
@endsection

@section('content')
    <div class="article-container">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<ol class="breadcrumb">
						<li>
							<a href="{{ url('/') }}">Home</a>
						</li>
						<li>News</li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<span class="page-title">News</span>
				</div>
			</div>
			<hr>
		</div>
		<div class="container article-list " id="post">
			{{-- <div class="article-wrapper">
				<div class="article-wrapper-left">
					<img class="article-img" src="{{ url('/images/Foto untuk Koran.jpg')}}" alt="">
				</div>
				<div class="article-wrapper-right">
					<span class="date-time">
						<i class="fa fa-calendar"> 05 Mei 2023</i>
						<i class="fa fa-clock-o"> 09:16</i>
					</span>
					<br>
					<span class="hashtag">#YamahaSumbar #YamahaIndonesia</span>
					<br>
					<a href="">
						<h1 class="article-title">Jakarta - Yamaha kembali menghadirkan tampilan Baru untuk Yamaha Gear 125 pada awal bulan Mei</h1>
					</a>
					<p class="article-content">Jakarta - Yamaha kembali menghadirkan tampilan baru untuk Yamaha Gear 125 pada awal bulan Mei 2023. Warna baru Yamaha Gear 125 hadir dengan kombinasi warna dan grafis yang elegant, artistic dan active yang Pasti Keren dan tampil beda disetiap kesempatan serta mampu meningkatkan kepercayaan diri dari penggunanya.“Kebutuhan berkendara serta karakter konsumen yang beragam, membuat kami untuk selalu menghadirkan kendaraan yang sesuai dengan keinginan konsumen. Oleh karena itu kami menghadirkan 7 warna baru pada Yamaha Gear 125 yang mampu meningkatkan kepercayaan diri dari penggunanya untuk</p>
					<span class="info-count">
						<i class="fa fa-eye"> 100</i>
					</span>
				</div>
			</div> --}}
			@foreach ($data as $item)
			<div class="article-wrapper">
				<div class="article-wrapper-left">
					<img class="article-img" src="{{ url($item->image_thumbnail) }}" alt="">
				</div>
				<div class="article-wrapper-right">
					<div class="date-time">
						{{-- <i class="fa fa-calendar"> <?php print $item->created_at->isoFormat('D MMMM Y') ?></i>
						<i class="fa fa-clock-o"> <?php print date('H:i', strtotime($item->created_at)); ?></i> --}}
						<div class="calendar-icon" style="float: left; margin-right: 18px;"><img src="{{ url('/images/icons/calendar.png') }}" alt="" style="width: 15px; margin-right: 5px;"><span style="font-weight: bold; font-size: 12px;"><?php print $item->created_at->isoFormat('D MMMM Y') ?></span></div>
						<div class="clock-icon" style="margin-right: 18px;"><img src="{{ url('/images/icons/clock.png') }}" alt="" style="width: 15px; margin-right: 5px;"><span style="font-weight: bold; font-size: 12px;"><?php print date('H:i', strtotime($item->created_at)); ?></span></div>
					</div>
					<span class="hashtag">{!! $item->header_caption !!}</span>
					<a href="{{ url("news/$item->uri") }}">
						<h1 class="article-title">{{ $item->title }}</h1>
					</a>
					<div class="article-content">{!! ($item->content) !!}</div>
					<div class="info-count">
						{{-- <i class="fa fa-eye"> 0</i> --}}
						{{-- <i class="fa fa-share-alt"> 0</i> --}}
						<div class="eye-icon" style="float: left; margin-right: 18px;"><img src="{{ url('/images/icons/eye.png') }}" alt="" style="width: 15px; margin-right: 5px;"><span style="font-weight: bold; font-size: 12px;">00</span></div>
						<div class="share-icon"><img src="{{ url('/images/icons/share.png') }}" alt="" style="width: 13px; margin-right: 5px;"><span style="font-weight: bold; font-size:12px;">00</span></div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		<div class="load-more container">
			<button type="button" class="btn btn-block" data-paginate="2" id="load_more_button"><i class="fa fa-newspaper-o"></i>  MORE</button>
			{{-- <p class="invisible">No more posts...</p> --}}
		</div>
	</div>
@endsection

@section('additional_script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
<script type="text/javascript">
	var paginate = 1;
	// loadMoreData(paginate);
	$('#load_more_button').click(function() {
		var page = $(this).data('paginate');
		loadMoreData(page);
		$(this).data('paginate', page+1);
	});
	// run function when user click load more button
	function loadMoreData(paginate) {
		$.ajax({
			url: '?page=' + paginate,
			type: 'get',
			datatype: 'html',
			beforeSend: function() {
				$('#load_more_button').text('Loading...');
			}
		})
		.done(function(data) {
			if(data.length == 0) {
				// $('.invisible').removeClass('invisible');
				$('#load_more_button').hide();
				return;
				} else {
					$('#load_more_button').html('<i class="fa fa-newspaper-o"></i>  MORE')
					$('#post').append(data);
				}
		})
		.fail(function(jqXHR, ajaxOptions, thrownError) {
			alert('Something went wrong.');
		});
	}
</script>
@endsection