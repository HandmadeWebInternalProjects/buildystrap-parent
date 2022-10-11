@extends(extendable_layout())

@section('content')

	@php
		$container = get_theme_mod( 'understrap_container_type' );
	@endphp

	<div class="wrapper" id="index-wrapper">

		<div class="{{ esc_attr( $container ) }}" id="content" tabindex="-1">

			<div class="row">

				<main class="site-main" id="main">

					@if ( have_posts() )

						@while ( have_posts() )
							@php(the_post())

							{{-- /*
							* Include the Post-Format-specific template for the content.
							* If you want to override this in a child theme, then include a file
							* called content-___.php (where ___ is the Post Format name) and that will be used instead.
							*/ --}}
							{!! get_template_part( 'resources/views/loop-templates/content', get_post_format() ) !!}
						@endwhile
					@else
						{!! get_template_part( 'resources/views/loop-templates/content', 'none' ) !!}
					@endif

				</main><!-- #main -->

				<!-- The pagination component -->
				{!! understrap_pagination() !!}

			</div><!-- .row -->

		</div><!-- #content -->

	</div><!-- #index-wrapper -->

@endsection
