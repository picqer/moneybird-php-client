<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;

/**
 * Class LedgerAccountBooking.
 *
 * @property string|int $id
 * @property string|int $administration_id
 * @property string|int $ledger_account_id
 * @property string $description
 * @property string $price
 * @property string|int|null $financial_mutation_id
 * @property string|int|null $project_id
 * @property string $created_at
 * @property string $updated_at
 */
class LedgerAccountBooking extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'administration_id',
        'ledger_account_id',
        'description',
        'price',
        'financial_mutation_id',
        'project_id',
        'created_at',
        'updated_at',
    ];
}
