<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;

/**
 * Class ReceiptDetail.
 */
class ReceiptDetail extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'description',
        'period',
        'price',
        'amount',
        'tax_rate_id',
        'ledger_account_id',
        'row_order',
        '_destroy',
    ];
}
