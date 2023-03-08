@extends('builder::module-base')

@section('field_content')
    {{ $module->get('title') }}
@overwrite
