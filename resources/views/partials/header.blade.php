@php
    $navbar_type = get_theme_mod( 'understrap_navbar_type', 'collapse' );
@endphp

@include('partials.head')

<body {{ body_class() }} {{ understrap_body_attributes() }}>
{!! do_action( 'wp_body_open' ) !!}
<div class="site" id="page">

	<!-- ******************* The Navbar Area ******************* -->
	<header id="wrapper-navbar">

		<a class="skip-link sr-only sr-only-focusable" href="#content">{!! esc_html_e( 'Skip to content', 'buildystrap' ) !!}</a>

		{!! get_template_part( 'global-templates/navbar', $navbar_type) !!}

	</header><!-- #wrapper-navbar end -->
