<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\Filterable;
use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Model;


/**
 * @property string id
 * @property string name
 * @property string percentage
 * @property string tax_rate_type
 * @property string show_tax
 * @property string active
 * @property string country
 * @property string created_at
 * @property string updated_at
 */
class TaxRate extends Model
{
    use FindAll, Filterable;

    
    protected $fillable = [
        'id',
        'name',
        'percentage',
        'tax_rate_type',
        'show_tax',
        'active',
        'country',
        'created_at',
        'updated_at',
    ];

    
    protected $endpoint = 'tax_rates';
}
