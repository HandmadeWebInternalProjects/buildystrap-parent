@extends('builder::module-base', ['class' => ''])

@section('field_content')

    @if($module->has('image'))
      {!! $module-get('image') !!}
    @endif
    
@overwrite