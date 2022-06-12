@php
    $navbar_type = get_theme_mod( 'understrap_navbar_type', 'collapse' );
@endphp
<!DOCTYPE html>
<html {{ language_attributes() }}>
<head>
	<meta charset="{{ bloginfo( 'charset' ) }}">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	{!! wp_head() !!}
</head>

<body {{ body_class() }} {{ understrap_body_attributes() }}>
{!! do_action( 'wp_body_open' ) !!}
<div class="site" id="page">

	<!-- ******************* The Navbar Area ******************* -->
	<header id="wrapper-navbar">

		<a class="skip-link sr-only sr-only-focusable" href="#content">{!! esc_html_e( 'Skip to content', 'buildystrap' ) !!}</a>

		{!! get_template_part( 'global-templates/navbar', $navbar_type) !!}

	</header><!-- #wrapper-navbar end -->
