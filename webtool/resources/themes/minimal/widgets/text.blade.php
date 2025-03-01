@if (!empty($text))
    <x-widget-wrapper :title="$title">
        {!! nl2br(e($text)) !!}
    </x-widget-wrapper>
@endif
