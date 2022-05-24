<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Model;


/**
 * @property string id
 * @property string name
 * @property string source
 */
class CustomField extends Model
{
    use FindAll;

    
    protected $fillable = [
        'id',
        'name',
        'source',
    ];

    
    protected $endpoint = 'custom_fields';
}
