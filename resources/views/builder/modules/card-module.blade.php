@php
    $attrs = collect([
        'id' => $module->getAttribute('id'),
        'class' => $module->classes('card')
    ])->filter()
    ->map(fn($val, $key) => sprintf('%s="%s"', $key, $val))
    ->implode(' ');
@endphp

<div {!! $attrs !!}>
    

    {!! wp_get_attachment_image(collect($module->get('image')->value())->first()->id, 'medium', '', ['class' => 'card-img-top object-contain']) !!}

    <div class="card-body">
      {!! $module->get('title')->titleClass('card-title') !!}
      
      {!! $module->get('body') !!}

      @if($module->has('link'))
        <a href="{{ get_permalink($module->get('link')) }}" class="card-link">{{ $module->get('link')}}</a>
      @endif
    </div>

</div>
