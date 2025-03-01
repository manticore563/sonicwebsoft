<x-tool-home-layout>
    {!! $tool->index_content !!}
    @if (setting('display_plan_homepage', 1) == 1)
        <x-plans-tools :plans="$plans ?? null" :properties="$properties" />
    @endif
    @if (setting('display_faq_homepage', 1) == 1)
        <x-faqs-tools :faqs="$faqs" />
    @endif
    <x-relevant-tools :relevant_tools=$relevant_tools />
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
</x-tool-home-layout>
