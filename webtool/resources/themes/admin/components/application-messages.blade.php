<div class="toast-container position-fixed bottom-0 end-0 p-3">
    @if (count($errors) > 0)
        <div class="toast text-white bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">@lang('common.errors')</strong>
                <small>@lang('common.justNow')</small>
                <button type="button" class="btn-close" data-coreui-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                @if (count($errors) > 1)
                    <ul class="mb-0 ps-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @else
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                @endif
            </div>
        </div>
    @endif
    @if (session('success'))
        <div class="toast text-white bg-success" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">@lang('common.success')</strong>
                <small>@lang('common.justNow')</small>
                <button type="button" class="btn-close" data-coreui-dismiss="toast"
                    aria-label="@lang('common.close')"></button>
            </div>
            <div class="toast-body">
                {{ session('success') }}
            </div>
        </div>
    @endif
    @if ($settingsFlash = hasSettingsFlash('success'))
        <div class="toast text-white bg-success" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">@lang('common.success')</strong>
                <small>@lang('common.justNow')</small>
                <button type="button" class="btn-close" data-coreui-dismiss="toast"
                    aria-label="@lang('common.close')"></button>
            </div>
            <div class="toast-body">
                {{ $settingsFlash }}
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="toast text-white bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">@lang('common.error')</strong>
                <small>@lang('common.justNow')</small>
                <button type="button" class="btn-close" data-coreui-dismiss="toast"
                    aria-label="@lang('common.close')"></button>
            </div>
            <div class="toast-body">
                {{ session('error') }}
            </div>
        </div>
    @endif
</div>
