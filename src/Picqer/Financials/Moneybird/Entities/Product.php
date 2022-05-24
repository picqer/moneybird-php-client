<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Search;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Model;


/**
 * @property string id
 * @property string description
 * @property string price
 * @property string currency
 * @property string frequency
 * @property string frequency_type
 * @property string tax_rate_id
 * @property string ledger_account_id
 * @property string created_at
 * @property string updated_at
 */
class Product extends Model
{
    use Search, FindAll, FindOne, Storable, Removable;

    
    protected $fillable = [
        'id',
        'description',
        'price',
        'currency',
        'frequency',
        'frequency_type',
        'tax_rate_id',
        'ledger_account_id',
        'created_at',
        'updated_at',
    ];

    
    protected $endpoint = 'products';

    
    protected $namespace = 'product';
}
