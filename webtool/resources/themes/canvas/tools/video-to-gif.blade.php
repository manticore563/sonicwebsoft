<x-application-tools-wrapper>
    <x-tool-wrapper :tool="$tool">
        <x-ad-slot :advertisement="get_advert_model('above-form')" />
        <x-form method="post" :route="route('tool.handle', $tool->slug)" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12 mt-3 mb-3">
                    <x-upload-wrapper max-files="1" max-size="{{ $tool->fs_tool }}" accept=".mp4,.avi,.mov,.wmv"
                        input-name="video" :file-title="__('tools.dropVideoHereTitle')" :file-label="__('tools.convertImageToGif')">
                        <x-slot name="svg">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                xmlns:xlink="http://www.w3.org/1999/xlink" width="128" height="128" x="0" y="0"
                                viewBox="0 0 682.667 682.667" style="enable-background:new 0 0 512 512"
                                xml:space="preserve" class="mb-3">
                                <g>
                                    <defs>
                                        <clipPath id="a" clipPathUnits="userSpaceOnUse">
                                            <path d="M0 512h512V0H0Z" fill="#acafbd" opacity="1"
                                                data-original="#acafbd"></path>
                                        </clipPath>
                                    </defs>
                                    <g clip-path="url(#a)" transform="matrix(1.33333 0 0 -1.33333 0 682.667)">
                                        <path
                                            d="M0 0h-161.134c-22.091 0-40-17.909-40-40v-332c0-22.091 17.909-40 40-40h412c22.092 0 40 17.909 40 40v332c0 22.091-17.908 40-40 40H90"
                                            style="stroke-width:20;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                            transform="translate(211.134 462)" fill="none" stroke="#acafbd"
                                            stroke-width="20" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity=""
                                            data-original="#acafbd" class=""></path>
                                        <path d="M0 0h492"
                                            style="stroke-width:20;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                            transform="translate(10 170)" fill="none" stroke="#acafbd"
                                            stroke-width="20" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity=""
                                            data-original="#acafbd" class=""></path>
                                        <path
                                            d="M0 0c0-11.046-8.954-20-20-20s-20 8.954-20 20 8.954 20 20 20S0 11.046 0 0Z"
                                            style="stroke-width:20;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                            transform="translate(119.924 110)" fill="none" stroke="#acafbd"
                                            stroke-width="20" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity=""
                                            data-original="#acafbd" class=""></path>
                                        <path d="M0 0h249.086"
                                            style="stroke-width:20;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                            transform="translate(182.99 110)" fill="none" stroke="#acafbd"
                                            stroke-width="20" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity=""
                                            data-original="#acafbd" class=""></path>
                                        <path
                                            d="m0 0 52.52-30.323c12.347-7.128 12.347-24.949 0-32.078L0-92.723c-12.347-7.129-27.78 1.782-27.78 16.039v60.645C-27.78-1.782-12.347 7.129 0 0Z"
                                            style="stroke-width:20;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                            transform="translate(242.665 362.362)" fill="none" stroke="#acafbd"
                                            stroke-width="20" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity=""
                                            data-original="#acafbd" class=""></path>
                                        <path d="M0 0v0"
                                            style="stroke-width:20;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                            transform="translate(256.127 462)" fill="none" stroke="#acafbd"
                                            stroke-width="20" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity=""
                                            data-original="#acafbd"></path>
                                    </g>
                                </g>
                            </svg>
                        </x-slot>
                    </x-upload-wrapper>
                    <x-input-error :messages="$errors->get('file')" class="mt-2" />
                </div>
            </div>
            <x-ad-slot :advertisement="get_advert_model('below-form')" />
            <div class="row">
                <div class="col-md-12 text-end">
                    <x-button type="submit" class="btn btn-outline-primary rounded-pill">
                        @lang('tools.convertToGif')
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
                    <div class="col-md-12" id="processing-files">
                        <div class="d-flex align-items-center justify-content-center my-4">
                            <div class="spinner-border" role="status"></div>
                        </div>
                    </div>
                    <div class="col-md-12 text-end">
                        <x-form class="d-none download-all-btn no-app-loader d-inline-block" metho="post"
                            :route="route('tool.postAction', ['tool' => $tool->slug, 'action' => 'download-all'])">
                            <input type="hidden" name="process_id" value="{{ $results['process_id'] }}">
                            <x-download-form-button :text="__('tools.downloadAll')" />
                        </x-form>
                        <x-reload-button :link="route('tool.show', ['tool' => $tool->slug])" />
                    </div>
                </div>
            </x-page-wrapper>
        </div>
        <x-ad-slot :advertisement="get_advert_model('below-result')" />
    @endif
    <x-tool-content :tool="$tool" />
    @if (isset($results))
        @push('page_scripts')
            <script>
                const APP = function() {
                    let processed = 0;
                    const process_id = '{{ $results['process_id'] }}',
                        data = @json($results['file']),
                        route = '{{ route('tool.postAction', ['tool' => $tool->slug, 'action' => 'process-file']) }}',
                        element = document.querySelector('#processing-files'),
                        attachEvents = function(cursor) {
                            document.querySelector('#download-file-btn').addEventListener('click', e => {
                                ArtisanApp.downloadFromUrl(e.target.dataset.url, e.target.dataset.filename)
                            })
                        },
                        startConversion = async function(file) {
                                await axios.post(route, {
                                    process_id: process_id,
                                    file: file.original_filename
                                }).then(resp => {
                                    if(resp.data.status === true) {
                                        showDownload(resp.data)
                                    } else {
                                        throw new Error(resp.data.message || '{{ __('common.somethingWentWrong') }}');
                                    }
                                }).catch(err => {
                                    element.innerHTML = `<div class="alert alert-danger">${err.message}</div>`;;
                                    ArtisanApp.toastError(err.message)
                                })
                            },
                            showDownload = function(data) {
                                const html = data.status? `<div class="row">
                                        <div class="col-md-6">
                                            <img src="${data.url}" class="img-fluid" alt="${data.filename}" />
                                        </div>
                                        <div class="col-md-6 d-flex align-items-center justify-content-center">
                                            <div class="file-info text-center">
                                                <p class="fw-semibold">${data.filename}</p>
                                                <p>${data.filesize.filesize(true)}</p>
                                                <button class="btn btn-outline-primary rounded-pill px-4" type="button" id="download-file-btn" data-url="${data.url}" data-filename="${data.filename}">
                                                    {{ __('common.download') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>` : `<div class="alert alert-danger">${data.message}</div>`;

                                element.innerHTML = html;
                                attachEvents()
                            };

                    return {
                        init: function() {
                            startConversion(data)
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
