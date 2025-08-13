<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;

/**
 * Class GeneralJournalDocumentEntry.
 *
 * @property string|int $id
 * @property string|int $administration_id
 * @property string|int $ledger_account_id
 * @property string|int|null $contact_id
 * @property string $description
 * @property string $debit
 * @property string $credit
 * @property string|int|null $project_id
 * @property int $row_order
 * @property string $created_at
 * @property string $updated_at
 */
class GeneralJournalDocumentEntry extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'administration_id',
        'ledger_account_id',
        'contact_id',
        'description',
        'debit',
        'credit',
        'project_id',
        'row_order',
        'created_at',
        'updated_at',
    ];
}
