<?php

namespace App\Components\Gateways;

use Exception;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Contracts\GatewayInterface;
use ProtoneMedia\LaravelPaddle\Paddle as PaddleGateway;

class Paddle implements GatewayInterface
{
    protected $paddle;
    protected $request;
    protected $config;

    public function __construct(Request $request, array $config)
    {
        $this->request = $request;
        $this->config = $config;
    }

    public function isActive(): bool
    {
        return (bool) setting('allow_paddle', 0);
    }

    public function isConfigured(): bool
    {
        return ($this->config['auth_code'] != null && $this->config['vendor_id'] != null && $this->config['public_key'] != null) ? true : false;
    }

    public function getName(): string
    {
        return "Paddle";
    }

    public function getIcon(): string
    {
        return '<i class="an an-paddle"></i>';
    }

    public function getViewName()
    {
        return "checkout.paddle";
    }

    public function initialize()
    {
        $this->paddle = PaddleGateway::subscription();
    }

    public function render()
    {
        return view($this->getViewName())->render();
    }

    public function processPayment($transaction)
    {
        try {
            $request = $this->request;
            $plan_id = $request->plan_id;
            $plan = ($plan_id == 0) ? ads_plan() : Plan::find($request->plan_id);

            $product = $this->createOrFirstProduct($plan);
            $response = PaddleGateway::product()
                ->generatePayLink()
                ->productId($product)
                ->customerEmail($request->email)
                ->customerCountry($request->country_code)
                ->customerPostcode($request->zip)
                ->passthrough(['transaction_id' => $transaction->id])
                ->send();

            if ($request->wantsJson()) {
                $response['success'] = route("payments.success", ['transaction_id' => $transaction->id, 'plan_id' => $plan->id]);
                return response()->json($response);
            } else {
                return redirect()->away($response['url']);
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function verifyPayment($transaction, $request): bool
    {
        $plan = ($request->plan_id == 0) ? ads_plan() : Plan::find($request->plan_id);
        $product = $this->createOrFirstProduct($plan);
        $transactions = collect(PaddleGateway::product()->listTransactions('product', $product)->send());
        $order = $transactions
            ->filter(function ($data) use ($transaction) {
                $passthrough = json_decode($data['passthrough'], true);
                return $passthrough['transaction_id'] == $transaction->id;
            })
            ->first();

        if (isset($order['status']) && $order['status'] == 'completed') {
            $transaction->transaction_id = $order['subscription']['subscription_id'] ?? $order['order_id'];
            $transaction->update();
        }

        return isset($order['status']) && $order['status'] == 'completed';
    }

    protected function createOrFirstProduct(Plan $plan)
    {
        $plans = collect($this->paddle->listPlans()->send());
        $plan_type = ($this->request->type == "yearly") ? "year" : "month";
        $amount = ($this->request->type == "yearly") ? $plan->yearly_price : $plan->monthly_price;
        $product = $plans->where('name', $plan->name)->where('billing_type', $plan_type)->first();
        if (!$product) {
            $product = $this->paddle->createPlan([
                'plan_name' => $plan->name,
                'plan_trial_days' => 0,
                'plan_type' => $plan_type,
                'plan_length' => 1,
                'main_currency_code' => setting('currency', "USD"),
                'recurring_price_usd' => $amount,
            ])->send();
        }

        return $product['id'] ?? false;
    }

    public function webhook(Request $request)
    {
        return;
    }
}
