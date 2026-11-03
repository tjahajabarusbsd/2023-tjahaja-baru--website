@extends('layouts.master')

@section('title', 'Dealers | Tjahaja Baru')

@section('meta_og')
    <meta property="og:title" content="Dealers | Tjahaja Baru">
    <meta property="og:description"
        content="Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru. Official Website for Yamaha motor West Sumatra, Indonesia.">
    <meta property="og:type" content="website">
@endsection

@section('main_class', 'dealers')

@section('additional_css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ asset('css/dealers.css') }}?v={{ filemtime(public_path('css/dealers.css')) }}" />
@endsection

@section('content')
    <div class="container-fluid">
        <div class="dealer-header">
            <h1 class="title">Cari Dealer</h1>
            <p>Temukan dealer Yamaha Tjahaja Baru terdekat di peta interaktif di bawah ini.
                Klik penanda di peta, atau pilih dealer dari daftar untuk melihat lokasinya.</p>
        </div>

        <div class="dealer-layout">
            <div class="map-container">
                <div id="dealer-map" role="region" aria-label="Peta lokasi dealer Yamaha Tjahaja Baru"></div>
            </div>

            <aside class="dealer-sidebar" aria-label="Daftar dealer">
                <div class="dealer-search">
                    <input type="search" id="dealerSearch" placeholder="Cari nama dealer, kecamatan, atau kota..."
                        aria-label="Cari dealer" autocomplete="off">
                </div>

                <div class="dealer-list" id="dealerList">
                    @forelse ($dealers as $dealer)
                        <article class="dealer-card" data-id="{{ $dealer->id }}"
                            data-search="{{ strtolower($dealer->name_dealer . ' ' . $dealer->kecamatan . ' ' . $dealer->kota . ' ' . $dealer->address) }}">
                            <div class="card-body">
                                <h2 class="card-title">{{ $dealer->name_dealer }}</h2>

                                @if ($dealer->kecamatan || $dealer->kota)
                                    <p class="area">
                                        {{ collect([$dealer->kecamatan, $dealer->kota])->filter()->implode(', ') }}</p>
                                @endif

                                @if ($dealer->address)
                                    <p class="address">{{ $dealer->address }}</p>
                                @endif

                                <div class="card-actions">
                                    @if ($dealer->nohp)
                                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $dealer->nohp) }}"
                                            class="btn btn-primary btn-tlpn">
                                            <img src="{{ url('/images/icons/phone.png') }}" alt="" class="phone">
                                            {{ $dealer->nohp }}
                                        </a>
                                    @endif

                                    @if (is_numeric($dealer->latitude) && is_numeric($dealer->longitude))
                                        <a href="https://www.google.com/maps?q={{ $dealer->latitude }},{{ $dealer->longitude }}"
                                            target="_blank" rel="noopener" class="link"
                                            aria-label="Petunjuk arah ke {{ $dealer->name_dealer }}">
                                            <img src="{{ url('images/icons/location.png') }}" alt=""
                                                class="location-icon">
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @empty
                        <p class="dealer-empty">Data dealer belum tersedia.</p>
                    @endforelse

                    <p class="dealer-empty" id="dealerNoResult" hidden>Dealer tidak ditemukan.</p>
                </div>
            </aside>
        </div>

        <div class="product-list">
            <h2>Rekomendasi Produk<br />Untuk Anda</h2>
            <div class="grid-container">
                @foreach ($products as $product)
                    <div class="grid-content">
                        <a class="product-link" href="/product/{{ $product->uri }}">
                            <div class="box-img">
                                <img src="{{ url($product->image) }}" alt="{{ $product->name }}"
                                    class="product-unit-image" loading="lazy">
                            </div>
                            <div class="box-text">
                                <p class="caption">OTR Sumatera Barat, Mulai Dari</p>
                                <p class="product-price">{{ $product->price }}</p>
                                <img class="tombol-biru" src="{{ url('/images/tombol1.png') }}" alt="">
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Structured data untuk SEO --}}
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@graph' => $dealers->map(function ($d) {
                $item = [
                    '@type' => 'AutoDealer',
                    'name' => $d->name_dealer,
                    'telephone' => $d->nohp,
                    'address' => [
                        '@type' => 'PostalAddress',
                        'streetAddress' => $d->address,
                        'addressLocality' => $d->kota,
                        'addressRegion' => 'Sumatera Barat',
                        'addressCountry' => 'ID',
                    ],
                ];

                if (is_numeric($d->latitude) && is_numeric($d->longitude)) {
                    $item['geo'] = [
                        '@type' => 'GeoCoordinates',
                        'latitude' => (float) $d->latitude,
                        'longitude' => (float) $d->longitude,
                    ];
                }

                return $item;
            })->values(),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}
    </script>
@endsection

@section('additional_script')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        (function() {
            const dealers = @json($mapDealers);

            // Pusat awal: Padang. Kalau ada marker, peta otomatis menyesuaikan.
            const map = L.map('dealer-map', {
                scrollWheelZoom: false
            }).setView([-0.9492, 100.3543], 10);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Zoom dengan scroll mouse baru aktif setelah peta diklik (mencegah "terjebak" scroll)
            map.on('focus', () => map.scrollWheelZoom.enable());
            map.on('blur', () => map.scrollWheelZoom.disable());

            // Escape teks sebelum dimasukkan ke popup (cegah XSS)
            const esc = (str) => {
                const div = document.createElement('div');
                div.textContent = str ?? '';
                return div.innerHTML;
            };

            const markers = {};
            const bounds = [];

            dealers.forEach((d) => {
                const phoneHref = (d.phone || '').replace(/[^0-9+]/g, '');
                const popup = `
                    <strong>${esc(d.name)}</strong><br>
                    ${d.address ? esc(d.address) + '<br>' : ''}
                    ${d.phone ? `<a href="tel:${phoneHref}">${esc(d.phone)}</a><br>` : ''}
                    <a href="https://www.google.com/maps?q=${d.lat},${d.lng}" target="_blank" rel="noopener">Petunjuk arah</a>
                `;

                markers[d.id] = L.marker([d.lat, d.lng]).addTo(map).bindPopup(popup);
                bounds.push([d.lat, d.lng]);
            });

            if (bounds.length > 1) {
                map.fitBounds(bounds, {
                    padding: [30, 30]
                });
            } else if (bounds.length === 1) {
                map.setView(bounds[0], 15);
            }

            // Klik kartu dealer -> peta terbang ke marker
            const cards = document.querySelectorAll('.dealer-card');

            cards.forEach((card) => {
                card.addEventListener('click', (e) => {
                    if (e.target.closest('a')) return; // biarkan link telepon/arah bekerja normal

                    const marker = markers[card.dataset.id];
                    if (!marker) return;

                    cards.forEach((c) => c.classList.remove('active'));
                    card.classList.add('active');

                    map.flyTo(marker.getLatLng(), 16);
                    marker.openPopup();
                    document.getElementById('dealer-map').scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                });
            });

            // Pencarian di sisi klien (semua dealer sudah ada di halaman)
            const searchInput = document.getElementById('dealerSearch');
            const noResult = document.getElementById('dealerNoResult');

            searchInput.addEventListener('input', () => {
                const keyword = searchInput.value.trim().toLowerCase();
                let visible = 0;

                cards.forEach((card) => {
                    const match = card.dataset.search.includes(keyword);
                    card.hidden = !match;
                    if (match) visible++;
                });

                noResult.hidden = visible !== 0;
            });
        })();
    </script>
@endsection
