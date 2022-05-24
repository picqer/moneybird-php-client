<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;


/**
 * @property string id
 * @property string name
 * @property string value
 */
class ContactCustomField extends Model
{
    
    protected $fillable = [
        'id',
        'name',
        'value',
    ];
}
