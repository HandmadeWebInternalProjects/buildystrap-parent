@include('partials.header')

@if(Buildystrap\Builder::isEnabled())
    {!! the_content() !!}
@else
    @yield('content')
@endif

@include('partials.footer')
