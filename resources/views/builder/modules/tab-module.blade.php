@extends('builder::module-base')

@section('field_content')

  @if($module->has('tabs'))
    <ul class='nav nav-tabs' role='tablist'>
      @foreach($module->get('tabs')->value() as $index => $value)
        @php
          $title = $value['title'];
          $content = $value['content'];
          $slug = \Str::slug($title);
          $active = $index === 0 ? 'active' : '';
        @endphp
        
          <li class='nav-item' role='presentation'>
            <button 
            class='nav-link {{ $active }}' 
            id='{{ $slug }}-tab' 
            data-bs-toggle='tab' 
            data-bs-target='#{{ $slug }}-tab-pane' 
            type='button' 
            role='tab' 
            aria-controls='{{ $slug }}-tab-pane' 
            aria-selected='true'>
              {{ esc_html__($title, 'buildystrap') }}
            </button>
          </li>
      @endforeach
    </ul>
    @foreach($module->get('tabs')->value() as $index => $value)
      @php
          $title = $value['title'];
          $content = $value['content'];
          $slug = \Str::slug($title);
          $active = $index === 0 ? 'show active' : '';
      @endphp
      <div class='tab-content'>
        <div 
          class='tab-pane fade {{ $active }} p-1 border border-1 border-top-0 rounded-bottom' 
          id='{{ $slug }}-tab-pane' 
          role='tabpanel' 
          aria-labelledby='{{ $slug }}-tab' 
          tabindex='0'>
            {!! $content !!}
        </div>
      </div>
    @endforeach
  @endif

@overwrite