<div class="section {{ $section->getConfig('full_width') ? 'full' : 'not-full' }}">
    @foreach($section->rows() as $row)
        {!! $row->render() !!}
    @endforeach
</div>
