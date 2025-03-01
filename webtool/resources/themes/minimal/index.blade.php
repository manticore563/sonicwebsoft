<x-canvas-layout>
    @if (!Widget::group('sidebar')->isEmpty())
        <x-slot name="sidebar">
            <x-application-sidebar>
                @widgetGroup('sidebar')
            </x-application-sidebar>
        </x-slot>
    @endif
    {{-- <x-page-wrapper :title="__('tools.favoriteTools')" :sub-title="__('tools.favoriteToolsDesc')">
        <x-favorite-tools :tools="$favorties" />
    </x-page-wrapper> --}}
    @foreach ($tools as $item)
        @if ($loop->index % 3 == 0)
            <x-ad-slot :advertisement="get_advert_model(array_shift($ads))" />
        @endif
        <x-page-wrapper-tool :title="$item->name" :sub-title="$item->meta_description" :link="route('tool.category', ['category' => $item->slug])">
             <div class="products">
                <div class="row">
                    <ul class="items {{ theme_option('tools_layout', 'grid-view') }}">
                        @foreach ($item->tools as $tool)
                            <x-tool-item :tool="$tool" />
                        @endforeach
                    </ul>
                </div>
            </div>
        </x-page-wrapper-tool>
    @endforeach
</x-canvas-layout>
