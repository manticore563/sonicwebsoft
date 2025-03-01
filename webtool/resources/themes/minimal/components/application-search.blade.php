@if (theme_option('enable_search_in_header', 0))
    <li class="nav-item mt-3 mb-2 border-0">
        <div class="search-wrap px-2 header-search-nav">
            <form role="search">
                <input class="form-control" id="toolsAutocomplete" type="search" placeholder="@lang('tools.searchFieldPlaceholder')"
                    dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" autocapitalize="off"
                    maxlength="2048" tabindex="1" aria-label="@lang('common.search')">
            </form>
        </div>
    </li>
@endif
