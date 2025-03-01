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
                                <option value="ar_SA"
                                    {{ old('country', $country ?? 'en_US') == 'ar_SA' ? ' selected' : '' }}>
                                    Arabic (Saudi Arabia)</option>
                                <option value="hy_AM"
                                    {{ old('country', $country ?? 'en_US') == 'hy_AM' ? ' selected' : '' }}>
                                    Armenian</option>
                                <option value="az_AZ"
                                    {{ old('country', $country ?? 'en_US') == 'az_AZ' ? ' selected' : '' }}>
                                    Azerbaijani</option>
                                <option value="zh_CN"
                                    {{ old('country', $country ?? 'en_US') == 'zh_CN' ? ' selected' : '' }}>
                                    Chinese (Simplified)</option>
                                <option value="zh_TW"
                                    {{ old('country', $country ?? 'en_US') == 'zh_TW' ? ' selected' : '' }}>
                                    Chinese (Traditional)</option>
                                <option value="hr_HR"
                                    {{ old('country', $country ?? 'en_US') == 'hr_HR' ? ' selected' : '' }}>
                                    Croatian</option>
                                <option value="cs_CZ"
                                    {{ old('country', $country ?? 'en_US') == 'cs_CZ' ? ' selected' : '' }}>Czech
                                </option>
                                <option value="nl_NL"
                                    {{ old('country', $country ?? 'en_US') == 'nl_NL' ? ' selected' : '' }}>Dutch
                                </option>
                                <option value="nl_BE"
                                    {{ old('country', $country ?? 'en_US') == 'nl_BE' ? ' selected' : '' }}>Dutch
                                    (Belgium)</option>
                                <option value="en_US"
                                    {{ old('country', $country ?? 'en_US') == 'en_US' ? ' selected' : '' }}>
                                    English (United States)</option>
                                <option value="en_GB"
                                    {{ old('country', $country ?? 'en_US') == 'en_GB' ? ' selected' : '' }}>
                                    English (Great Britain)</option>
                                <option value="en_AU"
                                    {{ old('country', $country ?? 'en_US') == 'en_AU' ? ' selected' : '' }}>
                                    English (Australia)</option>
                                <option value="en_CA"
                                    {{ old('country', $country ?? 'en_US') == 'en_CA' ? ' selected' : '' }}>
                                    English (Canada)</option>
                                <option value="en_IE"
                                    {{ old('country', $country ?? 'en_US') == 'en_IE' ? ' selected' : '' }}>
                                    English (Ireland)</option>
                                <option value="en_ZA"
                                    {{ old('country', $country ?? 'en_US') == 'en_ZA' ? ' selected' : '' }}>
                                    English (South Africa)</option>
                                <option value="fi_FI"
                                    {{ old('country', $country ?? 'en_US') == 'fi_FI' ? ' selected' : '' }}>
                                    Finnish</option>
                                <option value="fr_FR"
                                    {{ old('country', $country ?? 'en_US') == 'fr_FR' ? ' selected' : '' }}>
                                    French (France)</option>
                                <option value="fr_CA"
                                    {{ old('country', $country ?? 'en_US') == 'fr_CA' ? ' selected' : '' }}>
                                    French (Canada)</option>
                                <option value="fr_CH"
                                    {{ old('country', $country ?? 'en_US') == 'fr_CH' ? ' selected' : '' }}>
                                    French (Switzerland)</option>
                                <option value="ka_GE"
                                    {{ old('country', $country ?? 'en_US') == 'ka_GE' ? ' selected' : '' }}>
                                    Georgian</option>
                                <option value="de_DE"
                                    {{ old('country', $country ?? 'en_US') == 'de_DE' ? ' selected' : '' }}>
                                    German (Germany)</option>
                                <option value="de_AT"
                                    {{ old('country', $country ?? 'en_US') == 'de_AT' ? ' selected' : '' }}>
                                    German (Austria)</option>
                                <option value="de_CH"
                                    {{ old('country', $country ?? 'en_US') == 'de_CH' ? ' selected' : '' }}>
                                    German (Switzerland)</option>
                                <option value="id_ID"
                                    {{ old('country', $country ?? 'en_US') == 'id_ID' ? ' selected' : '' }}>
                                    Indonesian</option>
                                <option value="it_IT"
                                    {{ old('country', $country ?? 'en_US') == 'it_IT' ? ' selected' : '' }}>
                                    Italian</option>
                                <option value="ja_JP"
                                    {{ old('country', $country ?? 'en_US') == 'ja_JP' ? ' selected' : '' }}>
                                    Japanese</option>
                                <option value="ko_KR"
                                    {{ old('country', $country ?? 'en_US') == 'ko_KR' ? ' selected' : '' }}>
                                    Korean</option>
                                <option value="ne_NP"
                                    {{ old('country', $country ?? 'en_US') == 'ne_NP' ? ' selected' : '' }}>
                                    Nepali</option>
                                <option value="nb_NO"
                                    {{ old('country', $country ?? 'en_US') == 'nb_NO' ? ' selected' : '' }}>
                                    Norwegian (Bokmål)</option>
                                <option value="fa_IR"
                                    {{ old('country', $country ?? 'en_US') == 'fa_IR' ? ' selected' : '' }}>
                                    Persian</option>
                                <option value="pl_PL"
                                    {{ old('country', $country ?? 'en_US') == 'pl_PL' ? ' selected' : '' }}>
                                    Polish</option>
                                <option value="pt_BR"
                                    {{ old('country', $country ?? 'en_US') == 'pt_BR' ? ' selected' : '' }}>
                                    Portuguese (Brazil)</option>
                                <option value="pt_PT"
                                    {{ old('country', $country ?? 'en_US') == 'pt_PT' ? ' selected' : '' }}>
                                    Portuguese (Portugal)</option>
                                <option value="ro_RO"
                                    {{ old('country', $country ?? 'en_US') == 'ro_RO' ? ' selected' : '' }}>
                                    Romanian</option>
                                <option value="ru_RU"
                                    {{ old('country', $country ?? 'en_US') == 'ru_RU' ? ' selected' : '' }}>
                                    Russian</option>
                                <option value="sk_SK"
                                    {{ old('country', $country ?? 'en_US') == 'sk_SK' ? ' selected' : '' }}>
                                    Slovak</option>
                                <option value="es_ES"
                                    {{ old('country', $country ?? 'en_US') == 'es_ES' ? ' selected' : '' }}>
                                    Spanish (Spain)</option>
                                <option value="es_MX"
                                    {{ old('country', $country ?? 'en_US') == 'es_MX' ? ' selected' : '' }}>
                                    Spanish (Mexico)</option>
                                <option value="sv_SE"
                                    {{ old('country', $country ?? 'en_US') == 'sv_SE' ? ' selected' : '' }}>
                                    Swedish</option>
                                <option value="tr_TR"
                                    {{ old('country', $country ?? 'en_US') == 'tr_TR' ? ' selected' : '' }}>
                                    Turkish</option>
                                <option value="uk_UA"
                                    {{ old('country', $country ?? 'en_US') == 'uk_UA' ? ' selected' : '' }}>
                                    Ukrainian</option>
                                <option value="vi_VN"
                                    {{ old('country', $country ?? 'en_US') == 'vi_VN' ? ' selected' : '' }}>
                                    Vietnamese</option>
                            </select>
                            <x-input-error :messages="$errors->get('country')" class="mt-2" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <x-input-label>@lang('tools.gender')</x-input-label>
                            <select name="gender" id="gender"
                                class="form-select{{ $errors->has('gender') ? ' is-invalid' : '' }}">
                                <option value="any" {{ isset($gender) && $gender == 'any' ? ' selected' : '' }}>
                                    @lang('tools.random')</option>
                                <option value="male" {{ isset($gender) && $gender == 'male' ? ' selected' : '' }}>
                                    Male</option>
                                <option value="female" {{ isset($gender) && $gender == 'female' ? ' selected' : '' }}>
                                    Female</option>
                            </select>
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <x-input-label>@lang('tools.howMany')</x-input-label>
                            <x-text-input type="number" class="form-control" name="number_of_names"
                                id="number_of_names" :placeholder="__('tools.random')"
                                value="{{ old('number_of_names', $number_of_names ?? 10) }}" :error="$errors->has('number_of_names')"
                                min="1" max="100" required />
                            <x-input-error :messages="$errors->get('number_of_names')" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>
            <x-ad-slot :advertisement="get_advert_model('below-form')" />
            <div class="row mt-4 mb-4">
                <div class="col-md-12 text-end">
                    <x-button type="submit" id="calculate" class="btn btn-outline-primary rounded-pill">
                        @lang('tools.generateRandomNames')
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
                        @foreach ($results['names'] as $name)
                            <div class="col-md-3">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="fw-bold mb-2" id="name-{{ $loop->index }}">
                                            {{ $name }}
                                        </div>
                                        <x-copy-target target="name-{{ $loop->index }}" :text="__('tools.copyText')"
                                            class="btn-sm btn-outline-primary" />
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
