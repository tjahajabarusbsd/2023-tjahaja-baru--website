<header>
	<nav class="navbar navbar-expand-lg navbar-dark static-top">
		<div class="container">
			<a class="main-logo" href="/">
				<img src="{{ url('/images/logo.png')}}" title="Kembali ke Beranda" class="logo-image" alt="TJAHAJA BARU">
			</a>
			<button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ms-auto">
					<li class="nav-item">
						<a class="nav-link" href="/">home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/profile">about us</a>
					</li>
					<li class="nav-item subnav">
						<a class="nav-link" href="#products">products</a>
						<div class="container-fluid icon-container">
							<div class="row icon-row">
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
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						  products
						</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
						  <li><a class="dropdown-item" href="/products/category/maxi">Maxi</a></li>
						  <li><a class="dropdown-item" href="/products/category/classy">Classy</a></li>
						  <li><a class="dropdown-item" href="/products/category/matic">Matic</a></li>
						  <li><a class="dropdown-item" href="/products/category/sport">Sport</a></li>
						  <li><a class="dropdown-item" href="/products/category/moped">Moped</a></li>
						</ul>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/consultation">consultation</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/contact">contact us</a>
					</li>
					{{-- <li class="nav-item">
						<a class="nav-link" href="/dealers">dealers</a>
					</li> --}}
					<li class="nav-item">
						<a class="nav-link" href="/compare_product">compare</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/kuis">Quiz</a>
					</li>
					@auth
						<li class="nav-item">
							<a class="nav-link" href="/myprofile">My Profile</a>
						</li>
						<form action="{{url('logout')}}" method="GET" class="logout-form"> 
							<button type="submit">Logout</button>
						</form>
					@else
						<li class="nav-item nav-login">
							<a class="nav-link link-login" href="/login">Login</a>
						</li>
					@endauth
				</ul>
			</div>
		</div>
	</nav>
</header>