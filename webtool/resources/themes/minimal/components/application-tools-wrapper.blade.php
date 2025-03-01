<x-canvas-layout>
    {{ $slot }}
    @if (isset($herotitle))
        <x-slot name="pagetitle">
            {{ $herotitle }}
        </x-slot>
    @endif
    @if (!Widget::group('tools-sidebar')->isEmpty())
        <x-slot name="sidebar">
            <x-application-sidebar>
                @widgetGroup('tools-sidebar')
            </x-application-sidebar>
        </x-slot>
    @endif
</x-canvas-layout>
