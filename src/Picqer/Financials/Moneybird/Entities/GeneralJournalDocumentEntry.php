<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;


/**
 * @property string id
 * @property string administration_id
 * @property string ledger_account_id
 * @property string contact_id
 * @property string description
 * @property string debit
 * @property string credit
 * @property string project_id
 * @property string row_order
 * @property string created_at
 * @property string updated_at
 */
class GeneralJournalDocumentEntry extends Model
{
    
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
