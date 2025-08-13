<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Model;

/**
 * Class LedgerAccount.
 *
 * @property string|int $id
 * @property string|int $administration_id
 * @property string $name
 * @property string $account_type
 * @property string $account_id
 * @property string|int|null $parent_id
 * @property array $allowed_document_types
 * @property array $taxonomy_item
 * @property string|int|null $financial_account_id
 * @property string $created_at
 * @property string $updated_at
 */
class LedgerAccount extends Model
{
    use FindAll, FindOne, Storable, Removable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'administration_id',
        'name',
        'account_type',
        'account_id',
        'parent_id',
        'allowed_document_types',
        'taxonomy_item',
        'financial_account_id',
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
