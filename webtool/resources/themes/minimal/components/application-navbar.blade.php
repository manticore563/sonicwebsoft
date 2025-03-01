<nav class="navbar navbar-expand-lg top-navbar">
    <div class="logo-wrap">
        <a class="navbar-brand" href="{{ route('front.index') }}">
            <x-application-logo />
        </a>
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#applicationMainMenu"
        aria-controls="applicationMainMenu" aria-expanded="false" aria-label="@lang('common.toggleNavigation')">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse flex-column" id="applicationMainMenu">
        {!! menu(setting('_main_menu', 'Main Menu'), 'bootstrap', ['icon' => true]) !!}
    </div>
</nav>
