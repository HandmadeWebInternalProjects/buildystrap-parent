@include('partials.header')

@if(json_decode(get_the_content()))
    {!! Buildystrap\Builder::renderFromContent(get_the_content())->render() !!}
@else
    @yield('content')
@endif

@include('partials.footer')
