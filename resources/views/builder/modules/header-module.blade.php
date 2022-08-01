@extends('builder::module-base', ['class' => ''])

@section('field_content')
    {!! $module->get('title') !!}
@overwrite
