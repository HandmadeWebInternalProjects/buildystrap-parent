@extends('builder::module-base', ['class' => ''])

@section('field_content')
    {!! $module->get('title') !!}

    {!! $module->get('image') !!}

    @if($module->has('link'))
        <a href="{{ $module->get('link') }}">
            {{ $module->get('link') }}
        </a>
    @endif

    {!! $module->get('body') !!}
@overwrite
