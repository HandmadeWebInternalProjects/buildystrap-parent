<div class="row">
    @foreach($row->columns() as $column)
        {!! $column->render() !!}
    @endforeach
</div>
