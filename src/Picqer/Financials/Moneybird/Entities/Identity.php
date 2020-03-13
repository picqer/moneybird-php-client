<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Model;

/**
 * Class Identity.
 */
class Identity extends Model
{
    use FindAll, FindOne, Storable, Removable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'company_name',
        'city',
        'country',
        'zipcode',
        'address1',
        'address2',
        'email',
        'phone',
        'bank_account_name',
        'bank_account_number',
        'bank_account_bic',
        'custom_fields',
        'created_at',
        'updated_at',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'identities';

    /**
     * @var string
     */
    protected $namespace = 'identity';
}
