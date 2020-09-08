<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Model;

/**
 * Class FinancialAccount.
 */
class FinancialAccount extends Model
{
    use FindAll;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
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
