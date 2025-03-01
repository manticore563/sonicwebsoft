<?php

namespace App\Models;

use Nicolaslopezj\Searchable\SearchableTrait;

class Transaction extends BaseModel
{
    use SearchableTrait;

    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'email',
        'address_lane_1', 'address_lane_2', 'postal_code',
        'country_code', 'currency', 'amount', 'plan_id',
        'plan_type', 'gateway', 'transaction_id', 'status',
        'payment_gateway', 'expiry_date', 'response',
        'company', 'state', 'city', 'phone'
    ];

    protected $casts = [
        'expiry_date' => 'datetime'
    ];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'transactions.email' => 5,
            'transactions.payment_gateway' => 5,
            'transactions.amount' => 5,
            'transactions.currency' => 5,
            'transactions.address_lane_1' => 5,
            'transactions.first_name' => 3,
            'transactions.last_name' => 3,
            'transactions.transaction_id' => 3,
            'plan_translations.name' => 5,
            'plan_translations.description' => 2,
        ],
        'joins' => [
            'plan_translations' => ['transactions.plan_id', 'plan_translations.plan_id'],
        ],
        'group_by' => [
            'plan_translations.plan_id',
        ]
    ];

    /**
     * Trasaction belongs to user
     *
     * @return collection
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Trasaction belongs to plan
     *
     * @return collection
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Trasaction scope plan
     *
     * @return collection
     */
    public function scopePlan($query)
    {
        return $query->where('plan_id', '!=', '0');
    }

    /**
     * Trasaction scope active
     *
     * @return collection
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeActiveOrCancelled($query)
    {
        return $query->where(function ($query) {
            $query->where('status', 1)->orWhere('status', 2);
        });
    }

    public function scopeBank($query)
    {
        return $query->where('payment_gateway', 'banktransfer');
    }
}
