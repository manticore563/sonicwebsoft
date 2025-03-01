@if ($tags && $tags->count() > 0)
    <x-widget-wrapper :title="$title">
        @foreach ($tags as $tag)
            <a class="btn btn-light text-light btn-sm me-1 mb-2" href="">{{ $tag->name }}</a>
        @endforeach
    </x-widget-wrapper>
@endif
