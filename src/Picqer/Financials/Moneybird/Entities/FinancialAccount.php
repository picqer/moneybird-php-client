<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Model;

/**
 * Class FinancialAccount.
 *
 * @property string|int $id
 * @property string|int $administration_id
 * @property string $type
 * @property string $name
 * @property string $identifier
 * @property string $currency
 * @property string $provider
 * @property bool $active
 * @property string $created_at
 * @property string $updated_at
 */
class FinancialAccount extends Model
{
    use FindAll;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'administration_id',
        'type',
        'name',
        'identifier',
        'currency',
        'provider',
        'active',
        'created_at',
        'updated_at',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'financial_accounts';
}
