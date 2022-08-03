@extends('builder::module-base', ['class' => 'accordion'])

@section('field_content')

  {!! $module->get('accordion') !!}

@overwrite