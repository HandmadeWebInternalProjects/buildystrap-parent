@extends('layouts.default')

@php

  use Buildystrap\Builder;

@endphp

@section('content')

	<div class="wrapper" id="page-wrapper">

		<div id="content" tabindex="-1">

			<div class="row">

				<main class="site-main" id="main">

					{!! Builder::renderFromContent(get_the_content(get_the_ID())) !!}

				</main><!-- #main -->

			</div><!-- .row -->

		</div><!-- #content -->

	</div><!-- #page-wrapper -->
@endsection
