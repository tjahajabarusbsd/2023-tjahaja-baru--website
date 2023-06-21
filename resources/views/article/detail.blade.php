@extends('layouts.custom')

@section('title', $title . ' | Tjahaja Baru')

@section('meta_og')
<?php
    $string = \Illuminate\Support\Str::limit($content, 160);
    $string = html_entity_decode($string);
    $string = strip_tags($string);
    // dd($string);
?>
	<meta property="og:title" content="{{ $title }} | Tjahaja Baru">
	<meta property="og:description" content="{{ $string }}">
    <meta property="og:type" content="website">
	<meta property="og:image" content="{{ url($image_thumbnail) }}">
	<meta property="og:image:width" content="1000" />
	<meta property="og:image:height" content="667" />
	<meta property="og:url" content="{{ Request::url() }}">
@endsection

@section('main_class', 'article-detail')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}" />
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li>
                        <a href="{{ url('/news') }}">News</a>
                    </li>
                    <li>{{ $title }}</li>
                </ol>
            </div>
        </div>
        <hr>
    </div>
    <div class="container detail-content">
        <div class="title">{{ $title }}</div>
        <div class="date-time">
            <div class="calendar-icon" style="float: left; margin-right: 18px;"><img src="{{ url('/images/icons/calendar.png') }}" alt="" style="width: 15px; margin-right: 5px;"><span style="font-weight: bold; font-size: 12px;"><?php print $created_at->isoFormat('D MMMM Y') ?></span></div>
            <div class="clock-icon" style="margin-right: 18px;"><img src="{{ url('/images/icons/clock.png') }}" alt="" style="width: 15px; margin-right: 5px;"><span style="font-weight: bold; font-size: 12px;"><?php print date('H:i', strtotime($created_at)); ?></span></div>
        </div>
        <div class="image"><img src="{{ url($image_thumbnail) }}" class="thumbnail"></div>
        <div class="body-content">{!! $content !!}</div>
        <div class="share-container">
            <div class="social-media">
                <a href="/" target="_blank" title="Facebook"><img src="{{ url('images/icons/fb1.png') }}" alt="" class="icon share-fb"></a>
            </div>
        </div>
    </div>
@endsection