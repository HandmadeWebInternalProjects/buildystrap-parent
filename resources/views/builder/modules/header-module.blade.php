@extends('builder::module-base', ['class' => ''])

@section('field_content')
    <h1>{!! $module->fields()->get('title') !!}</h1>
@overwrite
