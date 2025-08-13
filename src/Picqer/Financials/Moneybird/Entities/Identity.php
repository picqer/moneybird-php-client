<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Model;

/**
 * Class Identity.
 *
 * @property string|int $id
 * @property string|int $administration_id
 * @property string|null $company_name
 * @property string|null $city
 * @property string|null $country
 * @property string|null $zipcode
 * @property string|null $address1
 * @property string|null $address2
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $bank_account_name
 * @property string|null $bank_account_number
 * @property string|null $bank_account_bic
 * @property string|null $chamber_of_commerce
 * @property string|null $tax_number
 * @property array $custom_fields
 * @property string $created_at
 * @property string $updated_at
 */
class Identity extends Model
{
    use FindAll, FindOne, Storable, Removable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'administration_id',
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
        'chamber_of_commerce',
        'tax_number',
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
