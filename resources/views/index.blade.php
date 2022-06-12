@extends('layouts.app')

@section('content')

	@php
		$container = get_theme_mod( 'understrap_container_type' );
	@endphp

	@if(is_front_page() && is_home())
		{!! get_template_part( 'global-templates/hero' ) !!}
	@endif

	<div class="wrapper" id="index-wrapper">

		<div class="{{ esc_attr( $container ) }}" id="content" tabindex="-1">

			<div class="row">

				<!-- Do the left sidebar check and opens the primary div -->
				{!! get_template_part( 'global-templates/left-sidebar-check' ) !!}

				<main class="site-main" id="main">

					@if ( have_posts() )

						@while ( have_posts() )
							@php(the_post())

							{{-- /*
							* Include the Post-Format-specific template for the content.
							* If you want to override this in a child theme, then include a file
							* called content-___.php (where ___ is the Post Format name) and that will be used instead.
							*/ --}}
							{!! get_template_part( 'loop-templates/content', get_post_format() ) !!}
						@endwhile
					@else
						{!! get_template_part( 'loop-templates/content', 'none' ) !!}
					@endif

				</main><!-- #main -->

				<!-- The pagination component -->
				{!! understrap_pagination() !!}

				<!-- Do the right sidebar check -->
				{!! get_template_part( 'global-templates/right-sidebar-check' ) !!}

			</div><!-- .row -->

		</div><!-- #content -->

	</div><!-- #index-wrapper -->

@endsection
