@extends('builder::module-base', ['class' => ''])

@section('field_content')
  @if($title = $module->get('title'))
    <div class="mb-2">
      {{ $title }}
    </div>
  @endif
  
  @if($form = $module->get('form')->value())
    {!! apply_shortcodes("[gravityform id=\"$form\" title='false' description='false']") !!}
  @endif
@overwrite