@props(['tool' => null, 'title' => null, 'label' => null, 'placeholder' => __('tools.pasteTextHere'), 'nl2br' => true, 'results' => null])
<x-tool-wrapper :tool="$tool">
    <x-ad-slot :advertisement="get_advert_model('above-form')" />
    <x-tool-property-display :tool="$tool" name="wc_tool" label="wordCountLimit" :plans="true" upTo="upTo30k">
    </x-tool-property-display>
    <x-form method="post" :route="route('tool.handle', $tool->slug)" enctype="multipart/form-data">
        <div class="row custom-textarea-wrapper">
            <div class="col-md-12 mb-4">
                <x-input-label class="h4">{{ $title }}</x-input-label>
                <div class="custom-textarea p-3">
                    <div class="form-group relative">
                        <x-textarea-input type="text" name="string" class="form-control transparent" rows="8"
                            :placeholder="$placeholder" id="string" autofocus>
                            {{ $results['string'] ?? old('string') }}
                        </x-textarea-input>
                    </div>
                    <hr class="my-1">
                    <div class="d-flex">
                        <x-input-file-button accept=".txt" />
                    </div>
                </div>
                <x-input-error :messages="$errors->get('string')" />
            </div>
        </div>
        <x-ad-slot :advertisement="get_advert_model('below-form')" />
        <div class="row">
            <div class="col-md-12 text-end">
                <x-button type="submit" class="btn btn-outline-primary">
                    {{ $label }}
                </x-button>
            </div>
        </div>
    </x-form>
</x-tool-wrapper>
@if (isset($results))
    <div class="tool-results-wrapper">
        <x-ad-slot :advertisement="get_advert_model('above-result')" />
        <x-page-wrapper :title="__('common.result')">
            <div class="tool-results result mt-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="tabbar">
                            <div id="binaryText" class="large-text-scroller printable-result">
                                {!! $nl2br ? nl2br($results['converted_text']) : $results['converted_text'] !!}
                            </div>
                            <textarea class="d-none" id="save-to-file">{{ $results['converted_text'] }}</textarea>
                        </div>
                        <div class="result-copy mt-3 text-end">
                            <x-button class="btn btn-primary" type="button"
                                onclick="ArtisanApp.downloadAsTxt('#save-to-file', {filename: '{{ $tool->slug . '.txt' }}'})">
                                @lang('tools.saveAsTxt')
                            </x-button>
                            <x-copy-target target="binaryText" :text="__('common.copyToClipboard')" :svg="false" />
                        </div>
                    </div>
                </div>
            </div>
        </x-page-wrapper>
    </div>
@endif
<x-ad-slot :advertisement="get_advert_model('below-result')" />
<x-tool-content :tool="$tool" />
