<div class="section {{ $section->getFromConfig('full_width') ? 'full' : 'not-full' }}">
    @foreach($section->rows() as $row)
        {!! $row->render() !!}
    @endforeach
</div>

@if($section->getFromConfig('container'))
    </div>
@endif
