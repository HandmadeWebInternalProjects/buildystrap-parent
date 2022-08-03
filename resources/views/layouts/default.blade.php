@include('partials.header')

@if(Buildystrap\Builder::isEnabled())
  <div class="buildystrap-container">
    {!! the_content() !!}
  </div>
  @else
    @yield('content')
@endif

@include('partials.footer')
