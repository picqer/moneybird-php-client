<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;
use Picqer\Financials\Moneybird\Actions\Search;
use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Actions\Removable;

/**
 * Class Product.
 */
class Product extends Model
{
    use Search, FindAll, FindOne, Storable, Removable;

    /**
     * @var array
     */
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

    /**
     * @var string
     */
    protected $endpoint = 'products';

    /**
     * @var string
     */
    protected $namespace = 'product';
}
