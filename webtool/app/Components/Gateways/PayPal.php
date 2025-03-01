<?php

namespace App\Components\Gateways;

use Exception;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Contracts\GatewayInterface;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPal implements GatewayInterface
{
    protected $paypal;
    protected $request;
    protected $config;

    public function __construct(Request $request, array $config)
    {
        $this->request = $request;
        $this->config = $config;
    }

    public function isActive(): bool
    {
        return (bool) setting('PAYPAL_ALLOW', 0);
    }

    public function isConfigured(): bool
    {
        $mode = $this->config['mode'];

        return ($this->config[$mode]['client_id'] != null && $this->config[$mode]['client_secret'] != null && $this->config[$mode]['app_id'] != null) ? 1 : 0;
    }

    public function getName(): string
    {
        return "PayPal";
    }

    public function getIcon(): string
    {
        return '<i class="an an-paypal"></i>';
    }

    public function getViewName()
    {
        return "checkout.paypal";
    }

    public function initialize()
    {
        $this->paypal = new PayPalClient($this->config);
        $this->paypal->getAccessToken();
        $this->paypal->setCurrency(setting('currency', "USD"));
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
            $provider = $this->paypal;
            $plan = ($plan_id == 0) ? ads_plan() : Plan::find($request->plan_id);
            $amount = ($request->type == "yearly") ? $plan->yearly_price : $plan->monthly_price;
            $var_type = ($request->type == "yearly") ? "addAnnualPlan" : "addMonthlyPlan";
            $redirectLink = null;

            $response = $provider->addProduct($plan->name, $plan->description, 'SERVICE', 'SOFTWARE')
                ->$var_type($plan->name, $plan->description, $amount)
                ->setReturnAndCancelUrl(
                    route('payments.success', ['transaction_id' => $transaction->id]),
                    route('payments.cancel', ['transaction_id' => $transaction->id])
                )
                ->setupSubscription($request->first_name . ' ' . $request->last_name, $request->email, Carbon::now()->addMinutes(2)->toIso8601String());

            if ($response['status'] == "APPROVAL_PENDING" && isset($response['id'])) {
                $transaction->transaction_id = $response['id'];
                $transaction->update();
                $redirectLink  = $response['links'][0]['href'];
            }

            return $redirectLink ? redirect()->away($redirectLink) : redirect()->back();
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function verifyPayment($transaction, $request): bool
    {
        // $response = $this->paypal->capturePaymentOrder($request->token, [
        //     'note' => "{$transaction->first_name} {$transaction->last_name} {$transaction->plan_type} subscription.",
        //     'amount' => [
        //         'currency_code' => setting('currency', "USD"),
        //         'value' => $transaction->amount,
        //     ],
        //     'capture_type' => "OUTSTANDING_BALANCE",
        // ]);
        //
        // if (isset($response['status']) && $response['status'] == 'COMPLETED') {
        //     return true;
        // }

        $order    = $this->paypal->showOrderDetails($request->token);
        if (isset($order['status']) && $order['status'] == 'APPROVED') {
            return true;
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
