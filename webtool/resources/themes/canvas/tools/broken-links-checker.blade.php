<x-application-tools-wrapper>
    <x-tool-wrapper :tool="$tool">
        <x-ad-slot :advertisement="get_advert_model('above-form')" />
        <x-form method="post" :route="route('tool.handle', $tool->slug)">
            <div class="box-shadow my-3 py-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <h3 class="h4">@lang('tools.enterDomainName')</h3>
                        </div>
                        <div class="form-group">
                            <x-text-input type="text" class="form-control" name="url" id="url" required
                                value="{{ $results['url'] ?? old('url') }}" :error="$errors->has('url')" :placeholder="__('tools.enterURL')" />
                            <x-input-error :messages="$errors->get('url')" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>
            <x-ad-slot :advertisement="get_advert_model('below-form')" />
            <div class="row">
                <div class="col-md-12 text-end">
                    <x-button type="submit" class="btn btn-outline-primary rounded-pill">
                        @lang('tools.getBrokenLinks')
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
                            <div class="progress mb-3" style="height: 3px;">
                                <div id="conversion-progress" class="progress-bar bg-success" role="progressbar"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <table class="table table-style mb-0">
                                <tr>
                                    <th></th>
                                    <th>@lang('common.url')</th>
                                    <th>@lang('tools.linkText')</th>
                                    <th>@lang('tools.status')</th>
                                    <th>@lang('tools.serverResponse')</th>
                                    <th>@lang('tools.more')</th>
                                </tr>
                                <tbody>
                                    @foreach ($urls['links'] as $link)
                                        <tr id="link-{{ $loop->index }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $link['url'] }}</td>
                                            <td>{{ $link['content'] }}</td>
                                            <td class="status">
                                                <div class="spinner-border spinner-border-sm" role="status">
                                                    <span class="visually-hidden">@lang('common.loading')</span>
                                                </div>
                                            </td>
                                            <td class="response">
                                                <div class="spinner-border spinner-border-sm" role="status">
                                                    <span class="visually-hidden">@lang('common.loading')</span>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn text-body dropdown-toggle p-0 fs-5" type="button"
                                                    id="more-{{ $loop->index }}" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="an an-circle-down-arrow"></i>
                                                </button>
                                                <div class="dropdown-menu p-3 dropdown-menu-end"
                                                    aria-labelledby="more-{{ $loop->index }}" style="min-width: 300px">
                                                    <div class="d-flex flex-column gap-3">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <strong>@lang('tools.linkType')</strong>
                                                            {{ $link['internal'] ? __('tools.internal') : __('tools.external') }}
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <strong>@lang('tools.followStatus')</strong>
                                                            @if ($link['nofollow'])
                                                                <span class="text-danger">
                                                                    @lang('tools.noFollow')
                                                                </span>
                                                            @else
                                                                <span class="text-success">
                                                                    @lang('tools.doFollow')
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center mt-3 loader-search" id="loader">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">@lang('common.loading')</span>
                                </div>
                            </div>
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
                    const links = @json(collect($urls['links']->pluck('url')->toArray()));
                    var cursor = 0;
                    const getReslut = async function() {
                            if (links.length == cursor) {
                                return;
                            }
                            const link = links[cursor]
                            await axios.post(
                                    '{{ route('tool.postAction', ['tool' => $tool->slug, 'action' => 'get-status']) }}', {
                                        link,
                                    })
                                .then((res) => {
                                    update(res.data)
                                })
                                .catch((err) => {
                                    resultError()
                                })
                            cursor++
                            if (cursor < links.length) {
                                getReslut()
                            } else {
                                document.getElementById('loader').classList.add('d-none')
                            }
                        },
                        updateProgress = function() {
                            var progress = (parseInt(cursor + 1) / links.length) * 100;
                            progress = Math.round(progress);

                            document.getElementById('conversion-progress').style.width = progress + '%'
                        },
                        initRequest = function() {

                        },
                        resultError = function() {
                            update({
                                status: false,
                                response: '-'
                            })
                        },
                        update = function(res) {
                            updateProgress()
                            const status = document.querySelector(`#link-${cursor} .status`)
                            const response = document.querySelector(`#link-${cursor} .response`)

                            status.innerHTML = typeof res.status !== 'undefined' && res.status == true ?
                                `<span class="text-success"><i class="an an-chack"></i></span>` :
                                `<span class="text-danger"><i class="an an-times"></i></span>`
                            response.innerHTML = `<span class="fw-semibold">${res.response}</span>`
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
