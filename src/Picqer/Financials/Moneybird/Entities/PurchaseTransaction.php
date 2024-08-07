<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Model;

/**
 * Class PurchaseInvoice.
 */
class PurchaseTransaction extends Model
{
    use FindAll, FindOne, Removable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'financial_account_id',
        'payment_instrument_id',
        'state',
        'sepa_iban',
        'sepa_iban_account_name',
        'sepa_bic',
        'source_sepa_iban',
        'source_sepa_iban_account_name',
        'date',
        'description',
        'end_to_end_id',
        'amount',
        'created_at',
        'updated_at',
        'payable_type',
        'payable_id',
        'payment_method',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'purchase_transactions';

    /**
     * @var string
     */
    protected $namespace = 'purchase_transaction';
}
