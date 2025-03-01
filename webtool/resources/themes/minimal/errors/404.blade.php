<x-canvas-error-page wrap-class="wrap404 error-page">
    <div class="row">
        <div class="col-md-4">
            <div class="glitch" title="404">404</div>
        </div>
        <div class="col-md-8">
            <div class="contant-box">
                <h1>@lang('common.error404Title')</h1>
                <p>
                    {{ !empty($exception->getMessage()) ? $exception->getMessage() : __('common.error404Subtitle') }}
                </p>
                <div class="buttons-col">
                    <div class="action-link-wrap">
                        <a href="{{ route('front.index') }}" class="btn btn-primary">@lang('common.goBackToHome')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-canvas-error-page>
