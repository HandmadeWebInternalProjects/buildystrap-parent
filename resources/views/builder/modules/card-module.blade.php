<div class="{{ $module->type() }}">
    <h2>{!! $module->fields()->get('title') !!}</h2>

    @if($module->fields()->get('url'))
        <a href="{{ $module->fields()->get('url') }}">{{ $module->fields()->get('url') }}</a>
    @endif

    {!! $module->fields()->get('body') !!}
</div>
