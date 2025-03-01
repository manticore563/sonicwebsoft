<x-canvas-error-page wrapClass="wrap404 error-page ps-0" :has-navbar="false">
    <div class="row">
        <div class="col-md-6 text-center">
            <img class="img-fluid" src="{{ theme_url('themes/minimal/images/error-401.svg') }}" alt="@lang('common.error500Title')">
        </div>
        <div class="col-md-6 d-flex">
            <div class="contant-box align-self-center">
                <h1>@lang('common.error401Title')</h1>
                <p>
                    {{ !empty($exception->getMessage()) ? $exception->getMessage() : __('common.error401Subtitle') }}
                </p>
            </div>
        </div>
    </div>
</x-canvas-error-page>
