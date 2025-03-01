<x-application-tools-wrapper>
    <x-tool-wrapper :tool="$tool">
        <x-ad-slot :advertisement="get_advert_model('above-form')" />
        <x-form method="post" :route="route('tool.handle', $tool->slug)">
            <div class="box-shadow tabbar mb-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <x-input-label>@lang('tools.number')</x-input-label>
                            <x-text-input type="number" min="1" max="500" step="1" class="form-control"
                                name="limit" id="limit" required placeholder="10"
                                value="{{ $limit ?? old('limit', 3) }}" :error="$errors->has('limit')" />
                            <x-input-error :messages="$errors->get('limit')" class="mt-2" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-input-label>@lang('tools.typeOfResult')</x-input-label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="type-paragraph"
                                    value="paragraph"
                                    {{ old('type', $type ?? 'paragraph') == 'paragraph' ? 'checked' : '' }} />
                                <x-input-label class="form-check-label"
                                    for="type-paragraph">@lang('tools.paragraph')</x-input-label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="type-words"
                                    value="words"
                                    {{ old('type', $type ?? 'paragraph') == 'words' ? 'checked' : '' }} />
                                <x-input-label class="form-check-label"
                                    for="type-words">@lang('tools.words')</x-input-label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="type-sentences"
                                    value="sentences"
                                    {{ old('type', $type ?? 'paragraph') == 'sentences' ? 'checked' : '' }} />
                                <x-input-label class="form-check-label"
                                    for="type-sentences">@lang('tools.sentences')</x-input-label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="type-list"
                                    value="list" {{ old('type', $type ?? 'paragraph') == 'list' ? 'checked' : '' }} />
                                <x-input-label class="form-check-label"
                                    for="type-list">@lang('tools.list')</x-input-label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <input class="form-check-input" type="checkbox" name="start" id="start" value="1"
                                {{ old('start', $start ?? '1') == '1' ? 'checked' : '' }} />
                            <x-input-label class="form-check-label" for="start">@lang('tools.startWithLoremIpsum')</x-input-label>
                        </div>
                    </div>
                </div>
            </div>
            <x-ad-slot :advertisement="get_advert_model('below-form')" />
            <div class="row mt-4 mb-4">
                <div class="col-md-12 text-end">
                    <x-button type="submit" id="calculate" class="btn btn-outline-primary rounded-pill">
                        @lang('tools.generateLoremIpsum')
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
                            <div class="tool-results p-3">
                                <div id="lIpsumContent" class="large-text-scroller">
                                    {!! $results['content'] !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-end">
                            <x-copy-target target="lIpsumContent" :text="__('common.copyToClipboard')" :svg="false" />
                            <x-download-form-button type="button"
                                onclick="ArtisanApp.downloadAsTxt(document.getElementById('lIpsumContent').innerText, {isElement: false, filename: '{{ $tool->slug . '.txt' }}'})"
                                :tooltip="__('tools.saveAsTxt')" />
                        </div>
                    </div>
                </div>
            </x-page-wrapper>
        </div>
    @endif
    <x-tool-content :tool="$tool" />
</x-application-tools-wrapper>
