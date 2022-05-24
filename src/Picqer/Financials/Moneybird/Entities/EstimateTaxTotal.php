<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;


/**
 * @property string tax_rate_id
 * @property string taxable_amount
 * @property string taxable_amount_base
 * @property string tax_amount
 * @property string tax_amount_base
 */
class EstimateTaxTotal extends Model
{
    
    protected $fillable = [
        'tax_rate_id',
        'taxable_amount',
        'taxable_amount_base',
        'tax_amount',
        'tax_amount_base',
    ];
}
