<!DOCTYPE html>
<html lang="en">
<head>
  @if(env('APP_ENV') == 'production')
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-4GT7FGQNZG"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-4GT7FGQNZG');
    </script>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-K363G3WM');</script>
    <!-- End Google Tag Manager -->
  @endif
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="title" content="@yield('title')" />
  <meta name="keywords" content="yamaha, sumbar, sumatera barat, padang, tjahaja baru, mio, mio j, soul gt, vixion, byson, minangkabau, scorpio, pameran yamaha, servis yamaha, motor yamaha">
  <meta name="description" content="Website Resmi Yamaha Sumatera Barat: CV. Tjahaja Baru. Official Website for Yamaha motor West Sumatra, Indonesia.">
  <meta name="theme-color" content="#1645ca">
  <meta name="mobile-web-app-capable" content="yes" />
  <meta name="mobile-web-app-capable" content="black" />
  @yield('meta_og')
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>
  <link rel="shortcut icon" href="{{ url('/images/icons/favicon.ico') }}" type="image/x-icon" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  @include('partials/page_css')
  @yield('additional_css')
  {!! RecaptchaV3::initJs() !!}
  <!-- Meta Pixel Code -->
  {{-- <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '2019554698410645');
    fbq('track', 'PageView');
  </script>
  <noscript>
    <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=2019554698410645&ev=PageView&noscript=1"/>
  </noscript> --}}
  <!-- End Meta Pixel Code -->
</head>
<body>
  @if(env('APP_ENV') == 'production')
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K363G3WM"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
  @endif
  @include('partials/navbar')
  <div id="main-wrapper" class="@yield('main_class')">
    @yield('content')
    @php
    use Illuminate\Support\Str;
    @endphp
    @unless(request()->is('consultation') ||  Str::is('product*', request()->path()))
      <a class="btn-wa" href="https://api.whatsapp.com/send?phone=62811805898&amp;text=Halo admin, saya ingin menanyakan" target="_blank" rel="noopener noreferrer">
        <section class="link-wa">
        <div class="konten-gambar">
            <img src="{{ url('/images/icons/wa.png')}}" alt="Whatsapp logo">
        </div>
        <div class="konten-wa">
            <h3>Chat WhatsApp</h3>
        </div>
        </section>
      </a>
    @endunless
  </div>
</body>
@include('partials/footer')
@include('partials/page_script')
@yield('additional_script')
</html>