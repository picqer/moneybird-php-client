<?php namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Model;

/**
 * Class FinancialMutation
 * @package Picqer\Financials\Moneybird\Entities
 */
class FinancialMutation extends Model {

    use FindAll;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'amount',
        'code',
        'date',
        'message',
        'contra_account_name',
        'contra_account_number',
        'state',
        'amount_open',
        'sepa_fields',
        'batch_reference',
        'financial_account_id',
        'currency',
        'original_amount',
        'created_at',
        'updated_at',
        'financial_statement_id',
        'processed_at',
        'payments',
        'ledger_account_bookings',
    ];

    /**
     * @var string
     */
    protected $url = 'financial_mutations';
}