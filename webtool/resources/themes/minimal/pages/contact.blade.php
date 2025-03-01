<x-application-no-widget-wrapper>
    <x-page-wrapper :title="trans('contact.contactUs')" heading="h1">
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{ route('contact.send') }}">
                    @csrf

                    <div class="form-group mb-3">
                        <label class="form-label" for="email">{{ trans('contact.attributes.email') }}</label>
                        <input type="text" name="email"
                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email"
                            value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('subject') ? 'has-error' : '' }} mb-3">
                        <label for="subject" class="form-label">{{ trans('contact.attributes.subject') }}</label>
                        <input type="text" name="subject"
                            class="form-control{{ $errors->has('subject') ? ' is-invalid' : '' }}" id="subject"
                            value="{{ old('subject') }}">
                        @if ($errors->has('subject'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('subject') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="message" class="form-label">{{ trans('contact.attributes.message') }}</label>
                        <textarea name="message" rows="7" id="message"
                            class="form-control{{ $errors->has('message') ? ' is-invalid' : '' }}">{{ old('message') }}</textarea>
                        @if ($errors->has('message'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('message') }}</strong>
                            </span>
                        @endif
                    </div>

                    @if (setting('recaptcha_status', 0) && setting('recaptcha_contact', 0))
                        <div class="form-group mb-3">
                            <div class="g-recaptcha{{ $errors->has('captcha') ? ' is-invalid' : '' }}"
                                data-sitekey="{{ setting('recaptcha_site') }}"></div>
                            @if ($errors->has('captcha'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('captcha') }}</strong>
                                </span>
                            @endif
                        </div>
                    @endif

                    <button type="submit" class="btn btn-primary btn-submit mb-3" data-loading>
                        {{ trans('contact.submit') }}
                    </button>
                </form>
            </div>
        </div>
        <x-ad-slot />
    </x-page-wrapper>
    @push('page_scripts')
    @endpush
</x-application-no-widget-wrapper>
