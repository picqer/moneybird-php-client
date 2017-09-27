<?php namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;

/**
 * Class FinancialStatement
 * @package Picqer\Financials\Moneybird\Entities
 */
class FinancialStatement extends Model {

    /**
     * @var array
     */
    protected $fillable = [
        'financial_account_id',
        'reference',
        'official_date',
        'official_balance',
        'importer_service',
        'update_journal_entries',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'financial_statements';

    /**
     * @var array
     */
    protected $multipleNestedEntities = [
        'FinancialMutation' => [
            'entity' => 'SalesInvoiceCustomField',
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];
}
