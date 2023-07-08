@extends('layouts.master')

@section('title', 'Product | Tjahaja Baru')

@section('meta_og')
	<meta property="og:title" content="Product | Tjahaja Baru">
	<meta property="og:description" content="Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru. Official Website for Yamaha motor West Sumatra, Indonesia.">
	<meta property="og:type" content="website">
@endsection

@section('main_class', 'product')

@section('additional_css')
	<link rel="stylesheet" href="{{ asset('css/product.css') }}" />
@endsection

@section('content')
	<section class="first-section">
		<div class="container-fluid icon-container">
			<div class="row icon-row pc">
				<div class="product-icon-box">
					<a href="/products/category/maxi">
						<img src="{{ url('images/products/icons/maxi_i.png')}}" alt="" class="icon">
						<p class="text">MAXi</p>
					</a>
				</div>
				<div class="product-icon-box">
					<a href="/products/category/classy">
						<img src="{{ url('images/products/icons/classy_i.png')}}" alt="" class="icon">
						<p class="text">Classy</p>
					</a>
				</div>
				<div class="product-icon-box">
					<a href="/products/category/matic">
						<img src="{{ url('images/products/icons/matic_i.png')}}" alt="" class="icon">
						<p class="text">Matic</p>
					</a>
				</div>
				<div class="product-icon-box">
					<a href="/products/category/sport">
						<img src="{{ url('images/products/icons/sport_i.png')}}" alt="" class="icon">
						<p class="text">bLU cRU</p>
					</a>
				</div>
				<div class="product-icon-box">
					<a href="/products/category/moped">
						<img src="{{ url('images/products/icons/moped_i.png')}}" alt="" class="icon">
						<p class="text">Moped</p>
					</a>
				</div>
			</div>
			<div class="row icon-row mobile">
				<div class="product-icon-box">
					<a href="/products/category/maxi">
						<img src="{{ url('images/products/icons/maxi_i.png')}}" alt="" class="icon">
						<p class="text">MAXi</p>
					</a>
				</div>
				<div class="product-icon-box">
					<a href="/products/category/classy">
						<img src="{{ url('images/products/icons/classy_i.png')}}" alt="" class="icon">
						<p class="text">Classy</p>
					</a>
				</div>
				<div class="product-icon-box">
					<a href="/products/category/matic">
						<img src="{{ url('images/products/icons/matic_i.png')}}" alt="" class="icon">
						<p class="text">Matic</p>
					</a>
				</div>
				<div class="product-icon-box">
					<a href="/products/category/sport">
						<img src="{{ url('images/products/icons/sport_i.png')}}" alt="" class="icon">
						<p class="text">Sport</p>
					</a>
				</div>
				<div class="product-icon-box">
					<a href="/products/category/moped">
						<img src="{{ url('images/products/icons/moped_i.png')}}" alt="" class="icon">
						<p class="text">Moped</p>
					</a>
				</div>
			</div>
		</div>
	</section>

	<section class="second-section">
		<div class="container-fluid">
			<div class="row product-logo-container">
				@if (Request::is('products') || Request::is('products/category/maxi'))
					<img src="{{ url('images/products/logos/maxi.png') }}" alt="Maxi Product" class="logo">
				@elseif (Request::is('products/category/classy'))
					<img src="{{ url('images/products/logos/classy.png') }}" alt="Classy Product" class="logo">
				@elseif (Request::is('products/category/matic'))
					<img src="{{ url('images/products/logos/gen_125.png') }}" alt="Matic Product" class="logo">
				@elseif (Request::is('products/category/sport'))
					<img src="{{ url('images/products/logos/bLUcRU.png') }}" alt="Sport Product" class="logo">
				@elseif (Request::is('products/category/moped'))
					<p class="logo">MOPED</p>
				@endif
				
			</div>
			<div class="grid-container">
				@if (Request::is('products'))
					@foreach ($maxis as $maxi)
						<div class="grid-content">
							<a class="product-link" href="/product/{{ $maxi->uri }}">
								<div class="box-img">
									<img src="{{ url($maxi->image) }}" alt="" class="product-unit-image">
								</div>
								<div class="box-text">
									<p class="caption">OTR Sumatera Barat, Mulai Dari</p>
									<p class="product-price">{{ $maxi->price }}</p>
									<img class="tombol-biru" src="{{ url('/images/tombol1.png')}}" alt="">
								</div>
							</a>
						</div>
					@endforeach
				@else
					@foreach ($groups as $group)
						<div class="grid-content">
							<a class="product-link" href="/product/{{ $group->uri }}">
								<div class="box-img">
									<img src="{{ url($group->image) }}" alt="" class="product-unit-image">
								</div>
								<div class="box-text">
									<p class="caption">OTR Sumatera Barat, Mulai Dari</p>
									<p class="product-price">{{ $group->price }}</p>
									<img class="tombol-biru" src="{{ url('/images/tombol1.png')}}" alt="">
								</div>
							</a>
						</div>
					@endforeach
				@endif
			</div>
		</div>
	</section>
@endsection

@section('additional_script')
<script src="{{ asset('js/product.js') }}"></script>
<script>
	let date = Date.now();
	gtag('event', 'visit_time', {
		'time': date,
	});
</script>
@endsection