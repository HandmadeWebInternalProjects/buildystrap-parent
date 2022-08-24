@php
    $navbar_type = get_theme_mod( 'understrap_navbar_type', 'offcanvas' );
@endphp

@include('partials.head')

<body {{ body_class() }} {{ understrap_body_attributes() }}>
{!! do_action( 'wp_body_open' ) !!}
<div class="site" id="page">

	<!-- ******************* The Navbar Area ******************* -->
	<header id="wrapper-navbar" class="sticky-top <?= acf_active() ? 'bg-' . get_field('buildystrap_header_background_colour', 'option') : '' ?>">

		<a class="skip-link sr-only sr-only-focusable" href="#content">{!! esc_html_e( 'Skip to content', 'buildystrap' ) !!}</a>

		{!! get_template_part( 'resources/views/global-templates/navbar', $navbar_type) !!}

	</header><!-- #wrapper-navbar end -->
