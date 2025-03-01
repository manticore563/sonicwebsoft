@if (Breadcrumbs::exists())
    <nav class="breadcrumbs" aria-label="breadcrumb">
        {{ Breadcrumbs::render() }}
    </nav>
@endif
