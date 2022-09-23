@php
  $direction = $module->get('image_placement') ?? 'flex-column';
  $card_classes = collect(['card', 'flex-wrap', $direction])->filter()->implode(' ');
@endphp

@extends('builder::module-base', ['class' => $card_classes])


@section('field_content')
    <div class="">
        @if($module->has('image'))
          {!! wp_get_attachment_image(collect($module->get('image')->value())->first()['id'], 'medium', '', ['class' => 'card-img object-cover']) !!}
        @endif
    </div>

    <div class="card-body">
      @if($module->has('title'))
        {!! $module->get('title')->titleClass('card-title') !!}
      @endif
      
      @if($module->has('body'))
        {!! $module->get('body') !!}
      @endif
      
      @if($module->has('link'))
      @php
        $linked_post = get_post($module->get('link')->value()); 
      @endphp
        <a href="{{ get_permalink($linked_post) }}" class="card-link">{{ get_the_title($linked_post) }}</a>
      @endif
  </div>

@overwrite