<x-application-tools-wrapper>
    <x-tool-wrapper :tool="$tool">
        <x-ad-slot :advertisement="get_advert_model('above-form')" />
        <x-form method="post" :route="route('tool.handle', $tool->slug)" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <x-upload-wrapper max-files="1" :max-size="$tool->fs_tool" accept=".png,.jpeg,.gif,.jpg" input-name="image"
                        :file-title="__('tools.dropImageHereTitle')" :file-label="null" />
                    <x-input-error :messages="$errors->get('file')" class="mt-2" />
                </div>
            </div>
            <x-ad-slot :advertisement="get_advert_model('below-form')" />
            <div class="row">
                <div class="col-md-12 text-end">
                    <x-button type="submit" class="btn btn-outline-primary rounded-pill">
                        @lang('tools.generateFavicon')
                    </x-button>
                </div>
            </div>
        </x-form>
    </x-tool-wrapper>
    @if (isset($results))
        <div class="tool-results-wrapper">
            <x-ad-slot :advertisement="get_advert_model('above-result')" />
            <x-page-wrapper :title="__('common.result')">
                <div class="row">
                    <div class="col-md-12 mt-4 mb-3">
                        <table class="table table-style">
                            <thead>
                                <tr>
                                    <th>@lang('common.fileName')</th>
                                    <th width="200">@lang('common.size')</th>
                                    <th width="150"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($results['files'] as $file)
                                    <tr>
                                        <td>
                                            <div class="mw-350 text-truncate fw-bold">{{ $file['filename'] }}</div>
                                        </td>
                                        <td>{{ formatSizeUnits($file['size']) }}</td>
                                        <td id="file-cursor">
                                            <button class="btn btn-outline-primary rounded-circle download-file-btn"
                                                data-bs-toggle="tooltip" title="@lang('common.download')" type="button"
                                                id="download-file-{{ $loop->index }}"
                                                data-url="{{ url($file['url']) }}"
                                                data-filename="{{ $file['filename'] }}">
                                                <i class="an an-long-arrow-down"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12 text-end">
                        <x-form class="download-all-btn d-inline-block no-app-loader" metho="post" :route="route('tool.postAction', ['tool' => $tool->slug, 'action' => 'download'])">
                            <input type="hidden" name="process_id" value="{{ $results['process_id'] }}">
                            <x-download-form-button :text="__('tools.downloadAll')" />
                        </x-form>
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
                const attachEvents = function() {
                    document.querySelectorAll('.download-file-btn').forEach(button => {
                        button.addEventListener('click', e => {
                            const element = e.target.classList.contains('.download-file-btn') ? e
                                .target : e.target.closest('.download-file-btn')
                            ArtisanApp.downloadFromUrl(element.dataset.url, element.dataset
                                .filename)
                        })
                    });
                };
                return {
                    init: function() {
                        attachEvents();
                    },
                }
            }();
            @if (isset($results))
                document.addEventListener("DOMContentLoaded", function(event) {
                    APP.init();
                });
            @endif
        </script>
    @endpush
</x-application-tools-wrapper>
