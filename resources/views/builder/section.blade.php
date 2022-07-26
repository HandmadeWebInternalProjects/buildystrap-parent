@php
    $attrs = collect([
        'id' => $section->getAttribute('id'),
        'class' => $section->classes($section->getConfig('full_width') ? 'full' : 'not-full')
    ])->filter()
    ->map(fn($val, $key) => sprintf('%s="%s"', $key, $val))
    ->implode(' ');
@endphp

<div {!! $attrs !!}>
    @foreach($section->rows() as $row)
        {!! $row->render() !!}
    @endforeach
</div>
