<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Model;

/**
 * Class TaxRate.
 *
 * @property string|int $id
 * @property string|int $administration_id
 * @property string $name
 * @property string $percentage
 * @property string $tax_rate_type
 * @property string $country
 * @property bool $show_tax
 * @property bool $active
 * @property string $created_at
 * @property string $updated_at
 */
class TaxRate extends Model
{
    use FindAll;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'administration_id',
        'name',
        'percentage',
        'tax_rate_type',
        'country',
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
