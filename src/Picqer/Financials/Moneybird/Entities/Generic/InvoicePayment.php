<?php

namespace Picqer\Financials\Moneybird\Entities\Generic;

use Picqer\Financials\Moneybird\Model;

/**
 * Class InvoicePayment.
 *
 * @property string|int $id
 * @property string|int $administration_id
 * @property string $invoice_type
 * @property string|int $invoice_id
 * @property string|int|null $financial_account_id
 * @property string|int $user_id
 * @property string|int|null $payment_transaction_id
 * @property string $price
 * @property string $price_base
 * @property string $payment_date
 * @property string|int|null $credit_invoice_id
 * @property string|int|null $financial_mutation_id
 * @property string|null $transaction_identifier
 * @property string|int|null $ledger_account_id
 * @property string|int|null $linked_payment_id
 * @property string|null $manual_payment_action
 * @property string|null $created_at
 * @property string|null $updated_at
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
        'transaction_identifier',
        'manual_payment_action',
        'ledger_account_id',
        'created_at',
        'updated_at',
    ];

    /**
     * @var string
     */
    protected $namespace = 'payment';
}
