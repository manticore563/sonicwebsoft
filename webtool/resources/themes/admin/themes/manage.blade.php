<x-app-layout>
    <div class="row">
        <div class="col-md-12 mb-3">
            <span class="h4 mb-0">@lang('admin.themes')</span>
            <button type="button" data-coreui-toggle="collapse" data-coreui-target="#installTheme" aria-expanded="false"
                aria-controls="installTheme" class="btn btn--squar btn-secondary ml-auto">@lang('admin.uploadTheme')</button>
        </div>
        <div class="col-lg-12">
            <div class="collapse my-5" id="installTheme">
                <p class="text-center h5 mb-4">
                    @lang('admin.themeInZipFormatUpload')
                </p>
                <div class="d-flex justify-content-center">
                    <div class="card" style="min-width:25rem;">
                        <div class="card-body">
                            <form class="" action="{{ route('admin.theme.install') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="theme" id="fileTheme">
                                        <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">@lang('admin.installNow')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach ($themes as $index => $theme)
            <div class="col-md-4">
                <div
                    class="card theme-card @if ($theme->name === config('artisan.front_theme')) text-white bg-dark active-theme @else bg-light @endif">
                    @if ($theme->settings['screenshot'])
                        <img class="card-img-top" src="{{ asset($theme->settings['screenshot']) ?? '' }}"
                            alt="{{ $theme->settings['title'] ?? __('common.noTitle') }}">
                    @endif
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div
                                class="card-title align-self-center mb-0 btn @if ($theme->name === config('artisan.front_theme')) text-white @else text-dark @endif">
                                @if ($theme->name === config('artisan.front_theme'))
                                    <strong>{{ __('common.active') }}:</strong>
                                @endif
                                {{ $theme->settings['title'] ?? __('common.noTitle') }}
                                <span class="small">v{{ $theme->settings['version'] ?? '1.0.0' }}</span>
                            </div>
                            <div class="card-buttons float-right">
                                @if ($theme->name === config('artisan.front_theme'))
                                    <a href="{{ route('admin.settings') }}#themeOptions"
                                        class="btn btn-sm btn-primary">@lang('settings.themeOptions')</a>
                                @else
                                    <a href="{{ route('admin.themes.activate', $theme->name) }}"
                                        class="btn btn-sm btn-secondary">@lang('admin.activate')</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
