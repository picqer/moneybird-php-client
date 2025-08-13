<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Model;

/**
 * Class Administration.
 *
 * @property string|int $id
 * @property string $name
 * @property string $language
 * @property string $currency
 * @property string $country
 * @property string $time_zone
 * @property string $access
 * @property bool $suspended
 * @property string|null $period_locked_until
 */
class Administration extends Model
{
    use FindAll;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'language',
        'currency',
        'country',
        'time_zone',
        'access',
        'suspended',
        'period_locked_until',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'administrations';
}
