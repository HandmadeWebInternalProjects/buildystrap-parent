@php
$height = $module->has('height') ? $module->get('height')->value() : '0.1rem';
@endphp


@extends('builder::module-base', ['class' => '', 'style' => "height: {$height};"])

@section('field_content')
    
@overwrite