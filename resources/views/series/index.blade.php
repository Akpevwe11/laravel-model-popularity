Index
@foreach ($popular as $series )

<div>
    {{ $series->title }} (<a href="/series/{{ $series->slug }}">{{ $series->slug }}</a>)
    {{ $series->visit_count_total }}
</div>

@endforeach
