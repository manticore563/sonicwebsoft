<x-canvas-guest-layout>
    <x-auth-card>
        <x-slot name="text">
            <h1>@lang('auth.welcome_back')</h1>
            <p>@lang('auth.welcome_back_desc')</p>
            <a href="{{ route('register') }}" class="btn btn-secondary">@lang('auth.register')</a>
        </x-slot>
        <div class="navbar-brand mb-3">
            <a href="{{ route('front.index') }}">
                <x-application-logo />
            </a>
        </div>
        <h1>@lang('auth.login')</h1>
        <x-application-social-auth />
        <p>@lang('auth.signInToYourAccount')</p>
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <x-text-input id="email" type="email" name="email" :value="old('email')" required
                    placeholder="{{ __('auth.email') }}" :error="$errors->has('email')" autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div class="mb-3">
                <x-text-input id="password" type="password" name="password" required :error="$errors->has('password')"
                    autocomplete="current-password" placeholder="{{ __('auth.password') }}" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div class="d-flex justify-content-between mb-3">
                <label for="remember_me" class="d-inline-flex items-align-center">
                    <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
                    <span class="ms-2 small">{{ __('Remember me') }}</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="small" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
            <div class="d-grid gap-2">
                <x-primary-button>
                    {{ __('auth.login') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-canvas-guest-layout>
