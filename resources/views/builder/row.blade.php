@php
    $attrs = collect([
        'id' => $row->getAttribute('id'),
        'class' => $row->classes()
    ])->filter()
    ->map(fn($val, $key) => sprintf('%s="%s"', $key, $val))
    ->implode(' ');
@endphp

<div {!! $attrs !!}>
    @foreach($row->columns() as $column)
        {!! $column->render() !!}
    @endforeach
</div>
