@props([
    'title' => false,
    'subTitle' => false,
    'heading' => 'h2',
    'link' => false,
    'heroClass' => null
])

<div {!! $attributes->merge(['class' => 'wrap-content bg-transparent m-0 pt-0']) !!}>
    @if ($title || $subTitle)
        <div class="{{ trim($heroClass . 'hero-title bg-transparent') }}">
            @if (!empty($title))
                <{{ $heading }}>
                    @if (!$link)
                        {{ $title }}
                    @else
                        <a href="{{ $link }}">
                            {{ $title }}
                        </a>
                    @endif
                    </{{ $heading }}>
            @endif
            @if (!empty($subTitle))
                <p>{{ $subTitle ?? '' }}</p>
            @endif
        </div>
    @endif
    {{ $slot }}
</div>
