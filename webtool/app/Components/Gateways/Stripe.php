<?php

namespace App\Components\Gateways;

use Exception;
use Stripe\Token;
use App\Models\Plan;
use Stripe\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Contracts\GatewayInterface;
use Stripe\Stripe as StripeGateway;

class Stripe implements GatewayInterface
{
    protected $stripe;
    protected $config;
    protected $stripeConfig;
    protected $request;
    protected $stripeToken;

    public function __construct(Request $request, array $config)
    {
        $this->request = $request;
        $this->config = $config;
    }

    public function isActive(): bool
    {
        return (bool) setting('STRIPE_ALLOW', 0);
    }

    public function isConfigured(): bool
    {
        return  $this->config['secretKey'] != null ? 1 : 0;
    }

    public function getName(): string
    {
        return "Stripe / Credit or Debit Card";
    }

    public function getIcon(): string
    {
        return '<i class="an an-card-visa"></i>';
    }

    public function initialize()
    {
        $this->stripe = new \Stripe\StripeClient($this->config['secretKey']);
    }

    public function render()
    {
        $stripe = $this->stripe;
        $setupIntents = $stripe->setupIntents->create([
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
        ]);
        $client_token = $setupIntents->client_secret;

        return view('checkout.stripe', compact('client_token'))->render();
    }

    public function processPayment($transaction)
    {
        try {
            StripeGateway::setApiKey($this->config['secretKey']);
            $request = $this->request;
            $stripe = $this->stripe;
            $plan_id = $request->plan_id;
            $plan = ($plan_id == 0) ? ads_plan() : Plan::find($request->plan_id);
            $amount = ($request->type == "yearly") ? $plan->yearly_price : $plan->monthly_price;
            $plan_type = ($request->type == "yearly") ? 'year' : 'month';

            // Create Customer
            $customer = Customer::create([
                'name' => "{$request->first_name} {$request->last_name}",
                'address' => [
                    'line1' => $request->address_lane_1,
                    'postal_code' => $request->postal_code,
                    'country' => $request->country_code,
                ],
                'email' => $request->email,
                'payment_method' => $request->payment_method,
                'invoice_settings' => [
                    'default_payment_method' => $request->payment_method,
                ],
            ]);

            //create product
            $product = $stripe->products->create([
                'name' => $plan->name,
            ]);

            $price = $stripe->prices->create([
                'unit_amount' => str_replace([','], [''], $amount) * 100,
                'currency' => setting('currency', "USD"),
                'recurring' => ['interval' => $plan_type],
                'product' => $product->id,
                // 'description' => $plan->description,
            ]);

            $subscription = $stripe->subscriptions->create([
                'customer' => $customer->id,
                'currency' => setting('currency', "USD"),
                'default_payment_method' => $request->payment_method,
                'items' => [
                    ['price' => $price->id],
                ],
                'payment_behavior' => 'default_incomplete',
                'payment_settings' => ['save_default_payment_method' => 'on_subscription'],
                'expand' => ['latest_invoice.payment_intent'],
                "collection_method" => "charge_automatically",
            ]);

            // update the transaction id for the database
            $transaction->transaction_id = $subscription->id;
            $transaction->update();

            $output = [
                'subscriptionId' => $subscription->id,
                'status' => $subscription->status,
                'clientSecret' => $subscription->latest_invoice->payment_intent->client_secret ?? '',
                'customerId' => $customer->id,
                'redirect_url' => route("payments.success", ['transaction_id' => $transaction->id, 'subscription' => $subscription->id]),
            ];

            if ($request->wantsJson()) {
                return response()->json($output);
            } elseif (isset($subscription->status) && $subscription->status == 'active') {
                return redirect($output['return_url']);
            }

            return redirect()->route("payments.cancel", $transaction->id)->withErrors(__('common.somethingWentWrong'));
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function verifyPayment($transaction, $request): bool
    {
        $stripe = $this->stripe;
        StripeGateway::setApiKey($this->config['secretKey']);

        if (!empty($request->subscription) && $request->subscription == $transaction->transaction_id) {
            $order = $stripe->subscriptions->retrieve(
                $request->subscription,
                []
            );

            return isset($order->status) && $order->status == 'active' ? true : false;
        }

        return false;
    }

    public function webhook(Request $request)
    {
        info($request->all());

        $transaction = Transaction::where('transaction_id', $request->id)->active()->latest()->first();

        return $transaction;
    }
}
