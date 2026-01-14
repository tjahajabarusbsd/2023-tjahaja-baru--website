<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $promo->name }}</title>

    {{-- Basic SEO --}}
    <meta name="description" content="{{ Str::limit(strip_tags($promo->description), 150) }}">

    {{-- Minimal styling (no dependency ke layout utama) --}}
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #ffffff;
            color: #1f2937;
            line-height: 1.6;
        }

        .container {
            max-width: 720px;
            margin: 0 auto;
            padding: 20px;
        }

        .banner img {
            width: 100%;
            border-radius: 12px;
            max-height: 360px;
            object-fit: cover;
        }

        h1 {
            font-size: 22px;
            margin: 20px 0 8px;
        }

        .period {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 24px;
        }

        .content {
            font-size: 15px;
        }

        .terms {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .terms h3 {
            font-size: 18px;
            margin-bottom: 12px;
        }

        footer {
            margin-top: 60px;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
        }
    </style>
</head>

<body>

<div class="container">

    {{-- Banner --}}
    <div class="banner">
        <img
            src="{{ asset($promo->image) }}"
            alt="{{ $promo->name }}"
        >
    </div>

    {{-- Title --}}
    <h1>{{ $promo->name }}</h1>

    {{-- Periode --}}
    @if($promo->start_date || $promo->end_date)
        <div class="period">
            @if($promo->start_date)
                {{ \Carbon\Carbon::parse($promo->start_date)->format('d M Y') }}
            @endif
            –
            @if($promo->end_date)
                {{ \Carbon\Carbon::parse($promo->end_date)->format('d M Y') }}
            @endif
        </div>
    @endif

    {{-- Description --}}
    @if($promo->description)
        <div class="content">
            {!! $promo->description !!}
        </div>
    @endif

    {{-- Terms & Conditions --}}
    @if($promo->terms_conditions)
        <div class="terms">
            <h3>Syarat & Ketentuan</h3>
            {!! $promo->terms_conditions !!}
        </div>
    @endif

</div>

<footer>
    © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
</footer>

</body>
</html>
