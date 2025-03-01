<x-app-layout>
    <x-manage-filters :search="true" :search-route="route('admin.tools')" order-class="order-2">
        @can('edit tools')
            <div class="row gx-3 gy-2 align-items-center">
                <div class="col-auto">
                    <select name="action" class="form-select" id="action_name">
                        <option value="">{{ __('common.bulkActions') }}</option>
                        <option value="activate">@lang('common.activate')</option>
                        <option value="deactivate">@lang('common.deactivate')</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="button" id="builActions" class="btn btn-primary btn-sm ml-1">@lang('widgets.apply')</button>
                </div>
            </div>
        @endcan
    </x-manage-filters>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">@lang('admin.manageTools')</h6>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-quizier mb-0">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="checkbox_all i-checks" data-target=".id_class"></th>
                                <th width="40">@lang('common.icon')</th>
                                <th>@lang('common.name')</th>
                                <th>@lang('admin.title')</th>
                                <th>@lang('common.views')</th>
                                <th>@lang('common.status')</th>
                                <th width="150">@lang('common.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tools as $tool)
                                <tr>
                                    <td><input type="checkbox" class="id_class i-checks working-{{ $tool->id }}"
                                            name="ids[]" value="{{ $tool->id }}"></td>
                                    <td>
                                        @if ($tool->icon_type == 'class')
                                            <i class="an-duotone an-3x an-{{ $tool->icon_class }}"></i>
                                        @elseif ($tool->getFirstMediaUrl('tool-icon'))
                                            <img src="{{ $tool->getFirstMediaUrl('tool-icon') }}"
                                                alt="{{ $tool->name }}" width="36">
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $tool->name }}</strong>
                                        <p class="mb-0">{{ $tool->category->first()->name ?? '' }}</p>
                                    </td>
                                    <td>{{ $tool->meta_title }}</td>
                                    <td>{{ $tool->views->count() ?? 0 }}</td>
                                    <td>
                                        @if ($tool->status)
                                            <span class="badge bg-success"> @lang('common.active') </span>
                                        @else
                                            <span class="badge bg-danger">@lang('common.inactive')</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content start">
                                            @if ($tool->status == 0)
                                                <a href="{{ route('admin.tools.status.change', ['id' => $tool->id, 'status' => 1]) }}"
                                                    class="btn btn-link text-body" role="button"
                                                    data-coreui-toggle="tooltip" title="@lang('common.activate')"><span
                                                        class="lni lni-checkmark-circle"></span></a>
                                            @else
                                                <a href="{{ route('admin.tools.status.change', ['id' => $tool->id, 'status' => 0]) }}"
                                                    class="btn btn-link text-body" role="button"
                                                    data-coreui-toggle="tooltip" title="@lang('common.deactivate')"><span
                                                        class="lni lni-circle-minus"></span></a>
                                            @endif
                                            @if (!empty($tool->slug))
                                                <a href="{{ route('tool.show', ['tool' => $tool->slug]) }}"
                                                    target="_blank" class="btn btn-link text-body" role="button"
                                                    data-coreui-toggle="tooltip" data-placement="left"
                                                    title="@lang('common.view')"><span class="lni lni-eye"></span></a>
                                            @endif
                                            <a href="{{ route('admin.tools.edit', $tool) }}"
                                                class="btn btn-link text-body" role="button"
                                                data-coreui-toggle="tooltip" title="@lang('common.edit')"><span
                                                    class="lni lni-pencil-alt"></span></a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="22">@lang('common.noRecordsFund')</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($tools->hasPages())
                    <div class="card-footer">
                        {{ $tools->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    @push('page_scripts')
        <script>
            const PageApp = {
                bulkActions: function() {
                    document.getElementById('builActions').addEventListener('click', function(e) {
                        e.preventDefault();
                        var ids = Array.from(document.querySelectorAll('.id_class:checked')).map(function(c) {
                            return c.value;
                        });

                        var action = document.getElementById('action_name').value;
                        var newForm = document.createElement('form');
                        newForm.method = 'post';
                        newForm.action = '{{ route('admin.tools.bulk') }}';

                        var actionInput = document.createElement('input');
                        actionInput.name = 'action';
                        actionInput.value = action;
                        actionInput.type = 'hidden';
                        newForm.appendChild(actionInput);

                        var idsInput = document.createElement('input');
                        idsInput.name = 'ids';
                        idsInput.value = ids;
                        idsInput.type = 'hidden';
                        newForm.appendChild(idsInput);

                        var tokenInput = document.createElement('input');
                        tokenInput.name = '_token';
                        tokenInput.value = '{{ csrf_token() }}';
                        tokenInput.type = 'hidden';
                        newForm.appendChild(tokenInput);

                        document.body.appendChild(newForm);
                        newForm.submit();
                    });
                },
                init: function() {
                    this.bulkActions();
                }
            };
            PageApp.init();
        </script>
    @endpush
</x-app-layout>
