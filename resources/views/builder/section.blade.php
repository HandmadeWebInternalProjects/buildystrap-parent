
<div class="section">
    @foreach($section->rows() as $row)
        {!! $row->render() !!}
    @endforeach
</div>
