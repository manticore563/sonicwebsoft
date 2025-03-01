@if ($categories->count() > 0)
    <x-widget-wrapper :title="$title">
        <ul class="list-group list-group-flush">
            @foreach ($categories as $category)
                <li class="list-group-item">
                    <a href="{{ route('tool.category', ['category' => $category->slug]) }}">
                        {{ $category->name }}
                        @if (isset($config['tool_counts']) && $config['tool_counts'])
                            <span class="text-muted">({{ $category->tools_count ?? '' }})</span>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    </x-widget-wrapper>
@endif
