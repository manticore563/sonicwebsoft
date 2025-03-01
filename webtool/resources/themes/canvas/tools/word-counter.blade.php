<x-application-tools-wrapper>
    <x-tool-wrapper :tool="$tool">
        <x-ad-slot :advertisement="get_advert_model('above-form')" />
        <x-form method="post" :route="route('tool.handle', $tool->slug)">
            <x-tool-property-display :tool="$tool" name="wc_tool" label="wordCountLimit" :plans="true"
                upTo="upTo30k">
            </x-tool-property-display>
            <div class="row mb-4">
                <div class="col-md-12 mb-3">
                    <div class="form-group">
                        <x-textarea-input type="text" name="string" class="form-control" rows="8"
                            :placeholder="__('common.someText')" id="textarea" required autofocus contenteditable="true">
                            {{ $results['string'] ?? old('string') }}
                        </x-textarea-input>
                    </div>
                    <x-input-error :messages="$errors->get('string')" class="mt-2" />
                </div>
                <div class="col-md-12 d-flex">
                    <div class="me-auto">
                        <x-input-file-button />
                    </div>
                    <div class="ms-auto">
                        <x-button type="submit" class="btn-outline-primary rounded-pill text-end">
                            @lang('tools.countWords')
                        </x-button>
                    </div>
                </div>
            </div>
            <x-ad-slot :advertisement="get_advert_model('below-form')" />
        </x-form>
    </x-tool-wrapper>
    @if (isset($results))
        <div class="tool-results-wrapper">
            <x-ad-slot :advertisement="get_advert_model('above-result')" />
            <x-page-wrapper :title="__('common.result')">
                <div class="result mt-4">
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <div class="box-shadow text-center">
                                <span class="h2 bg-success px-3 py-2 text-white">
                                    {{ $results['words'] }}
                                </span>
                                <div class="fw-bold mt-3">@lang('common.words')</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="box-shadow text-center">
                                <span class="h2 bg-primary px-3 py-2 text-white">
                                    {{ $results['characters'] }}
                                </span>
                                <div class="fw-bold mt-3">@lang('common.characters')</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="box-shadow text-center">
                                <span class="h2 bg-danger px-3 py-2 text-white">
                                    {{ $results['syllables'] }}
                                </span>
                                <div class="fw-bold mt-3">@lang('common.syllables')</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="box-shadow text-center">
                                <span class="h2 bg-success px-3 py-2 text-white">
                                    {{ $results['sentences'] }}
                                </span>
                                <div class="fw-bold mt-3">@lang('common.sentences')</div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h3 class="h2 text-center text-uppercase">@lang('common.basicWordsCount')</h3>
                                <table class="table">
                                    <tr>
                                        <td>@lang('common.totalWords')</td>
                                        <td class="text-end">
                                            <span class="bg-success px-2 py-1 text-white">
                                                {{ $results['words'] }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('common.totalCharactersWS')</td>
                                        <td class="text-end">
                                            <span class="bg-success px-2 py-1 text-white">
                                                {{ $results['characters'] }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('common.totalCharactersWOS')</td>
                                        <td class="text-end">
                                            <span class="bg-success px-2 py-1 text-white">
                                                {{ $results['characters_wos'] }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div>
                                <h3 class="h2 text-center text-uppercase">@lang('common.readingTime')</h3>
                                <table class="table">
                                    <tr>
                                        <td>@lang('common.estimatedReadingTime')</td>
                                        <td class="text-end">
                                            <span class="bg-danger px-2 py-1 text-white">
                                                {{ $results['read_time'] }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('common.estimatedSpeakingTime')</td>
                                        <td class="text-end">
                                            <span class="bg-danger px-2 py-1 text-white">
                                                {{ $results['speaking_time'] }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h3 class="h2 text-center text-uppercase">
                                @lang('common.topWordsDensity')
                            </h3>
                            <div class="tabs-wrapper">
                                <ul class="nav nav-pills" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="oneWord-tab" data-bs-toggle="tab"
                                            data-bs-target="#oneWord" type="button" role="tab"
                                            aria-controls="oneWord" aria-selected="true">
                                            {{ trans_choice('common.numberWords', 1) }}
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="twoWord-tab" data-bs-toggle="tab"
                                            data-bs-target="#twoWord" type="button" role="tab"
                                            aria-controls="twoWord" aria-selected="true">
                                            {{ trans_choice('common.numberWords', 2) }}
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="threeWord-tab" data-bs-toggle="tab"
                                            data-bs-target="#threeWord" type="button" role="tab"
                                            aria-controls="threeWord" aria-selected="true">
                                            {{ trans_choice('common.numberWords', 3) }}
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content mt-4" id="myTabContent"
                                    style="max-height:200px;overflow-y:auto;">
                                    <div class="tab-pane fade show active" id="oneWord" role="tabpanel"
                                        aria-labelledby="oneWord-tab">
                                        <table class="table table-striped table-bordered">
                                            @foreach ($results['one'] as $word)
                                                <tr>
                                                    <th>{{ $word['keyword'] }}</th>
                                                    <td>{{ $word['frequency'] }} ({{ $word['percentage'] }}%)</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="twoWord" role="tabpanel"
                                        aria-labelledby="twoWord-tab">
                                        <table class="table table-striped table-bordered">
                                            @foreach ($results['two'] as $word)
                                                <tr>
                                                    <th>{{ $word['keyword'] }}</th>
                                                    <td>{{ $word['frequency'] }} ({{ $word['percentage'] }}%)</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="threeWord" role="tabpanel"
                                        aria-labelledby="threeWord-tab">
                                        <table class="table table-striped table-bordered">
                                            @foreach ($results['three'] as $word)
                                                <tr>
                                                    <th>{{ $word['keyword'] }}</th>
                                                    <td>{{ $word['frequency'] }} ({{ $word['percentage'] }}%)</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-4">
                            <div class="box-shadow">
                                <h3 class="h2 text-center text-uppercase">@lang('common.longestSentence')</h3>
                                @lang('common.longestSentenceStats', $results['paragraph']): {{ $results['paragraph']['string'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </x-page-wrapper>
        </div>
        <x-ad-slot :advertisement="get_advert_model('below-result')" />
    @endif
    <x-tool-content :tool="$tool" />
    @push('page_scripts')
        <script>
            const APP = function() {
                let editorInstance = document.getElementById('textarea');
                const attachEvents = function() {
                    document.getElementById('file').addEventListener('change', e => {
                        var file = document.getElementById("file").files[0];
                        if (file.type != "text/plain") {
                            ArtisanApp.toastError("{{ __('common.invalidFile') }}");
                            return;
                        }
                        APP.setFileContent(file);
                    });
                };

                return {
                    init: function() {
                        attachEvents()
                    },
                    setFileContent: function(file) {
                        var reader = new FileReader();
                        reader.readAsText(file, "UTF-8");
                        reader.onload = function(evt) {
                            editorInstance.value = evt.target.result;
                        }
                        reader.onerror = function(evt) {
                            ArtisanApp.toastError("error reading file");
                        }
                    },
                }
            }()
            document.addEventListener("DOMContentLoaded", function(event) {
                APP.init();
            });
        </script>
    @endpush
</x-application-tools-wrapper>
