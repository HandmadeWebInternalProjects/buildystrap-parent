@extends('builder::module-base', ['class' => ''])

@section('field_content')
    {!! $module->fields()->get('text') !!}
@overwrite
