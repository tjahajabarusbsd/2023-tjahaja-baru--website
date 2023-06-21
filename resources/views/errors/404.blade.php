@extends('layouts.master')

@section('title', 'Halaman Tidak Ditemukan | Tjahaja Baru')
@section('main_class', 'error')

@section('additional_css')
	<link rel="stylesheet" href="{{ asset('css/error.css') }}" />
@endsection

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12 text-center">
      <div class="error_number">
        <small>ERROR</small><br>
        404
        <hr>
      </div>
      <div class="error_title text-muted">
        Halaman Tidak Ditemukan
      </div>
      <div class="error_description text-muted">
        <small>
          Kembali ke <a href="{{ url('/') }}" class="button">Home</a>
      </small>
      </div>
    </div>
  </div>
</div>
@endsection

{{-- 
@php
  $error_number = 404;
@endphp

@section('title')
  Page not found.
@endsection

@section('description')
  @php
    $default_error_message = "Please <a href='javascript:history.back()''>go back</a> or return to <a href='".url('')."'>our homepage</a>.";
  @endphp
  {!! isset($exception)? ($exception->getMessage()?e($exception->getMessage()):$default_error_message): $default_error_message !!}
@endsection --}}
