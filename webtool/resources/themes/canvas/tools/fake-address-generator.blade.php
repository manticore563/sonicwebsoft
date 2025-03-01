<x-application-tools-wrapper>
    <x-tool-wrapper :tool="$tool">
        <x-ad-slot :advertisement="get_advert_model('above-form')" />
        <x-form method="post" :route="route('tool.handle', $tool->slug)">
            <div class="box-shadow tabbar mb-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <x-input-label>@lang('tools.stateCounty')</x-input-label>
                            <select name="country" id="country"
                                class="form-select{{ $errors->has('country') ? ' is-invalid' : '' }}">
                                <option value="ar_SA" {{ (isset($selectedLocale) && $selectedLocale == 'ar_SA')? ' selected' : '' }}>Arabic (Saudi Arabia)</option>
                                <option value="hy_AM" {{ (isset($selectedLocale) && $selectedLocale == 'hy_AM')? ' selected' : '' }}>Armenian</option>
                                <option value="az_AZ" {{ (isset($selectedLocale) && $selectedLocale == 'az_AZ')? ' selected' : '' }}>Azerbaijani</option>
                                <option value="zh_CN" {{ (isset($selectedLocale) && $selectedLocale == 'zh_CN')? ' selected' : '' }}>Chinese (Simplified)</option>
                                <option value="zh_TW" {{ (isset($selectedLocale) && $selectedLocale == 'zh_TW')? ' selected' : '' }}>Chinese (Traditional)</option>
                                <option value="hr_HR" {{ (isset($selectedLocale) && $selectedLocale == 'hr_HR')? ' selected' : '' }}>Croatian</option>
                                <option value="cs_CZ" {{ (isset($selectedLocale) && $selectedLocale == 'cs_CZ')? ' selected' : '' }}>Czech</option>
                                <option value="nl_NL" {{ (isset($selectedLocale) && $selectedLocale == 'nl_NL')? ' selected' : '' }}>Dutch</option>
                                <option value="nl_BE" {{ (isset($selectedLocale) && $selectedLocale == 'nl_BE')? ' selected' : '' }}>Dutch (Belgium)</option>
                                <option value="en_US" {{ (isset($selectedLocale) && $selectedLocale == 'en_US')? ' selected' : '' }}>English (United States)</option>
                                <option value="en_GB" {{ (isset($selectedLocale) && $selectedLocale == 'en_GB')? ' selected' : '' }}>English (Great Britain)</option>
                                <option value="en_AU" {{ (isset($selectedLocale) && $selectedLocale == 'en_AU')? ' selected' : '' }}>English (Australia)</option>
                                <option value="en_CA" {{ (isset($selectedLocale) && $selectedLocale == 'en_CA')? ' selected' : '' }}>English (Canada)</option>
                                <option value="en_IE" {{ (isset($selectedLocale) && $selectedLocale == 'en_IE')? ' selected' : '' }}>English (Ireland)</option>
                                <option value="en_ZA" {{ (isset($selectedLocale) && $selectedLocale == 'en_ZA')? ' selected' : '' }}>English (South Africa)</option>
                                <option value="fi_FI" {{ (isset($selectedLocale) && $selectedLocale == 'fi_FI')? ' selected' : '' }}>Finnish</option>
                                <option value="fr_FR" {{ (isset($selectedLocale) && $selectedLocale == 'fr_FR')? ' selected' : '' }}>French (France)</option>
                                <option value="fr_CA" {{ (isset($selectedLocale) && $selectedLocale == 'fr_CA')? ' selected' : '' }}>French (Canada)</option>
                                <option value="fr_CH" {{ (isset($selectedLocale) && $selectedLocale == 'fr_CH')? ' selected' : '' }}>French (Switzerland)</option>
                                <option value="ka_GE" {{ (isset($selectedLocale) && $selectedLocale == 'ka_GE')? ' selected' : '' }}>Georgian</option>
                                <option value="de_DE" {{ (isset($selectedLocale) && $selectedLocale == 'de_DE')? ' selected' : '' }}>German (Germany)</option>
                                <option value="de_AT" {{ (isset($selectedLocale) && $selectedLocale == 'de_AT')? ' selected' : '' }}>German (Austria)</option>
                                <option value="de_CH" {{ (isset($selectedLocale) && $selectedLocale == 'de_CH')? ' selected' : '' }}>German (Switzerland)</option>
                                <option value="id_ID" {{ (isset($selectedLocale) && $selectedLocale == 'id_ID')? ' selected' : '' }}>Indonesian</option>
                                <option value="it_IT" {{ (isset($selectedLocale) && $selectedLocale == 'it_IT')? ' selected' : '' }}>Italian</option>
                                <option value="ja_JP" {{ (isset($selectedLocale) && $selectedLocale == 'ja_JP')? ' selected' : '' }}>Japanese</option>
                                <option value="ko_KR" {{ (isset($selectedLocale) && $selectedLocale == 'ko_KR')? ' selected' : '' }}>Korean</option>
                                <option value="ne_NP" {{ (isset($selectedLocale) && $selectedLocale == 'ne_NP')? ' selected' : '' }}>Nepali</option>
                                <option value="nb_NO" {{ (isset($selectedLocale) && $selectedLocale == 'nb_NO')? ' selected' : '' }}>Norwegian (Bokmål)</option>
                                <option value="fa_IR" {{ (isset($selectedLocale) && $selectedLocale == 'fa_IR')? ' selected' : '' }}>Persian</option>
                                <option value="pl_PL" {{ (isset($selectedLocale) && $selectedLocale == 'pl_PL')? ' selected' : '' }}>Polish</option>
                                <option value="pt_BR" {{ (isset($selectedLocale) && $selectedLocale == 'pt_BR')? ' selected' : '' }}>Portuguese (Brazil)</option>
                                <option value="pt_PT" {{ (isset($selectedLocale) && $selectedLocale == 'pt_PT')? ' selected' : '' }}>Portuguese (Portugal)</option>
                                <option value="ro_RO" {{ (isset($selectedLocale) && $selectedLocale == 'ro_RO')? ' selected' : '' }}>Romanian</option>
                                <option value="ru_RU" {{ (isset($selectedLocale) && $selectedLocale == 'ru_RU')? ' selected' : '' }}>Russian</option>
                                <option value="sk_SK" {{ (isset($selectedLocale) && $selectedLocale == 'sk_SK')? ' selected' : '' }}>Slovak</option>
                                <option value="es_ES" {{ (isset($selectedLocale) && $selectedLocale == 'es_ES')? ' selected' : '' }}>Spanish (Spain)</option>
                                <option value="es_MX" {{ (isset($selectedLocale) && $selectedLocale == 'es_MX')? ' selected' : '' }}>Spanish (Mexico)</option>
                                <option value="sv_SE" {{ (isset($selectedLocale) && $selectedLocale == 'sv_SE')? ' selected' : '' }}>Swedish</option>
                                <option value="tr_TR" {{ (isset($selectedLocale) && $selectedLocale == 'tr_TR')? ' selected' : '' }}>Turkish</option>
                                <option value="uk_UA" {{ (isset($selectedLocale) && $selectedLocale == 'uk_UA')? ' selected' : '' }}>Ukrainian</option>
                                <option value="vi_VN" {{ (isset($selectedLocale) && $selectedLocale == 'vi_VN')? ' selected' : '' }}>Vietnamese</option>
                            </select>
                            <x-input-error :messages="$errors->get('country')" class="mt-2" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <x-input-label>@lang('tools.city')</x-input-label>
                            <x-text-input type="text" class="form-control" name="city" id="city"
                                :placeholder="__('tools.random')" value="{{ $results['city'] ?? old('city') }}" :error="$errors->has('city')" />
                            <x-input-error :messages="$errors->get('city')" class="mt-2" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <x-input-label>@lang('tools.zip')</x-input-label>
                            <x-text-input type="text" class="form-control" name="zipCode" id="zipCode"
                                :placeholder="__('tools.random')" value="{{ $results['zipCode'] ?? old('zipCode') }}"
                                :error="$errors->has('zipCode')" />
                            <x-input-error :messages="$errors->get('zipCode')" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>
            <x-ad-slot :advertisement="get_advert_model('below-form')" />
            <div class="row mt-4 mb-4">
                <div class="col-md-12 text-end">
                    <x-button type="submit" id="calculate" class="btn btn-outline-primary rounded-pill">
                        @lang('tools.generateFakeAddress')
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
                        <div class="col-md-12">
                            <table class="table table-bordered align-middle">
                                <tbody>
                                    <tr>
                                        <th class="table-secondary" scope="row" width="200">@lang('tools.address')</th>
                                        <td id="street_address">
                                            <div class="d-flex align-items-center justify-content-between">
                                                {{ $results['street_address'] }}
                                                <x-copy-target target="street_address"
                                                    class="btn-sm btn-outline-primary" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-secondary" scope="row">@lang('tools.city')</th>
                                        <td id="address_city">
                                            <div class="d-flex align-items-center justify-content-between">
                                                {{ $results['city'] }}
                                                <x-copy-target target="address_city"
                                                    class="btn-sm btn-outline-primary" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-secondary" scope="row">@lang('tools.stateTxt')</th>
                                        <td id="address_state">
                                            <div class="d-flex align-items-center justify-content-between">
                                                {{ $results['state'] }}
                                                <x-copy-target target="address_state"
                                                    class="btn-sm btn-outline-primary" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-secondary" scope="row">@lang('tools.zip')</th>
                                        <td id="address_zipCode">
                                            <div class="d-flex align-items-center justify-content-between">
                                                {{ $results['zipCode'] }}
                                                <x-copy-target target="address_zipCode"
                                                    class="btn-sm btn-outline-primary" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-secondary" scope="row">@lang('tools.country')</th>
                                        <td id="address_country">
                                            <div class="d-flex align-items-center justify-content-between">
                                                {{ $results['country'] }}
                                                <x-copy-target target="address_country"
                                                    class="btn-sm btn-outline-primary" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-secondary" scope="row">@lang('tools.telephone')</th>
                                        <td id="address_telephone">
                                            <div class="d-flex align-items-center justify-content-between">
                                                {{ $results['telephone'] }}
                                                <x-copy-target target="address_telephone"
                                                    class="btn-sm btn-outline-primary" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-secondary" scope="row">@lang('tools.mobile')</th>
                                        <td id="address_mobile">
                                            <div class="d-flex align-items-center justify-content-between">
                                                {{ $results['mobile'] }}
                                                <x-copy-target target="address_mobile"
                                                    class="btn-sm btn-outline-primary" />
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </x-page-wrapper>
        </div>
    @endif
    <x-tool-content :tool="$tool" />
</x-application-tools-wrapper>
