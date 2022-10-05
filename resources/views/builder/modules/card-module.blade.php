@php
  $direction = $module->get('image_placement') ?? 'flex-column';
  $card_classes = collect(['card', 'flex-wrap', $direction])->filter()->implode(' ');
@endphp

@extends('builder::module-base', ['class' => $card_classes])


@section('field_content')
    <div class="card-image">
        @if($module->has('image'))
          @php
          $aspect_ratio = $module->get('image_aspect_ratio') ? "aspect-ratio: {$module->get('image_aspect_ratio')};" : '';
          @endphp
          {!! wp_get_attachment_image(collect($module->get('image')->value())->first()['id'], 'medium', '', ['class' => 'card-img object-cover', 'style' => $aspect_ratio]) !!}
        @endif
    </div>

    <div class="card-body">
      @if($module->has('title'))
        {!! $module->get('title')->titleClass('card-title') !!}
      @endif
      
      @if($module->has('body'))
        {!! $module->get('body') !!}
      @endif
      
      @if($module->has('button_groups'))
        @foreach($module->get('button_groups')->value() as $button_group)
          @component('builder.components.button', ['button' => $button_group['button']]) @endcomponent
        @endforeach
      @endif
  </div>

@overwrite