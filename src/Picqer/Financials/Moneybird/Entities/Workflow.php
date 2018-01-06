<?php namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Model;

/**
 * Class Workflow
 * @package Picqer\Financials\Moneybird\Entities
 *
 * @property string|int $id
 * @property string $type
 * @property string $name
 * @property bool $default
 * @property string $currency
 * @property string $language
 * @property bool $active
 * @property bool $prices_are_incl_tax
 * @property string $created_at
 * @property string $updated_at
 */
class Workflow extends Model {

    use FindAll;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'type',
        'name',
        'default',
        'currency',
        'language',
        'active',
        'prices_are_incl_tax',
        'created_at',
        'updated_at',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'workflows';
}
