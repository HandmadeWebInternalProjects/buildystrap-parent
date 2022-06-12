
<div class="row">
    @foreach($columns as $column)
        {!! $column->render() !!}
    @endforeach
</div>
