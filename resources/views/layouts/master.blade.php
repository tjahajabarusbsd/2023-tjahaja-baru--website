<!DOCTYPE html>
<html lang="id">

<head>
    @production
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-4GT7FGQNZG"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'G-4GT7FGQNZG');
        </script>
        <!-- Google Tag Manager -->
        <script>
            (function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })
            (window, document, 'script', 'dataLayer', 'GTM-K363G3WM');
        </script>
        <!-- End Google Tag Manager -->
    @endproduction
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords"
        content="yamaha, sumbar, sumatera barat, padang, tjahaja baru, mio, mio j, soul gt, vixion, byson, minangkabau, scorpio, pameran yamaha, servis yamaha, motor yamaha">
    <meta name="description" content="@yield('meta_description', 'Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru.')">
    <link rel="canonical" href="{{ url()->current() }}" />
    <meta name="theme-color" content="#1645ca">
    @yield('meta_og')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ url('/images/icons/favicon.ico') }}" type="image/x-icon" />
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://www.googletagmanager.com">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @include('partials/page_css')
    @yield('additional_css')
    @stack('recaptcha')
</head>

<body>
    @production
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K363G3WM" height="0" width="0"
                style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
    @endproduction
    @include('partials/navbar')
    <div id="main-wrapper" class="@yield('main_class')">
        @yield('content')
        @unless (request()->is('contact', 'product*') || request()->hasCookie('sales') || request()->has('sales'))
            <a class="btn-wa" href="https://wa.me/62811805898?text={{ urlencode('Halo admin, saya ingin menanyakan') }}"
                target="_blank" rel="noopener noreferrer">
                <section class="link-wa">
                    <div class="konten-gambar">
                        <img src="{{ url('/images/icons/wa.png') }}" alt="Whatsapp logo">
                    </div>
                    <div class="konten-wa">
                        <span class="h3">Chat WhatsApp</span>
                    </div>
                </section>
            </a>
        @endunless
    </div>
    @include('partials/footer')
    @include('partials/page_script')
    @yield('additional_script')
</body>

</html>
