<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Model;


/**
 * @property string id
 * @property string company_name
 * @property string city
 * @property string country
 * @property string zipcode
 * @property string address1
 * @property string address2
 * @property string email
 * @property string phone
 * @property string bank_account_name
 * @property string bank_account_number
 * @property string bank_account_bic
 * @property string custom_fields
 * @property string created_at
 * @property string updated_at
 */
class Identity extends Model
{
    use FindAll, FindOne, Storable, Removable;

    
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

    
    protected $endpoint = 'identities';

    
    protected $namespace = 'identity';
}
