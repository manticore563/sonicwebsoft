@if (!empty($html))
    <x-widget-wrapper :title="$title">
        {!! $html !!}
    </x-widget-wrapper>
@endif
