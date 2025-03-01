@if (setting('enable_adblock_detection', 0) == 1)
    <div class="mta-blocked-wrapper mta-blocked-center d-none" id="mta-blocked-wrapper">
        <div class="mta-blocked-content-wrapper">
            <div class="mta-blocked-content">
                <div class="mta-blocked-center">
                    <div class="image-container">
                        <div class="image">
                            <i class="an an-exclamation-triangle"></i>
                            <h3>@lang('common.disableAdblockerLogo')</h3>
                        </div>
                    </div>
                </div>
                <div class="mta-blocked-text">
                    <h3>@lang('common.disableAdblockerHeading')</h3>
                    <p>@lang('common.disableAdblockerDescription')</p>
                </div>
                <div class="d-grid">
                    <button type="button"
                        class="btn btn-danger mta-blocked-button rounded-pill">@lang('common.disableAdblockerButton')</button>
                </div>
            </div>
        </div>
    </div>
@endif
