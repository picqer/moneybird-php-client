<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;

/**
 * Class LedgerAccountBooking.
 *
 * @property string $id
 * @property string $administration_id
 * @property string $ledger_account_id
 * @property string $description
 * @property string $price
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
        'created_at',
        'updated_at',
    ];
}
