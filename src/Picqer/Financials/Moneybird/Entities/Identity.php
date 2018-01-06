<?php namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Model;

/**
 * Class Identity
 * @package Picqer\Financials\Moneybird\Entities
 *
 * @property $id
 * @property $company_name
 * @property $city
 * @property $country
 * @property $zipcode
 * @property $address1
 * @property $address2
 * @property $email
 * @property $phone
 * @property $bank_account_name
 * @property $bank_account_number
 * @property $bank_account_bic
 * @property $custom_fields
 * @property $created_at
 * @property $updated_at
 */
class Identity extends Model {

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
