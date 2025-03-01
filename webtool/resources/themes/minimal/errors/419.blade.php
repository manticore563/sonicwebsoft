<x-canvas-error-page wrapClass="wrap401 bg-white error-page vh-100" :has-navbar="false">
    <div class="row">
        <div class="col-md-6 text-center">
            <img src="{{ url('/themes/minimal/images/error-419.svg') }}" alt="@lang('common.error419Title')">
        </div>
        <div class="col-md-6 d-flex align-items-center mt-sm-4">
            <div class="contant-box">
                <h1>@lang('common.error419Title')</h1>
                <p>
                    {{ __('common.error419Subtitle') }}
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
