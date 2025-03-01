<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Plan;
use RuntimeException;
use App\Models\Country;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\Facads\Payment;
use Butschster\Head\Facades\Meta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Facades\Invoice;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class PaymentsController extends Controller
{
    public function checkout($plan_id, $type)
    {
        if (!in_array($type, ['monthly', 'yearly']) || $plan_id == null) {
            return redirect()->back();
        }

        try {
            if (Auth::user()->hasActiveSubscription()) {
                return redirect()->back()->withErrors(__('tools.alreadySubscribed'));
            }

            $meta = __("static_pages.checkout");
            Meta::setMeta((object) $meta);

            $plan = ($plan_id == 0) ? ads_plan() : Plan::findOrFail($plan_id);
            $price = ($type == "monthly") ? $plan->monthly_price : $plan->yearly_price;
            $gateways = Payment::all();
            $countries = Country::select('name', 'iso2')->get();

            if (!$gateways) {
                throw new Exception(__('common.noPaymentGateway'));
            }

            return view('plans.checkout', compact('plan', 'type', 'price', 'gateways', 'plan_id', 'countries'));
        } catch (RuntimeException $r) {
            return redirect()->back()->withErrors(__('common.gatewayNotConfigured'));
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     *
     */
    public function process(Request $request)
    {
        $request->validate([
            'gateway' => "required",
            'type' => 'required',
            'plan_id' => 'required',
            'first_name' => 'required|min:2|max:50',
            'last_name' => 'required|min:2|max:50',
            'address_lane_1' => 'required',
            'country_code' => 'required',
            'state' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
        ]);

        $gateway = Payment::gateway($request->gateway);
        if (!$gateway) {
            return redirect()->back();
        }

        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'company' => $request->company,
            'address_lane_1' => $request->address_lane_1,
            'address_lane_2' => $request->address_lane_2,
            'country_code' => $request->country_code,
            'state' => $request->state,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'phone' => $request->phone,
            'plan_id' => $request->plan_id,
            'payment_gateway' => $request->gateway,
            'amount' => $request->price, // amount from plan will go here
            'currency' => Setting('currency', 'USD'), // currency from setting or plan will go here
            'user_id' => Auth::id(), // auth user will go here
            'plan_type' => $request->type
        ];
        $transaction = new Transaction();
        $transaction = $transaction->create($data);

        return $gateway->processPayment($transaction);
    }

    /**
     *
     */
    public function success(Request $request, $id)
    {
        $transaction = Transaction::find($id);
        if ($transaction->payment_gateway == "skrill") {
            Session::put('transaction_completed', true);
            return redirect()->route('payments.finish')->withSuccess(__('tools.paymentCompletedSuccess'));
        }

        $gateway = Payment::gateway($transaction->payment_gateway);
        if ($gateway->verifyPayment($transaction, $request) == false) {
            return redirect()->route('payments.cancel', $transaction->id);
        }

        $transaction->expiry_date = $transaction->plan_type == "yearly" ? now()->addYear() : now()->addMonth();
        $transaction->status = 1;
        $transaction->response = __('tools.successfull');
        $transaction->update();

        Session::put('transaction_completed', true);

        return redirect()->route('payments.finish')->withSuccess(__('tools.paymentCompletedSuccess'));
    }

    /**
     *
     */
    public function pending(Request $request, $id)
    {
        $transaction = Transaction::find($id);
        $transaction->status = 5;
        $transaction->response = __("common.pendingPayment");
        $transaction->update();

        return view('plans.pending');
    }

    /**
     *
     */
    public function cancel(Request $request, $id)
    {
        $transaction = Transaction::find($id);
        $transaction->status = 0;
        $transaction->response = __("tools.cancelResponse");
        $transaction->update();

        return redirect()->route('front.index')->withErrors(__('tools.cancelMsg'));
    }

    /**
     *
     */
    public function finish()
    {
        if (!Session::has('transaction_completed')) {
            return redirect()->route('front.index');
        }
        Session::forget('transaction_completed');

        return view('plans.finish');
    }

    /**
     *
     */
    public function getGatewayView(Request $request)
    {
        $gateway = Payment::gateway($request->gateway);

        return response()->json(['view' => $gateway->render()]);
    }

    /**
     *
     */
    public function transactions()
    {
        $transactions = Auth::user()->transactionsList()->where('status', '!=', 0)->latest()->get();

        $meta = __("static_pages.payments");
        Meta::setMeta((object) $meta);

        return view('plans.transactions', compact('transactions'));
    }

    /**
     *
     */
    public function invoice(Transaction $transaction)
    {
        $meta = __("static_pages.invoice");
        Meta::setMeta((object) $meta);

        return view('plans.invoice', compact('transaction'));
    }

    /**
     *
     */
    public function invoiceDownload($id)
    {
        $transaction = Transaction::find($id);
        $plan = $transaction->plan_id != 0 ? $transaction->plan->load('translations') : ads_plan();

        $seller = new Party([
            'name'          => config('app.name'),
            'phone'         => setting('website_contact_number'),
        ]);

        $buyer = new Party([
            'name'             => "{$transaction->first_name} {$transaction->last_name}",
            'address'          => "{$transaction->address_lane_1} {$transaction->city}, {$transaction->state} {$transaction->postal_code}",
            'gateway'          => strtoupper($transaction->payment_gateway),
            'phone'            => $transaction->phone,
            'custom_fields'    => [
                'Invoice #'    => $transaction->id,
                'email'        => $transaction->email,
            ],
        ]);

        $items =  [(new InvoiceItem())
            ->title($plan->name)
            ->description($plan->description)
            ->pricePerUnit($transaction->amount)
            ->quantity(1)
            ->discountByPercent(0)];

        $status = $transaction->status == 0 ? __('invoices::invoice.due') : __('invoices::invoice.paid');
        $currencyFormat = currency($transaction->currency)->isSymbolFirst() ? '{SYMBOL}{VALUE}' : '{VALUE}{SYMBOL}';
        $logo = public_path(setting('website_logo'));

        $invoice = Invoice::make('invoice')
            ->series(strtoupper($transaction->plan_type))
            ->status($status)
            ->sequence($transaction->id)
            ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->seller($seller)
            ->buyer($buyer)
            ->date($transaction->created_at)
            ->payUntilDays($transaction->created_at->diffInDays($transaction->expiry_date))
            ->dateFormat(setting('date_format'))
            ->currencySymbol(currency($transaction->currency)->getSymbol())
            ->currencyCode($transaction->currency)
            ->currencyFormat($currencyFormat)
            ->currencyThousandsSeparator(currency($transaction->currency)->getThousandsSeparator())
            ->currencyDecimalPoint(currency($transaction->currency)->getDecimalMark())
            ->filename($transaction->id . '-Invoice')
            ->addItems($items)
            ->notes(__('tools.additionalNoteHelp'))
            ->logo($logo);

        return $invoice->download();
    }

    /**
     *
     */
    public function webhookListener(Request $request)
    {
        $transaction = Transaction::where('transaction_id', $request->id)->active()->latest()->first();

        if ($transaction) {
            $transaction->status = 2;
            $transaction->save();
            $data = [
                'first_name' => $transaction->first_name,
                'last_name' => $transaction->last_name,
                'email' => $transaction->email,
                'address_lane_1' => $transaction->address_lane_1,
                'address_lane_2' => $transaction->address_lane_2,
                'postal_code' => $transaction->postal_code,
                'country_code' => $transaction->country_code,
                'plan_id' => $transaction->plan_id,
                'payment_gateway' => $transaction->payment_gateway,
                'amount' => $transaction->amount, // amount from plan will go here
                'currency' => $transaction->currency, // currency from setting or plan will go here
                'user_id' => $transaction->user_id, // auth user will go here
                'plan_type' => $transaction->plan_type,
                'transaction_id' => $transaction->transaction_id,
                'status' => 1,
                'response' => "Successfuly Re-subscribed",
                'expiry_date' => $transaction->plan_type == "yearly" ? now()->addYear() : now()->addMonth(),
            ];

            $transactionnew = new Transaction();
            $transactionnew = $transactionnew->create($data);
        }
    }
}
