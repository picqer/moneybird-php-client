<?php namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Model;

/**
 * Class Workflow
 * @package Picqer\Financials\Moneybird\Entities
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
