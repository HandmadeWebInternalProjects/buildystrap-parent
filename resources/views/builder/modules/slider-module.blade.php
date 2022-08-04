@extends('builder::module-base', ['class' => 'swiper'])

@section('field_content')
  @if($module->has('slides'))
  <div class="swiper-wrapper">
      @foreach($module->get('slides')->value() as $slide)
        <div class="swiper-slide">
          <?= wp_get_attachment_image( collect($slide->image)->first()->id, 'full', false, [] ); ?>
        </div>
      @endforeach
  </div>

  @endif
@overwrite
