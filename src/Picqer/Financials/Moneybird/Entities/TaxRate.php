<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;
use Picqer\Financials\Moneybird\Actions\FindAll;

/**
 * Class TaxRate.
 */
class TaxRate extends Model
{
    use FindAll;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'percentage',
        'tax_rate_type',
        'show_tax',
        'active',
        'created_at',
        'updated_at',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'tax_rates';
}
