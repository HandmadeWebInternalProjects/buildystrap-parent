
<div class="column">
    @foreach($column->modules() as $module)
        {!! $module->render() !!}
    @endforeach
</div>
