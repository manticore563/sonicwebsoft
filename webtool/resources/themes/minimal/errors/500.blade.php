<x-canvas-error-page wrapClass="wrap404 bg-white error-page vh-100 ps-0" :has-navbar="false">
    <div class="row">
        <div class="col-md-6 text-center">
            <img src="{{ theme_url('/themes/minimal/images/error-500.svg') }}" alt="@lang('common.error500Title')">
        </div>
        <div class="col-md-6 d-flex">
            <div class="contant-box align-self-center">
                <h1>@lang('common.error500Title')</h1>
                <p>
                    {{ !empty($exception->getMessage()) ? $exception->getMessage() : __('common.error500Subtitle') }}
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
