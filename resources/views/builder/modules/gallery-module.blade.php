@php
    $attrs = collect([
        'id' => $module->getAttribute('id'),
        'class' => $module->classes()
    ])->filter()
    ->map(fn($val, $key) => sprintf('%s="%s"', $key, $val))
    ->implode(' ');

    $col_count = $module->get('columns') ?? 3;
    $col_gap = $module->get('column_gap') ?? 3;
@endphp

<div {!! $attrs !!}>
  <div class="grid gap-{{ $col_gap }}">
    @foreach($module->get('images')->value() as $image)
      <div class="g-col-{{ 12 / $col_count }}">
        {!! wp_get_attachment_image($image->id, 'large') !!}
      </div>
    @endforeach
  </div>
    
</div>
