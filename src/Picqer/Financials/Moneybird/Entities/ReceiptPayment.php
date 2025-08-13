<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;

/**
 * Class ReceiptPayment.
 *
 * @property string|int $id
 * @property string|int $administration_id
 * @property string $invoice_type
 * @property string|int $invoice_id
 * @property string|int $financial_account_id
 * @property string|int $user_id
 * @property string|int $payment_transaction_id
 * @property string|null $transaction_identifier
 * @property string $price
 * @property string $price_base
 * @property string $payment_date
 * @property string|int|null $credit_invoice_id
 * @property string|int $financial_mutation_id
 * @property string|int|null $ledger_account_id
 * @property string|int|null $linked_payment_id
 * @property string|null $manual_payment_action
 * @property string $created_at
 * @property string $updated_at
 */
class ReceiptPayment extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'administration_id',
        'invoice_type',
        'invoice_id',
        'financial_account_id',
        'user_id',
        'payment_transaction_id',
        'transaction_identifier',
        'price',
        'price_base',
        'payment_date',
        'credit_invoice_id',
        'financial_mutation_id',
        'ledger_account_id',
        'linked_payment_id',
        'manual_payment_action',
        'created_at',
        'updated_at',
    ];

    /**
     * @var string
     */
    protected $namespace = 'payment';
}
