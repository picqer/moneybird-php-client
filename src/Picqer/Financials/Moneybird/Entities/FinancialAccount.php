<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Model;


/**
 * @property string id
 * @property string type
 * @property string name
 * @property string identifier
 * @property string currency
 * @property string provider
 * @property string active
 * @property string created_at
 * @property string updated_at
 */
class FinancialAccount extends Model
{
    use FindAll;

    
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

    
    protected $endpoint = 'financial_accounts';
}
