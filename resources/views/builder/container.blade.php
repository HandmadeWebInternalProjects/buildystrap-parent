@foreach($container->sections() as $section)
    @if($section->getFromConfig('container'))
        <div class="container">
    @endif

    {!! $section->render() !!}

    @if($section->getFromConfig('container'))
        </div>
    @endif
@endforeach
