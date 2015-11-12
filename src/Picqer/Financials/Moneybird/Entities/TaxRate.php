<?php namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Model;

/**
 * Class TaxRate
 * @package Picqer\Financials\Moneybird\Entities
 */
class TaxRate extends Model {

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
    protected $url = 'tax_rates';
}