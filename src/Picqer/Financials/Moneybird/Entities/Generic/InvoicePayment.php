<?php

namespace Picqer\Financials\Moneybird\Entities\Generic;

use Picqer\Financials\Moneybird\Model;

/**
 * Class InvoicePayment.
 */
abstract class InvoicePayment extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'invoice_type',
        'invoice_id',
        'financial_account_id',
        'user_id',
        'payment_transaction_id',
        'price',
        'price_base',
        'payment_date',
        'credit_invoice_id',
        'financial_mutation_id',
        'created_at',
        'updated_at',
    ];

    /**
     * @var string
     */
    protected $namespace = 'payment';
}
