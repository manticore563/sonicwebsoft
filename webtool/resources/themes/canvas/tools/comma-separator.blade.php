<x-application-tools-wrapper>
    <x-tool-wrapper :tool="$tool">
        <x-ad-slot :advertisement="get_advert_model('above-form')" />
        <x-form method="post" :route="route('tool.handle', $tool->slug)">
            <div class="tabbar mb-3">
                <div class="row">
                    <div class="col-md-4 order-2 order-md-1">
                        <div class="tool-settings box-shadow h-100">
                            <div class="d-flex flex-row align-items-center flex-wrap gap-3 mb-3">
                                <x-input-label class="mb-0">@lang('tools.delimiter')</x-input-label>
                                <x-text-input type="text" class="w-auto" name="delimiter" id="delimiter"
                                    value="{{ old('delimiter', $results['delimiter'] ?? null) }}" placeholder=","
                                    :error="$errors->has('delimiter')" />
                                <x-input-error :messages="$errors->get('delimiter')" class="mt-2" />
                            </div>
                            <div class="d-flex flex-row align-items-center flex-wrap gap-3 mb-3">
                                <x-input-label class="mb-0">@lang('tools.listPrefix')</x-input-label>
                                <x-text-input type="text" class="w-25" name="list_prefix" id="list_prefix"
                                    value="{{ old('list_prefix', $results['list_prefix'] ?? '') }}" placeholder="<ul>"
                                    :error="$errors->has('list_prefix')" />
                                <x-input-label class="mb-0">@lang('tools.suffix')</x-input-label>
                                <x-text-input type="text" class="w-25" name="list_suffix" id="list_suffix"
                                    value="{{ old('list_suffix', $results['list_suffix'] ?? '') }}" placeholder="</ul>"
                                    :error="$errors->has('list_suffix')" />
                            </div>
                            <div class="d-flex flex-row align-items-center flex-wrap gap-3 mb-3">
                                <x-input-label class="mb-0">@lang('tools.itemPrefix')</x-input-label>
                                <x-text-input type="text" class="w-25" name="item_prefix" id="item_prefix"
                                    value="{{ old('item_prefix', $results['item_prefix'] ?? '') }}" placeholder="<li>"
                                    :error="$errors->has('item_prefix')" />
                                <x-input-label class="mb-0">@lang('tools.suffix')</x-input-label>
                                <x-text-input type="text" class="w-25" name="item_suffix" id="item_suffix"
                                    value="{{ old('item_suffix', $results['item_suffix'] ?? '') }}" placeholder="</li>"
                                    :error="$errors->has('item_suffix')" />
                            </div>
                            <div class="d-flex flex-row align-items-center flex-wrap gap-3 mb-3">
                                <x-input-label class="mb-0">@lang('tools.quotes')</x-input-label>
                                <div class="btn-group btn-toggle" id="quotes">
                                    <input type="radio" class="btn-check" name="quotes" id="no-quotes" value="none"
                                        autocomplete="off" @if (old('quotes', 'none') == 'none') checked @endif>
                                    <label class="btn btn-outline-primary btn-sm"
                                        for="no-quotes">@lang('tools.none')</label>
                                    <input type="radio" class="btn-check" name="quotes" id="double-quotes"
                                        value="double" autocomplete="off"
                                        @if (old('quotes', 'none') == 'double') checked @endif>
                                    <label class="btn btn-outline-primary btn-sm"
                                        for="double-quotes">@lang('tools.double')</label>
                                    <input type="radio" class="btn-check" name="quotes" id="single-quotes"
                                        value="single" autocomplete="off"
                                        @if (old('quotes', 'none') == 'single') checked @endif>
                                    <label class="btn btn-outline-primary btn-sm"
                                        for="single-quotes">@lang('tools.single')</label>
                                </div>
                            </div>
                            <div class="d-flex flex-row align-items-center flex-wrap gap-3 mb-3">
                                <x-input-label class="mb-0">@lang('tools.textCase')</x-input-label>
                                <div class="btn-group btn-toggle" id="text-case">
                                    <input type="radio" class="btn-check" name="textcase" id="default"
                                        value="default" autocomplete="off"
                                        @if (old('textcase', 'default') == 'default') checked @endif>
                                    <label class="btn btn-outline-primary btn-sm"
                                        for="default">@lang('tools.originalList')</label>

                                    <input type="radio" class="btn-check" name="textcase" id="uppercase"
                                        value="upper" autocomplete="off"
                                        @if (old('textcase', 'default') == 'upper') checked @endif>
                                    <label class="btn btn-outline-primary btn-sm"
                                        for="uppercase">@lang('tools.uppercaseList')</label>
                                    <input type="radio" class="btn-check" name="textcase" id="lowercase"
                                        value="lower" autocomplete="off"
                                        @if (old('textcase', 'default') == 'lower') checked @endif>
                                    <label class="btn btn-outline-primary btn-sm"
                                        for="lowercase">@lang('tools.lowercaseList')</label>
                                </div>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="1" name="reverse"
                                    id="reverse-list" @if (old('reverse', 0) == '1') checked @endif>
                                <label class="form-check-label" for="reverse-list">
                                    @lang('tools.reverseList')
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="1" name="line_breaks"
                                    id="line-breaks" @if (old('line_breaks', '1') == '1') checked @endif>
                                <label class="form-check-label" for="line-breaks">
                                    @lang('tools.removeLineBreaks')
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="1" name="spaces"
                                    id="remove-spaces" @if (old('spaces', '1') == '1') checked @endif>
                                <label class="form-check-label" for="remove-spaces">
                                    @lang('tools.removeExtraSpaces')
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="1" name="whitespace"
                                    id="remove-whitespace" @if (old('whitespace', '1') == '1') checked @endif>
                                <label class="form-check-label" for="remove-whitespace">
                                    @lang('tools.removeAllWhitespace')
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="duplicates"
                                    id="remove-duplicates" @if (old('duplicates', '1') == '1') checked @endif>
                                <label class="form-check-label" for="remove-duplicates">
                                    @lang('tools.removeDuplicates')
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 order-1 order-sm-2">
                        <div class="box-shadow text-option h-100">
                            <div class="form-group h-100">
                                <x-textarea-input rows="5" class="h-100" name="list" id="list"
                                    :placeholder="__('tools.enterListHere')" :error="$errors->has('list')">
                                    {{ $results['list'] ?? old('list') }}
                                </x-textarea-input>
                                <x-input-error :messages="$errors->get('list')" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-ad-slot :advertisement="get_advert_model('below-form')" />
            <div class="row mt-4 mb-4">
                <div class="col-md-12 text-end">
                    <x-button type="submit" id="calculate" class="btn btn-outline-primary rounded-pill">
                        @lang('tools.generateList')
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
                        <div class="col-md-12">
                            <div class="custom-textarea p-3">
                                <x-textarea-input readonly id="formated-list" class="transparent" rows="8">
                                    {{ $results['output'] }}
                                </x-textarea-input>
                            </div>
                            <div class="json--results-actions result-copy mt-3 text-end">
                                <x-button class="btn btn-primary rounded-pill" type="button" id="saveToFile">
                                    @lang('tools.saveAsTxt')
                                </x-button>
                                <x-copy-target target="formated-list" :text="__('common.copyToClipboard')" />
                            </div>
                        </div>
                    </div>
                </div>
            </x-page-wrapper>
        </div>
    @endif
    <x-tool-content :tool="$tool" />
    @if (isset($results))
        @push('page_scripts')
            <script>
                const APP = function() {
                    const attachEvents = function() {
                        document.getElementById('saveToFile').addEventListener('click', () => {
                            ArtisanApp.downloadAsTxt(document.getElementById('formated-list').value, {
                                isElement: false,
                                filename: '{{ $tool->slug . '.txt' }}'
                            })
                        });
                    };
                    return {
                        init: function() {
                            attachEvents()
                        },
                    }
                }();

                document.addEventListener("DOMContentLoaded", function(event) {
                    APP.init();
                });
            </script>
        @endpush
    @endif
</x-application-tools-wrapper>
