
<div class="container">
    @foreach($sections as $section)
        {!! $section->render() !!}
    @endforeach
</div>
