@foreach($container->sections() as $section)
    {!! $section->getConfig('boxed_layout') ? '<div class="container">' : null !!}

      {!! $section->render() !!}

    {!! $section->getConfig('boxed_layout') ? '</div>' : null !!}
@endforeach