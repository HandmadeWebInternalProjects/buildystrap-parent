@extends('layouts.blank')

@push('bs-head')
  <style>
  #wpadminbar {
    display: none;
  }

  #page {
    overflow: unset !important;
  }

  html {
    margin-top: 0 !important;
    padding-top: 0 !important;
  }
  </style>
@endpush

@php
use Buildystrap\Builder;

// Get the data param from URL
$id = request()->get('id');
$post = get_post($id);
$content = Builder::renderFromContent($post->post_content)->render();
@endphp

@section('content')
@if($content)
  <div class="module-render-preview" style="transform: scale(0.5) translate(-50%, -50%);">
    {!! $content !!}
  </div>
@endif
@endsection
