<x-application-no-widget-wrapper>
    <x-page-wrapper>
        <div class="hero-title center mb-5 mt-5">
            <h1>@lang('tools.checkoutTitle')</h1>
        </div>
        <x-form method="post" :route="route('payments.process')" id="process-form">
            <input type="hidden" name="plan_id" value="{{ $plan_id }}" required>
            <input type="hidden" name="type" value="{{ $type }}" required>
            <input type="hidden" name="price" value="{{ $price }}" required>
            <div class="row">
                <div class="col-md-4 order-md-2 mb-4">
                    <div class="row mb-4" id="gatewayview-div"></div>
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">@lang('tools.orderSummary')</span>
                    </h4>
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">{{ $plan->name }}</h6>
                                <small class="text-muted">{{ $plan->description }}</small>
                            </div>
                            <span class="text-muted">
                                <x-money amount="{{ $price ?? 0 }}" currency="{{ setting('currency', 'usd') }}"
                                    convert /> / {{ $type }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-bold">@lang('common.total')</span>
                            <strong><x-money amount="{{ $price ?? 0 }}" currency="{{ setting('currency', 'usd') }}"
                                    convert /></strong>
                        </li>
                    </ul>
                    <hr class="mb-4">
                    <button class="btn btn-primary btn-lg btn-block w-100 mb-4" type="submit"
                        id="complete-purchase">@lang('tools.completePurchase')</button>
                </div>
                <div class="col-md-8 order-md-1">
                    <h4 class="mb-3">@lang('tools.paymentMethods')</h4>
                    <div class="row">
                        @foreach ($gateways as $key => $gateway)
                            <div class="col-md-6">
                                <div class="custom-radio-checkbox">
                                    <label class="radio-checkbox-wrapper">
                                        <input type="radio" class="radio-checkbox-input gateway-checkbox"
                                            name="gateway" value="{{ $key }}" checked />
                                        <span class="radio-checkbox-tile w-100">
                                            {!! $gateway->getIcon() !!}
                                            <span>{{ $gateway->getName() }}</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <hr class="mb-4">
                    <div class="row">
                        <h4 class="mb-3">@lang('tools.billingAddress')</h4>
                        <div class="col-md-6 mb-3">
                            <x-input-label for="firstName">{{ __('tools.firstName') }}</x-input-label>
                            <input type="text" class="form-control valid-id" id="firstName" placeholder=""
                                value="{{ old('first_name', Auth::user()->first_name) }}" required name="first_name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <x-input-label for="lastName">{{ __('tools.lastName') }}</x-input-label>
                            <input type="text" class="form-control valid-id" id="lastName" placeholder=""
                                value="{{ old('last_name', Auth::user()->last_name) }}" required name="last_name">
                        </div>
                        <div class="col-md-12 mb-3">
                            <x-input-label for="company">{{ __('tools.companyName') }}</x-input-label>
                            <input type="company" class="form-control" id="company" name="company"
                                value="{{ old('company') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <x-input-label for="country_code">{{ __('tools.countryCode') }}</x-input-label>
                            <select class="form-select valid-id" id="country_code" name="country_code">
                                <option value="">@lang('common.selectOne')</option>
                                @foreach ($countries as $country)
                                    <option
                                        value="{{ $country->iso2 }}"{{ old('country_code') == $country->iso2 ? ' selected' : '' }}>
                                        {{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <x-input-label for="state">{{ __('tools.stateCounty') }}</x-input-label>
                            <input type="text" class="form-control valid-id" id="state" required name="state"
                                value="{{ old('state') }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <x-input-label for="address">{{ __('tools.addressLane1') }}</x-input-label>
                            <input type="text" class="form-control valid-id" id="address"
                                placeholder="1234 Main St" required name="address_lane_1"
                                value="{{ old('address_lane_1') }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <x-input-label for="address2">{{ __('tools.addressLane2') }}</x-input-label>
                            <input type="text" class="form-control" id="address2" placeholder="Apartment or suite"
                                name="address_lane_2" value="{{ old('address_lane_2') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <x-input-label for="city">{{ __('tools.townCity') }}</x-input-label>
                            <input type="text" class="form-control valid-id" id="city" required
                                name="city" value="{{ old('city') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <x-input-label for="zip">{{ __('tools.postalCode') }}</x-input-label>
                            <input type="text" class="form-control valid-id" id="zip" required
                                name="postal_code" value="{{ old('postal_code') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <x-input-label for="phone">{{ __('tools.phone') }}</x-input-label>
                            <input type="text" class="form-control valid-id" id="phone" required
                                name="phone" value="{{ old('phone') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <x-input-label for="email">{{ __('tools.email') }}</x-input-label>
                            <input type="email" class="form-control valid-id" id="email"
                                placeholder="you@example.com" name="email" required
                                value="{{ old('email', Auth::user()->email) }}">
                        </div>
                    </div>
                </div>
            </div>
        </x-form>
    </x-page-wrapper>
    @push('page_scripts')
        @if (setting('razor_allow', 0))
            <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        @endif
        @if (setting('STRIPE_ALLOW', 0))
            <script src="https://js.stripe.com/v3/"></script>
        @endif
        @if (setting('allow_paddle', 0))
            <script src="https://cdn.paddle.com/paddle/paddle.js"></script>
        @endif
        <script>
            const APP = function() {
                let gateway = document.querySelector("input[name=gateway]:checked").value,
                    success_url = null;
                const completePurchase = document.getElementById('complete-purchase');
                const getView = function() {
                        var inputs = document.querySelectorAll('.gateway-checkbox');
                        var gatewayValue = document.querySelector("input[name=gateway]:checked").value;
                        ArtisanApp.showLoader()
                        axios.post(
                                '{{ route('payments.gateway-view') }}', {
                                    gateway: gatewayValue,
                                    plan_id: {{ $plan_id }}
                                })
                            .then((res) => {
                                ArtisanApp.hideLoader()
                                document.getElementById('gatewayview-div').innerHTML = res.data.view;
                                @if (!empty(config('services.gateways.stripe.apiKey')))
                                    if (gatewayValue == 'stripe' && document.querySelectorAll('#card-element').length >
                                        0) {
                                        initStripe()
                                    }
                                @endif
                                @if (!empty(config('services.gateways.paddle.vendor_id')))
                                    if (gatewayValue == 'paddle') {
                                        initPaddle()
                                    }
                                @endif
                            })
                            .catch((err) => {
                                ArtisanApp.hideLoader()
                            })
                    },
                    padStart = function(str) {
                        return ('0' + str).slice(-2)
                    },
                    demoSuccessHandler = function(transaction) {
                        document.getElementById('razor-pay-id').value = transaction.razorpay_payment_id;
                        document.getElementById('process-form').submit();
                    },
                    razorpayopen = function(e) {
                        e.preventDefault();
                        var firstname = document.getElementById('firstName').value;
                        var lastname = document.getElementById('lastName').value;
                        var email = document.getElementById('email').value;
                        var address = document.getElementById('address').value;
                        var zip = document.getElementById('zip').value;
                        if (firstname == "" || lastname == "" || email == "" || address == "" || zip == "") {
                            ArtisanApp.toastError("{{ __('common.billingInfoAlert') }}");
                            return;
                        }
                        var options = {
                            key: "{{ config('services.gateways.razorpay.key') }}",
                            amount: Number({{ $price }} * 100).toFixed(2),
                            currency: "{{ setting('currency', 'usd') }}",
                            name: "{{ $plan->name }}",
                            description: "{{ str_replace(["\n", "\r"], ["\\n", "\\r"], $plan->description) }}",
                            handler: demoSuccessHandler
                        }
                        window.r = new Razorpay(options);
                        r.open()
                    },
                    validationEvent = function() {
                        document.querySelectorAll('.valid-id').forEach(input => {
                            if (input.value == "") {
                                input.classList.add("is-invalid");
                            } else {
                                input.classList.remove("is-invalid");
                            }
                            input.addEventListener('change', (e) => {
                                var input_value = e.target.value;
                                if (input_value == "") {
                                    e.target.classList.add("is-invalid");
                                } else {
                                    e.target.classList.remove("is-invalid");
                                }
                            })
                        });
                    },
                    attachEvents = function() {
                        document.querySelectorAll('.gateway-checkbox').forEach(input => {
                            input.addEventListener('change', (e) => {
                                gateway = e.target.value
                                gateway == "razorpay" ?
                                    completePurchase.addEventListener("click", razorpayopen, true) :
                                    completePurchase.removeEventListener("click", razorpayopen, true);
                                getView()
                            })
                        });
                    };
                @if (!empty(config('services.gateways.paddle.vendor_id')))
                    const initPaddle = function() {
                        const form = document.getElementById('process-form')
                        form.addEventListener('submit', async (e) => {
                            completePurchase.disabled = true
                            if (gateway != 'paddle') {
                                return;
                            }

                            e.preventDefault()
                            let data = new FormData(form);
                            axios.post(form.action, data)
                                .then((response) => {
                                    ArtisanApp.hideLoader();
                                    completePurchase.disabled = false
                                    success_url = response.data.success
                                    console.log(response.data.url, success_url)
                                    Paddle.Checkout.open({
                                        override: response.data.url
                                    });
                                }, (error) => {
                                    ArtisanApp.hideLoader();
                                    completePurchase.disabled = false
                                });
                        });
                    };
                @endif
                @if (!empty(config('services.gateways.stripe.apiKey')))
                    const initStripe = function() {
                        const stripe = Stripe('{{ config('services.gateways.stripe.apiKey') }}')
                        const form = document.getElementById('process-form')
                        const tokenField = document.getElementById('client_token')
                        const cardHolderName = document.getElementById('cc-name')
                        const elements = stripe.elements()
                        const cardElement = elements.create('card')
                        cardElement.mount('#card-element')

                        form.addEventListener('submit', async (e) => {
                            completePurchase.disabled = true
                            if (gateway != 'stripe') {
                                return;
                            }
                            e.preventDefault()
                            const {
                                setupIntent,
                                error
                            } = await stripe.confirmCardSetup(
                                tokenField.value, {
                                    payment_method: {
                                        card: cardElement,
                                        billing_details: {
                                            name: cardHolderName.value
                                        }
                                    }
                                }
                            )

                            if (error) {
                                completePurchase.disabled = false
                                ArtisanApp.hideLoader()
                                if (error.message) {
                                    ArtisanApp.toastError(error.message)
                                }
                            } else {
                                let token = document.createElement('input')
                                token.setAttribute('type', 'hidden')
                                token.setAttribute('name', 'payment_method')
                                token.setAttribute('value', setupIntent.payment_method)
                                form.appendChild(token)
                                let data = new FormData(form);
                                axios.post(form.action, data)
                                    .then((response) => {
                                        stripe.confirmCardPayment(response.data.clientSecret, {
                                            payment_method: {
                                                card: cardElement,
                                                billing_details: {
                                                    name: data.get('name_card'),
                                                },
                                            }
                                        }).then((result) => {
                                            if (result.error) {
                                                ArtisanApp.toastError(result.error.message);
                                                ArtisanApp.hideLoader();
                                                completePurchase.disabled = false
                                            } else {
                                                ArtisanApp.hideLoader();
                                                window.location.href = response.data
                                                    .redirect_url
                                            }
                                        });
                                    }, (error) => {
                                        ArtisanApp.hideLoader();
                                        completePurchase.disabled = false
                                    });
                            }
                        })
                    };
                @endif
                return {
                    init: function() {
                        attachEvents();
                        getView();
                        validationEvent();
                        @if (config('paddle.sandbox_environment'))
                            Paddle.Environment.set('sandbox');
                        @endif
                        Paddle.Setup({
                            vendor: {{ (int) config('paddle.vendor_id') }},
                            eventCallback: function(data) {
                                if (data.event == "Checkout.Complete") {
                                    window.location = success_url
                                }
                            }
                        });
                    },
                }
            }();

            document.addEventListener("DOMContentLoaded", function(event) {
                APP.init();
            });
        </script>
    @endpush
</x-application-no-widget-wrapper>
