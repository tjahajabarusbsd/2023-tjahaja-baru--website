@php
    // Kategori produk: dipakai mega menu (desktop) dan dropdown (mobile)
    $categories = [
        'maxi' => 'MAXi',
        'classy' => 'Classy',
        'matic' => 'Matic',
        'sport' => 'Sport',
        'moped' => 'Moped',
    ];

    // Urutan menu. 'match' = pola request()->is() untuk status aktif.
    $menu = [
        ['label' => 'Home', 'url' => '/', 'match' => '/'],
        ['label' => 'About Us', 'url' => '/profile', 'match' => 'profile*'],
        ['type' => 'products'],
        ['label' => 'Parts', 'url' => 'https://www.yamaha-motor.co.id/part-accessories/ygp/', 'external' => true],
        // ['label' => 'Promo', 'url' => '/promo', 'match' => 'promo*'],
        ['label' => 'Contact Us', 'url' => '/contact', 'match' => 'contact*'],
        ['label' => 'Locations', 'url' => '/dealers', 'match' => 'dealers*'],
        ['label' => 'News', 'url' => '/news', 'match' => 'news*'],
        ['label' => 'Find Your Yamaha', 'url' => '/kuis', 'match' => 'kuis*'],
    ];

    // /product/{uri}, /products/category/{slug}, /compare_product
    $productsActive = request()->is('product*', 'compare_product*');
    $currentCategory = request()->is('products/category/*') ? request()->segment(3) : null;
@endphp

<header>
    <nav class="navbar navbar-expand-lg navbar-dark" aria-label="Menu utama">
        <div class="container">
            <a class="main-logo" href="/">
                <img src="{{ url('/images/logo.png') }}" title="Kembali ke Beranda" class="logo-image" alt="TJAHAJA BARU"
                    width="95" height="45">
            </a>
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Buka menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    @foreach ($menu as $item)
                        @if (($item['type'] ?? 'link') === 'products')
                            {{-- Desktop: mega menu saat hover / fokus --}}
                            <li class="nav-item subnav d-none d-lg-block">
                                <a @class(['nav-link', 'active' => $productsActive]) href="#products"
                                    @if ($productsActive) aria-current="true" @endif>products</a>
                                <div class="container-fluid icon-container">
                                    <div class="row icon-row">
                                        @foreach ($categories as $slug => $label)
                                            <div @class(['product-icon-box', 'active' => $slug === $currentCategory])>
                                                <a href="/products/category/{{ $slug }}">
                                                    <img src="{{ url("images/products/icons/{$slug}_i.png") }}"
                                                        alt="" class="icon" loading="lazy">
                                                    <p class="text">{{ $label }}</p>
                                                </a>
                                            </div>
                                        @endforeach
                                        <div class="product-icon-box compare-menu">
                                            <a href="/compare_product">Compare Product</a>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            {{-- Mobile: dropdown (toggle sengaja tanpa .active, lihat catatan) --}}
                            <li class="nav-item dropdown d-lg-none">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">products</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @foreach ($categories as $slug => $label)
                                        <li>
                                            <a @class(['dropdown-item', 'active' => $slug === $currentCategory])
                                                href="/products/category/{{ $slug }}"
                                                @if ($slug === $currentCategory) aria-current="page" @endif>{{ $label }}</a>
                                        </li>
                                    @endforeach
                                    <li><a class="dropdown-item" href="/compare_product">Compare Product</a></li>
                                </ul>
                            </li>
                        @else
                            @php
                                $active = !empty($item['match']) && request()->is($item['match']);
                            @endphp
                            <li class="nav-item">
                                <a @class(['nav-link', 'active' => $active]) href="{{ $item['url'] }}"
                                    @if ($active) aria-current="page" @endif
                                    @if (!empty($item['external'])) target="_blank" rel="noopener" @endif>{{ $item['label'] }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>
</header>
