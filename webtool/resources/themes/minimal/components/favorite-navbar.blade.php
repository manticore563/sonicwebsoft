@php
    $favourites = Auth::check() ? Auth::user()->favorite_tools : null;
@endphp
@if ($favourites && $favourites->count() > 0)
    <li class="nav-item">
        <div id="favMenu" class="fav-menu">
            <div class="nav-link fav-btn" data-bs-toggle="dropdown">
                <i class="an an-grid-layouts"></i>
                <span>@lang('tools.favoriteTools')</span>
            </div>
            <div id="favrorite-tools" class="menu-items p-0 dropdown-menu">
                <ul class="icons-container">
                    @foreach ($favourites as $tool)
                    <li>
                        <a href="{{ route('tool.show', ['tool' => $tool->slug]) }}" class="menu-link bg-hover"
                             title="{{ $tool->name }}">
                            @if ($tool->icon_type == 'class')
                                <i class="an-duotone an-{{ $tool->icon_class }}"></i>
                            @elseif ($tool->getFirstMediaUrl('tool-icon'))
                                <img src="{{ $tool->getFirstMediaUrl('tool-icon') }}" alt="{{ $tool->name }}">
                            @endif
                            <span>{{ $tool->name }}</span>
                        </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </li>
@endif
