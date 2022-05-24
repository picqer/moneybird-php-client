<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;


/**
 * @property string id
 * @property string description
 * @property string period
 * @property string price
 * @property string amount
 * @property string tax_rate_id
 * @property string ledger_account_id
 * @property string row_order
 * @property string _destroy
 */
class ReceiptDetail extends Model
{
    
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
