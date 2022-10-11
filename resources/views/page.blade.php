@extends(extendable_layout())

@section('content')

	@php
		$container = get_theme_mod( 'understrap_container_type' );
	@endphp

	<div class="wrapper" id="page-wrapper">

		<div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

			<div class="row">

				<main class="site-main" id="main">

					<?php
                    while (have_posts()) {
                        the_post();
                        get_template_part('resources/views/loop-templates/content', 'page');

                        // If comments are open or we have at least one comment, load up the comment template.
                        if (comments_open() || get_comments_number()) {
                            comments_template();
                        }
                    }
                    ?>

				</main><!-- #main -->

			</div><!-- .row -->

		</div><!-- #content -->

	</div><!-- #page-wrapper -->
@endsection
