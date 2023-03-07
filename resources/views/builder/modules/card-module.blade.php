@php
  $direction = $module->get('image_placement') ?? 'flex-column';
  $card_classes = collect(['card', $direction])->filter()->implode(' ');
  $button_group_class = $module->get('button_group_class') ?? null;
@endphp

@extends('builder::module-base', ['class' => $card_classes])

@section('field_content')
    <div class="card-image">
        @if($module->has('image'))
          @php
          $aspect_ratio = $module->get('image_aspect_ratio') ? "aspect-ratio: {$module->get('image_aspect_ratio')};" : '';
          @endphp
          {!! wp_get_attachment_image(collect($module->get('image')->value())->first()['id'], 'medium', '', ['class' => 'card-img object-cover h-auto', 'style' => $aspect_ratio]) !!}
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
        <div class="button-group {{ $button_group_class }}">
          @foreach($module->get('button_groups')->value() as $button_group)
            @component('builder.components.button', ['button' => $button_group['button']]) @endcomponent
          @endforeach
        </div>
      @endif
  </div>

@overwrite