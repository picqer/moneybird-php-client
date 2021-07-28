<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Model;

/**
 * Class LedgerAccount.
 */
class LedgerAccount extends Model
{
    use FindAll, FindOne, Storable, Removable;

    /**
     * @var array
     */
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

    /**
     * @var string
     */
    protected $endpoint = 'ledger_accounts';

    /**
     * @var string
     */
    protected $namespace = 'ledger_account';
}
