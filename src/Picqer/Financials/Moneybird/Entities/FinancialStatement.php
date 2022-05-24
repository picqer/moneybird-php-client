<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Model;


/**
 * @property string id
 * @property string financial_account_id
 * @property string reference
 * @property string official_date
 * @property string official_balance
 * @property string importer_service
 * @property string financial_mutations
 * @property string update_journal_entries
 */
class FinancialStatement extends Model
{
    use Storable, Removable;

    
    protected $fillable = [
        'id',
        'financial_account_id',
        'reference',
        'official_date',
        'official_balance',
        'importer_service',
        'financial_mutations',
        'update_journal_entries',
    ];

    
    protected $endpoint = 'financial_statements';

    
    protected $namespace = 'financial_statement';

    
    protected $multipleNestedEntities = [
        'financial_mutations' => [
            'entity' => FinancialMutation::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];
}
