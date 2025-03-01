<x-application-tools-wrapper>
    <x-tool-wrapper :tool="$tool">
        <x-ad-slot :advertisement="get_advert_model('above-form')" />
        <x-form method="post" :route="route('tool.handle', $tool->slug)">
            <div class="tabbar">
                <div class="row">
                    <div class="col-md-12">
                        <h3>@lang('tools.birthDate')</h3>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-input-label>@lang('tools.year')</x-input-label>
                            <select name="birth_year" id="year" required class="form-control form-select"></select>
                        </div>
                        <x-input-error :messages="$errors->get('birth_year')" class="mt-2" />
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-input-label>@lang('tools.month')</x-input-label>
                            <select name="birth_month" id="month" required
                                class="form-control form-select"></select>
                        </div>
                        <x-input-error :messages="$errors->get('birth_month')" class="mt-2" />
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-input-label>@lang('tools.day')</x-input-label>
                            <select name="birth_day" id="day" required class="form-control form-select"></select>
                        </div>
                        <x-input-error :messages="$errors->get('birth_day')" class="mt-2" />
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <h3>@lang('tools.dateFrom')</h3>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <x-input-label>@lang('tools.year')</x-input-label>
                            <select name="from_year" id="from_year" required class="form-control form-select"></select>
                        </div>
                        <x-input-error :messages="$errors->get('from_year')" class="mt-2" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <x-input-label>@lang('tools.month')</x-input-label>
                            <select name="from_month" id="from_month" required
                                class="form-control form-select"></select>
                        </div>
                        <x-input-error :messages="$errors->get('from_month')" class="mt-2" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <x-input-label>@lang('tools.day')</x-input-label>
                            <select name="from_day" id="from_day" required class="form-control form-select"></select>
                        </div>
                        <x-input-error :messages="$errors->get('from_day')" class="mt-2" />
                    </div>
                </div>
            </div>
            <x-ad-slot :advertisement="get_advert_model('below-form')" />
            <div class="row">
                <div class="col-md-12 text-end">
                    <x-button type="button" id="calculateAge" class="btn btn-primary">
                        @lang('tools.calculateAge')
                    </x-button>
                </div>
            </div>
        </x-form>
    </x-tool-wrapper>
    <x-page-wrapper :title="__('common.result')" class="tool-age-calculator-results tool-results-wrapper d-none">
        <div class="result mt-4">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="h2 mb-4" id="add_in_years"></h3>
                </div>
                <div class="col-md-12 result-printable">
                    <table class="table table-style mb-0">
                        <tbody>
                            <tr>
                                <th>@lang('tools.currentAge')</th>
                                <td>
                                    <div class="text-break" id="age"></div>
                                </td>
                                <td class="d-print-none">
                                    <x-copy-target target="age" />
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('tools.ageInMonths')</th>
                                <td>
                                    <div class="text-break" id="age_months"></div>
                                </td>
                                <td class="d-print-none">
                                    <x-copy-target target="age_months" />
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('tools.ageInWeeks')</th>
                                <td>
                                    <div class="text-break" id="age_weeks"></div>
                                </td>
                                <td class="d-print-none">
                                    <x-copy-target target="age_weeks" />
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('tools.ageInDays')</th>
                                <td>
                                    <div class="text-break" id="age_days"></div>
                                </td>
                                <td class="d-print-none">
                                    <x-copy-target target="age_days" />
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('tools.ageInHours')</th>
                                <td>
                                    <div class="text-break" id="age_hours"></div>
                                </td>
                                <td class="d-print-none">
                                    <x-copy-target target="age_hours" />
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('tools.ageInMin')</th>
                                <td>
                                    <div class="text-break" id="age_min"></div>
                                </td>
                                <td class="d-print-none">
                                    <x-copy-target target="age_min" />
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('tools.ageInSec')</th>
                                <td>
                                    <div class="text-break" id="age_sec"></div>
                                </td>
                                <td class="d-print-none">
                                    <x-copy-target target="age_sec" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 text-end d-print-none">
                    <x-print-button
                        onclick="ArtisanApp.printResult(document.querySelector('.result-printable'), {title: '{{ $tool->name }}'})"
                        :text="__('tools.printResult')" />
                </div>
            </div>
        </div>
    </x-page-wrapper>
    <x-ad-slot :advertisement="get_advert_model('below-result')" />
    <x-tool-content :tool="$tool" />
    @push('page_scripts')
        <script>
            const APP = function() {
                const monthNumbers = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
                const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September",
                    "October", "November", "December"
                ];
                const year = function() {
                        let year_satart = 1940;
                        let year_end = (new Date).getFullYear();
                        let year_selected = 1992;

                        let option = '';
                        option = '';

                        for (let i = year_satart; i < year_end; i++) {
                            option += '<option value="' + i + '">' + i + '</option>';
                        }
                        option += '<option selected value="' + year_end + '">' + year_end + '</option>'

                        document.getElementById("year").innerHTML = option;
                        document.getElementById("from_year").innerHTML = option;
                    },
                    day = function() {
                        let day_selected = (new Date).getDate();
                        let option = '';
                        for (let i = 1; i < 32; i++) {
                            let day = (i <= 9) ? '0' + i : i;
                            let selected = (i === day_selected ? ' selected' : '');
                            option += '<option value="' + day + '"' + selected + '>' + day + '</option>';
                        }
                        document.getElementById("day").innerHTML = option;
                        document.getElementById("from_day").innerHTML = option;
                    },
                    month = function() {
                        var month_selected = (new Date).getMonth();
                        var option = '';
                        for (let i = 0; i < months.length; i++) {
                            let month_number = (i + 1);
                            let month = (month_number <= 9) ? '0' + month_number : month_number;
                            let selected = (i === month_selected ? ' selected' : '');
                            option += '<option value="' + month + '"' + selected + '>' + months[i] + '</option>';
                        }

                        document.getElementById("month").innerHTML = option;
                        document.getElementById("from_month").innerHTML = option;
                    },
                    caclulateAge = function() {
                        var d1 = parseInt(document.getElementById("day").value);
                        var m1 = parseInt(document.getElementById("month").value);
                        var y1 = parseInt(document.getElementById("year").value);
                        var date = new Date();
                        var d2 = parseInt(document.getElementById("from_day").value);
                        var m2 = parseInt(document.getElementById("from_month").value);
                        var y2 = parseInt(document.getElementById("from_year").value);
                        if (y1 > y2) {
                            ArtisanApp.toastError('{{ __('tools.AgeCalcGreaterError') }}');
                            return;
                        }
                        if (y1 == y2) {
                            if (m1 > m2) {
                                ArtisanApp.toastError('{{ __('tools.AgeCalcGreaterError') }}');
                                return;
                            } else if (d1 > d2) {
                                ArtisanApp.toastError('{{ __('tools.AgeCalcGreaterError') }}');
                                return;
                            }
                        }

                        document.querySelector('.tool-age-calculator-results').classList.remove('d-none')

                        if (d1 > d2) {
                            d2 = d2 + monthNumbers[m2 - 1];
                            m2 = m2 - 1;
                        }
                        if (d1 > d2) {
                            d2 = d2 + month[m2 - 1];
                            m2 = m2 - 1;
                        }
                        const d = d2 - d1;
                        var m = 0;
                        const new_year_2 = y2;

                        if (m1 > m2) {
                            m = (12 - m1) + m2;
                            y2 = y2 - 1
                        } else {
                            m = m2 - m1;
                        }
                        const y = y2 - y1;
                        var age_month = (y * 12) + m;
                        var new_date_1 = m1 + "/" + d1 + "/" + y1;
                        var new_date_2 = m2 + "/" + d2 + "/" + new_year_2;
                        let date_1 = new Date(new_date_1);
                        let date_2 = new Date(new_date_2);
                        var date_diff = date_2.getTime() - date_1.getTime();
                        var age_sec = (date_diff) / 1000;
                        var age_days = date_diff / (1000 * 3600 * 24);
                        var age_hours = (date_diff / 3600000);
                        var age_week = (date_diff) / (1000 * 60 * 60 * 24 * 7);
                        var age_min = (date_diff / 60000);

                        document.getElementById("age").innerHTML = "{{ __('tools.yourAgeYMD') }}".format(y, m, d);
                        document.getElementById("add_in_years").innerHTML = "{{ __('tools.yourAgeY') }}".format(y);
                        document.getElementById("age_months").innerHTML = "{{ __('tools.yourAgeMD') }}".format(
                            age_month, d);
                        document.getElementById("age_weeks").innerHTML = "{{ __('tools.yourAgeW') }}".format(Math.floor(
                            age_week, 0));
                        document.getElementById("age_days").innerHTML = "{{ __('tools.yourAgeD') }}".format(age_days);
                        document.getElementById("age_hours").innerHTML = "{{ __('tools.yourAgeH') }}".format(age_hours);
                        document.getElementById("age_min").innerHTML = "{{ __('tools.yourAgeM') }}".format(age_min);
                        document.getElementById("age_sec").innerHTML = "{{ __('tools.yourAgeS') }}".format(age_sec);

                        ArtisanApp.scrollToResults()
                    };

                return {
                    init: function() {
                        year();
                        day();
                        month();
                        document.getElementById('calculateAge').addEventListener('click', () => {
                            caclulateAge();
                        })
                    }
                }
            }();

            document.addEventListener("DOMContentLoaded", function(event) {
                APP.init();
            });
        </script>
    @endpush
</x-application-tools-wrapper>
