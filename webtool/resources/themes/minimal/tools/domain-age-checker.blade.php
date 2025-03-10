<x-application-tools-wrapper>
    <x-tool-wrapper :tool="$tool">
        <x-ad-slot :advertisement="get_advert_model('above-form')" />
        <x-form method="post" :route="route('tool.handle', $tool->slug)">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <h3 class="h4">@lang('tools.enterDomainLimitLabel', ['count' => $tool->no_domain_tool])</h3>
                    </div>
                    <div class="form-group">
                        <x-textarea-input rows="5" class="form-control" name="domain" id="domain"
                            :placeholder="__('tools.enterDomainLimitPlaceholder')" :error="$errors->has('domain')" required>
                            {{ $results['domain'] ?? old('domain') }}
                        </x-textarea-input>
                        <x-input-error :messages="$errors->get('domain')" />
                    </div>
                </div>
            </div>
            <x-ad-slot :advertisement="get_advert_model('below-form')" />
            <div class="row">
                <div class="col-md-12 text-end mt-3">
                    <x-button type="submit" class="btn btn-outline-primary">
                        @lang('tools.getDomainAge')
                    </x-button>
                </div>
            </div>
        </x-form>
    </x-tool-wrapper>
    @if (isset($results))
        <div class="tool-results-wrapper">
            <x-ad-slot />
            <x-page-wrapper :title="__('common.result')">
                <div class="result mt-4">
                    <div class="progress mb-3" style="height: 3px;">
                        <div id="conversion-progress" class="progress-bar bg-success" role="progressbar"
                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <table class="table table-style mb-0">
                        <thead>
                            <th></th>
                            <th>@lang('tools.domainName')</th>
                            <th>@lang('tools.createdOnDate')</th>
                            <th>@lang('tools.expirationDate')</th>
                            <th>@lang('tools.age')</th>
                        </thead>
                        <tbody id="results-container">

                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-3" id="loader">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">@lang('common.loading')</span>
                        </div>
                    </div>
                </div>
            </x-page-wrapper>
        </div>
    @endif
    <x-ad-slot :advertisement="get_advert_model('below-result')" />
    <x-tool-content :tool="$tool" />
    @if (isset($results))
        @push('page_scripts')
            <script>
                const APP = function() {
                    const domains = {!! $results['domainAddresses'] !!};
                    var cursor = 0;
                    const getReslut = async function() {
                            if (domains.length == cursor) {
                                return;
                            }
                            const domain = domains[cursor]
                            initLoader(cursor)
                            await axios.post(
                                    '{{ route('tool.postAction', ['tool' => $tool->slug, 'action' => 'get-domain-detail']) }}', {
                                        domain: domain
                                    })
                                .then((res) => {
                                    updateResult(res.data)
                                })
                                .catch((err) => {
                                    resultError(cursor)
                                })
                            cursor++
                            if (cursor < domains.length) {
                                getReslut()
                            } else {
                                document.getElementById('loader').classList.add('d-none')
                            }
                        },
                        initLoader = function() {
                            const element = document.querySelector('#results-container')
                            const html = `<tr>
                                <td>${cursor+1}</td>
                                <td>${domains[cursor]}</td>
                                <td class="registered-${cursor}"><div class="placeholder-glow"><span class="placeholder col-8"></span></div></td>
                                <td class="expiry-${cursor}"><div class="placeholder-glow"><span class="placeholder col-8"></span></div></td>
                                <td class="age-${cursor}"><div class="placeholder-glow"><span class="placeholder col-8"></span></div></td>
                            </tr>`;

                            element.innerHTML += html
                        },
                        updateProgress = function() {
                            var progress = (parseInt(cursor + 1) / domains.length) * 100;
                            progress = Math.round(progress);

                            document.getElementById('conversion-progress').style.width = progress + '%'
                        },
                        updateResult = function(res) {
                            updateProgress()
                            document.querySelector(`#results-container .registered-${cursor}`).innerHTML = res.created || ''
                            document.querySelector(`#results-container .expiry-${cursor}`).innerHTML = res.expiry || ''
                            document.querySelector(`#results-container .age-${cursor}`).innerHTML = res.age || ''
                        },
                        resultError = function() {
                            const status = `<span class="small text-danger">{{ __('common.error') }}</span>`
                            updateResult({
                                age: status
                            })
                        };

                    return {
                        init: function() {
                            getReslut()
                        }
                    }
                }();

                document.addEventListener("DOMContentLoaded", function(event) {
                    APP.init();
                });
            </script>
        @endpush
    @endif
</x-application-tools-wrapper>
