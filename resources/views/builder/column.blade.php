<div class="col">
    @foreach($column->modules() as $module)
        {!! $module->render() !!}
    @endforeach
</div>
