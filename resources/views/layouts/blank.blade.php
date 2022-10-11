@include('partials.head')

<body {{ body_class() }} {{ understrap_body_attributes() }}>
{!! do_action( 'wp_body_open' ) !!}
<div class="site" id="page">

@if(Buildystrap\Builder::isEnabled())
    {!! the_content() !!}
@else
    @yield('content')
@endif

@include('partials.foot')
