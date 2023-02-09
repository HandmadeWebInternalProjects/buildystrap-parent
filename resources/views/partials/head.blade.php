<!DOCTYPE html>
<html {{ language_attributes() }}>
<head>
	<meta charset="{{ bloginfo( 'charset' ) }}">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">

  {{-- An entry point to inject styles into the head tag --}}
  @stack('bs-head')
	{!! wp_head() !!}
</head>
