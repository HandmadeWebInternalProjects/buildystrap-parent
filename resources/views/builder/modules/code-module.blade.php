@extends('builder::module-base', ['class' => ''])

@section('field_content')
    {!! $module->fields()->get('code') !!}
@overwrite
