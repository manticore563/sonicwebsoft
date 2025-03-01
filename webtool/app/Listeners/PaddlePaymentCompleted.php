<?php

namespace App\Listeners;

use App\Models\Transaction;
use ProtoneMedia\LaravelPaddle\Events\PaymentSucceeded;

class PaddlePaymentCompleted
{
    /**
     * Handle the event.
     */
    public function handle(PaymentSucceeded $event): void
    {
        $transaction_id = $event->passthrough['transaction_id'];
        $transaction = Transaction::find($transaction_id);
        if ($transaction && $transaction->status == 0) {
            $transaction->status = 1;
            $transaction->transaction_id = $event->checkout_id;
            $transaction->expiry_date = $transaction->plan_type == "yearly" ? now()->addYear() : now()->addMonth();
            $transaction->response = __('tools.successfull');
            $transaction->update();
        }
    }
}
