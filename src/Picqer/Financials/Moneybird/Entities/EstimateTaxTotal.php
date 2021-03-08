<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;

/**
 * Class EstimateTaxTotal.
 */
class EstimateTaxTotal extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'tax_rate_id',
        'taxable_amount',
        'taxable_amount_base',
        'tax_amount',
        'tax_amount_base',
    ];
}
