<x-application-tools-wrapper>
    <x-tool-wrapper :tool="$tool">
        <x-ad-slot :advertisement="get_advert_model('above-form')" />
        <x-form method="post" :route="route('tool.handle', $tool->slug)">
            <div class="box-shadow tabbar mb-3">
                <div class="row row-cols-1 row-cols-sm-1 row-cols-md-3">
                    <div class="col">
                        <div class="form-inline d-flex align-items-center mb-3">
                            <x-input-label class="mb-0 text-nowrap">@lang('tools.lowerLimit')</x-input-label>
                            <x-text-input type="number" min="0" step=".01" class="form-control"
                                name="lower_limit" id="lower_limit" required
                                value="{{ $lower_limit ?? old('lower_limit', 1) }}" placeholder="1" :error="$errors->has('lower_limit')" />
                            <x-input-error :messages="$errors->get('lower_limit')" class="mt-2" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-inline d-flex align-items-center mb-3">
                            <x-input-label class="mb-0 text-nowrap">@lang('tools.upperLimit')</x-input-label>
                            <x-text-input type="number" min="1" step=".01" class="form-control"
                                name="upper_limit" id="upper_limit" required placeholder="100"
                                value="{{ $upper_limit ?? old('upper_limit', 100) }}" :error="$errors->has('upper_limit')" />
                            <x-input-error :messages="$errors->get('upper_limit')" class="mt-2" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-inline d-flex align-items-center mb-3">
                            <x-input-label class="mb-0">@lang('tools.generate')</x-input-label>
                            <x-text-input type="number" min="1" max="100" step="1"
                                class="form-control" name="limit" id="limit" required placeholder="10"
                                value="{{ $limit ?? old('limit', 1) }}" :error="$errors->has('limit')" />
                            <x-input-label class="mb-0">@lang('tools.numbers')</x-input-label>
                        </div>
                        <x-input-error :messages="$errors->get('limit')" class="mt-2" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <x-input-label>@lang('tools.typeOfResult')</x-input-label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="type-integer"
                                value="integer" {{ old('type', $type ?? 'integer') == 'integer' ? 'checked' : '' }} />
                            <x-input-label class="form-check-label" for="type-integer">@lang('tools.integer')</x-input-label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="type-decimal"
                                value="decimal" {{ old('type', $type ?? 'integer') == 'decimal' ? 'checked' : '' }} />
                            <x-input-label class="form-check-label" for="type-decimal">@lang('tools.decimal')</x-input-label>
                        </div>
                    </div>
                </div>
            </div>
            <x-ad-slot :advertisement="get_advert_model('below-form')" />
            <div class="row mt-4 mb-4">
                <div class="col-md-12 text-end">
                    <x-button type="submit" id="calculate" class="btn btn-outline-primary rounded-pill">
                        @lang('tools.generateNumbers')
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
                                <x-textarea-input id="numberResult" class="transparent" readonly rows="8">
                                    {{ $results['copy'] }}
                                </x-textarea-input>
                            </div>
                        </div>
                        <div class="col-md-12 text-end">
                            <x-copy-target target="numberResult" :text="__('common.copyToClipboard')" :svg="false" />
                            <x-download-form-button type="button"
                                onclick="ArtisanApp.downloadAsTxt('#numberResult', {filename: '{{ $tool->slug . '.txt' }}'})"
                                :tooltip="__('tools.saveAsTxt')" />
                        </div>
                    </div>
                </div>
            </x-page-wrapper>
        </div>
    @endif
    <x-tool-content :tool="$tool" />
</x-application-tools-wrapper>
