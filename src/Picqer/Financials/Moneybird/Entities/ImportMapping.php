<?php namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Model;

/**
 * Class ImportMapping
 * @package Picqer\Financials\Moneybird\Entities
 */
class ImportMapping extends Model {

    use FindAll, FindOne;

    /**
     * @var array
     */
    protected $fillable = [
        'administration_id',
        'entity_type',
        'old_id',
        'new_id',
    ];

    /**
     * @var string
     */
    protected $url = 'import_mappings';
}