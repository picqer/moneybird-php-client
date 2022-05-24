<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Model;


/**
 * @property string id
 * @property string name
 * @property string language
 * @property string currency
 * @property string country
 * @property string time_zone
 */
class Administration extends Model
{
    use FindAll;

    
    protected $fillable = [
        'id',
        'name',
        'language',
        'currency',
        'country',
        'time_zone',
    ];

    
    protected $endpoint = 'administrations';
}
