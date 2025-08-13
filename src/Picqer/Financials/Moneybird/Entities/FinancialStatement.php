<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Model;

/**
 * Class FinancialStatement.
 *
 * @property string|int $id
 * @property string|int $financial_account_id
 * @property string $reference
 * @property string $official_date
 * @property string $official_balance
 * @property string $importer_service
 * @property array $financial_mutations
 */
class FinancialStatement extends Model
{
    use Storable, Removable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'financial_account_id',
        'reference',
        'official_date',
        'official_balance',
        'importer_service',
        'financial_mutations',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'financial_statements';

    /**
     * @var string
     */
    protected $namespace = 'financial_statement';

    /**
     * @var array
     */
    protected $multipleNestedEntities = [
        'financial_mutations' => [
            'entity' => FinancialMutation::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];
}
