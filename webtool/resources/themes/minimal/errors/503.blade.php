<x-canvas-error-page wrapClass="wrap404 bg-white error-page vh-100 ps-0" :has-navbar="false">
    <div class="row">
        <div class="col-md-6 text-center">
            <img class="img-fluid" src="{{ theme_url('/themes/minimal/images/error-503.svg') }}" alt="@lang('common.error500Title')">
        </div>
        <div class="col-md-6 d-flex">
            <div class="contant-box align-self-center">
                <h1>@lang('common.error503Title')</h1>
                <p>
                    {{ !empty($exception->getMessage()) ? $exception->getMessage() : __('common.error503Subtitle') }}
                </p>
            </div>
        </div>
    </div>
</x-canvas-error-page>
