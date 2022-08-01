@extends('builder::module-base', ['class' => 'card'])

@section('field_content')
  @if($module->has('image'))
    {!! wp_get_attachment_image(collect($module->get('image')->value())->first()->id, 'medium', '', ['class' => 'card-img-top object-contain']) !!}
  @endif

  <div class="card-body">
    @if($module->has('title'))
      {!! $module->get('title')->titleClass('card-title') !!}
    @endif
    
    @if($module->has('body'))
      {!! $module->get('body') !!}
    @endif
    
    @if($module->has('link'))
      <a href="{{ get_permalink($module->get('link')) }}" class="card-link">{{ $module->get('link')}}</a>
    @endif
  </div>

@overwrite