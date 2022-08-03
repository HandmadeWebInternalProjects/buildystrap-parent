@foreach($container->sections() as $section)
  {!! $section->render() !!}
@endforeach