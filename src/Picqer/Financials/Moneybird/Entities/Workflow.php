<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Model;


/**
 * @property string id
 * @property string type
 * @property string name
 * @property string default
 * @property string currency
 * @property string language
 * @property string active
 * @property string prices_are_incl_tax
 * @property string created_at
 * @property string updated_at
 */
class Workflow extends Model
{
    use FindAll;

    
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

    
    protected $endpoint = 'workflows';
}
