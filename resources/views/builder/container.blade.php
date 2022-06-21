@foreach($container->sections() as $section)
    {!! $section->getConfig('container') ? '<div class="container">' : null !!}

    {!! $section->render() !!}

    {!! $section->getConfig('container') ? '</div>' : null !!}
@endforeach