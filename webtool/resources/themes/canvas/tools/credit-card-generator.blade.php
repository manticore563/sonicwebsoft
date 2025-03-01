<x-application-tools-wrapper>
    <x-tool-wrapper :tool="$tool">
        <x-ad-slot :advertisement="get_advert_model('above-form')" />
        <x-form method="post" :route="route('tool.handle', $tool->slug)">
            <div class="box-shadow tabbar mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <x-input-label>@lang('tools.cardType')</x-input-label>
                            <select name="card_type" id="card_type"
                                class="form-select{{ $errors->has('card_type') ? ' is-invalid' : '' }}">
                                <option value="random">@lang('tools.random')</option>
                                <option value="visa">Visa</option>
                                <option value="mastercard">Mastercard</option>
                                <option value="ae">American Express</option>
                                <option value="discover">Discover</option>
                                <option value="jcb">JCB</option>
                            </select>
                            <x-input-error :messages="$errors->get('card_type')" class="mt-2" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <x-input-label>@lang('tools.expMonth')</x-input-label>
                            <select name="exp_month" id="exp_month"
                                class="form-select{{ $errors->has('exp_month') ? ' is-invalid' : '' }}">
                                <option value="random">@lang('tools.random')</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            <x-input-error :messages="$errors->get('exp_month')" class="mt-2" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <x-input-label>@lang('tools.expYear')</x-input-label>
                            <select name="exp_year" id="exp_year"
                                class="form-select{{ $errors->has('exp_year') ? ' is-invalid' : '' }}">
                                <option value="random">@lang('tools.random')</option>
                                @php
                                    $currentYear = now()->year;
                                @endphp
                                @for ($year = $currentYear - 1; $year < $currentYear + 9; $year++)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>
                            <x-input-error :messages="$errors->get('exp_year')" class="mt-2" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <x-input-label>@lang('tools.cvvCvv2')</x-input-label>
                            <x-text-input type="number" class="form-control" name="cvv" id="cvv"
                                :placeholder="__('tools.random')" value="{{ $results['cvv'] ?? old('cvv') }}" :error="$errors->has('cvv')" />
                            <x-input-error :messages="$errors->get('cvv')" class="mt-2" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <x-input-label>@lang('tools.quantity')</x-input-label>
                            <select name="quantity" id="quantity"
                                class="form-select{{ $errors->has('quantity') ? ' is-invalid' : '' }}">
                                <option value="random">@lang('tools.random')</option>
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="25">25</option>
                                <option value="30">30</option>
                                <option value="35">35</option>
                                <option value="40">40</option>
                                <option value="45">45</option>
                                <option value="50">50</option>
                            </select>
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>
            <x-ad-slot :advertisement="get_advert_model('below-form')" />
            <div class="row mt-4 mb-4">
                <div class="col-md-12 text-end">
                    <x-button type="submit" id="calculate" class="btn btn-outline-primary rounded-pill">
                        @lang('tools.generate')
                    </x-button>
                </div>
            </div>
        </x-form>
    </x-tool-wrapper>
    @if (isset($results))
        <div class="tool-results-wrapper">
            <x-ad-slot :advertisement="get_advert_model('above-result')" />
            <x-page-wrapper :title="__('common.result')">
                <div class="result mt-4">
                    <div class="row">
                        @foreach ($results as $card)
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <div class="card-title fw-bold">@lang('tools.cardCount', ['number' => $loop->iteration])</div>
                                        <div class="card-image">
                                            <img src="{{ $card['image'] }}" class="img-flud" height="32"
                                                onerror="this.remove()" alt="Card Type" title="{{ $card['card_type'] }}" data-bs-toggle="tooltip" data-bs-placement="top">
                                        </div>
                                    </div>
                                    <div class="card-body" id="card-content-{{ $loop->iteration }}">
                                        <div class="row cc_item">
                                            <div class="col-md-5 fw-semibold">@lang('tools.cardNumber')</div>
                                            <div class="col-md-7">{{ $card['card_number'] }}</div>
                                        </div>
                                        <hr>
                                        <div class="row cc_item">
                                            <div class="col-md-5 fw-semibold">@lang('tools.holderName'):</div>
                                            <div class="col-md-7">{{ $card['holder_name'] }}</div>
                                        </div>
                                        <hr>
                                        <div class="row cc_item">
                                            <div class="col-md-5 fw-semibold">@lang('tools.cvvCvv2'):</div>
                                            <div class="col-md-7">{{ $card['cvv'] }}</div>
                                        </div>
                                        <hr>
                                        <div class="row cc_item">
                                            <div class="col-md-5 fw-semibold">@lang('tools.cardExpiry'):</div>
                                            <div class="col-md-7">
                                                {{ $card['exp_month'] . '/' . $card['exp_year'] }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <x-copy-target target="card-content-{{ $loop->iteration }}"
                                            :text="__('common.copyToClipboard')" />
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-page-wrapper>
        </div>
    @endif
    <x-tool-content :tool="$tool" />
</x-application-tools-wrapper>
