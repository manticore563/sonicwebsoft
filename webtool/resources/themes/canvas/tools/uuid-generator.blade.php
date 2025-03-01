<x-application-tools-wrapper>
    <x-tool-wrapper :tool="$tool">
        <x-ad-slot :advertisement="get_advert_model('above-form')" />
        @if (isset($uuid))
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center mb-5">
                        <div class="h1">@lang('tools.yourUuid')</div>
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="h3 text-secondary me-2 mb-0" id="result-uuid">{{ $uuid }}</span>
                            <x-copy-target target="result-uuid" />
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <x-form method="post" :route="route('tool.handle', $tool->slug)">
            <div class="box-shadow tabbar mb-3">
                <h2>@lang('tools.bulkUuidGeneration')</h2>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-input-label>@lang('tools.howMany')</x-input-label>
                            <x-text-input type="number" min="1" max="500" step="1"
                                class="form-control" name="limit" id="limit" required placeholder="10"
                                value="{{ $limit ?? old('limit', 1) }}" :error="$errors->has('limit')" />
                            <x-input-error :messages="$errors->get('limit')" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>
            <x-ad-slot :advertisement="get_advert_model('below-form')" />
            <div class="row mt-4 mb-4">
                <div class="col-md-12 text-end">
                    <x-button type="submit" id="calculate" class="btn btn-outline-primary rounded-pill">
                        @lang('tools.generate')
                    </x-button>
                </div>
            </div>
        </x-form>
    </x-tool-wrapper>
    @if (isset($results))
        <div class="tool-results-wrapper">
            <x-ad-slot :advertisement="get_advert_model('above-result')" />
            <x-page-wrapper :title="__('common.result')">
                <div class="result mt-4">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="custom-textarea p-3">
                                <x-textarea-input id="bulkUuidNumbers" class="transparent" readonly rows="8">
                                    {{ $results['copy'] }}
                                </x-textarea-input>
                            </div>
                        </div>
                        <div class="col-md-12 text-end">
                            <x-copy-target target="bulkUuidNumbers" :text="__('common.copyToClipboard')" :svg="false" />
                            <x-download-form-button type="button"
                                onclick="ArtisanApp.downloadAsTxt('#bulkUuidNumbers', {filename: '{{ $tool->slug . '.txt' }}'})"
                                :tooltip="__('tools.saveAsTxt')" />
                        </div>
                    </div>
                </div>
            </x-page-wrapper>
        </div>
    @endif
    <x-tool-content :tool="$tool" />
</x-application-tools-wrapper>
