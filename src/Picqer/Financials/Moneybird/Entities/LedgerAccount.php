<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Model;


/**
 * @property string id
 * @property string name
 * @property string account_type
 * @property string account_id
 * @property string parent_id
 * @property string allowed_document_types
 * @property string created_at
 * @property string updated_at
 */
class LedgerAccount extends Model
{
    use FindAll, FindOne, Storable, Removable;

    
    protected $fillable = [
        'id',
        'name',
        'account_type',
        'account_id',
        'parent_id',
        'allowed_document_types',
        'created_at',
        'updated_at',
    ];

    
    protected $endpoint = 'ledger_accounts';

    
    protected $namespace = 'ledger_account';
}
