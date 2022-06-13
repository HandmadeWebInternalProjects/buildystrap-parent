
<div class="container">
    @foreach($container->sections() as $section)
        {!! $section->render() !!}
    @endforeach
</div>
