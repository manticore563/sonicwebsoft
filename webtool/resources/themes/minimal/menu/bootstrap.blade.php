<!-- <div class="nav-wrap"> -->
@if (!isset($innerLoop))
    <ul class="artisan-nav nav nav-menu mb-auto">
        <x-application-search />
    @else
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
@endif

@foreach ($items as $item)
    @php
        $originalItem = $item;

        $listItemClass = null;
        $linkAttributes = null;
        $styles = null;
        $icon = null;

        // Background Color or Color
        if (isset($options->color) && $options->color == true) {
            $styles = 'color:' . $item->color;
        }
        if (isset($options->background) && $options->background == true) {
            $styles = 'background-color:' . $item->color;
        }

        // With child Attributes
        if (isset($originalItem->child) && !$originalItem->child->isEmpty()) {
            if ($item->active) {
                $linkAttributes = 'class="nav-link dropdown-toggle active" data-bs-toggle="dropdown"';
            } else {
                $linkAttributes = 'class="nav-link dropdown-toggle" data-bs-toggle="dropdown"';
            }
            $listItemClass = 'nav-item dropdown';
        } else {
            $listItemClass = 'nav-item';

            if ($item->active) {
                $linkAttributes = 'class="nav-link active"';
            } else {
                $linkAttributes = 'class="nav-link"';
            }

            if (isset($innerLoop)) {
                $listItemClass = '';
                if ($item->active) {
                    $linkAttributes = 'class="dropdown-item active"';
                } else {
                    $linkAttributes = 'class="dropdown-item"';
                }
            }
        }

        // Set Icon
        if (isset($options->icon) && $options->icon == true && !empty($item->icon_class)) {
            if (Str::contains($item->icon_class, '<svg')) {
                $icon = "{$item->icon_class}";
            } else {
                $icon = '<i class="' . $item->icon_class . '"></i>';
            }
        }
    @endphp
    <li class="{{ $listItemClass }}">
        <a href="{{ $item->href }}" target="{{ $item->target }}" style="{{ $styles }}" {!! $linkAttributes ?? '' !!}>
            {!! $icon !!}
            {{ $item->label }}
        </a>
        @if (isset($originalItem->child) && !$originalItem->child->isEmpty())
            @include('menu.bootstrap', [
                'items' => $originalItem->child,
                'options' => $options,
                'innerLoop' => true,
            ])
        @endif
    </li>
@endforeach
@if (!isset($innerLoop))
    <x-favorite-navbar />
@endif
</ul>
@if (!isset($innerLoop))
    @guest
        <ul class="artisan-nav nav nav-menu">
            @if (Route::has('login'))
                <li class="nav-item nav-btn">
                    <a href="{{ route('login') }}" class="login-modal btn btn-primary">@lang('auth.login')</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item nav-btn">
                        <a href="{{ route('register') }}" class="btn btn-outline-primary">@lang('auth.register')</a>
                    </li>
                @endif
            @endif
        </ul>
    @endguest
    @auth
        <div class="btn-group dropup nav-actions">
            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" data-bs-offset="50,50"
                aria-expanded="false">
                {{ auth()->user()->name }}
            </button>
            <ul class="dropdown-menu">
                @auth
                    @if (!isset($innerLoop))
                        <li><a class="dropdown-item" href="{{ route('user.profile') }}">{{ __('profile.profile') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('user.password') }}">{{ __('common.changePassword') }}</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item signoutBtn" role="button">{{ __('auth.signout') }}</a></li>
                    @endif
                @endauth
            </ul>
        </div>
    @endauth
@endif
