<?php namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Synchronizable;
use Picqer\Financials\Moneybird\Model;

/**
 * Class Contact
 * @package Picqer\Financials\Moneybird
 */
class Contact extends Model
{

    use FindAll, FindOne, Storable, Removable, Synchronizable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'company_name',
        'firstname',
        'lastname',
        'attention',
        'address1',
        'address2',
        'zipcode',
        'city',
        'country',
        'email',
        'phone',
        'delivery_method',
        'customer_id',
        'tax_number',
        'chamber_of_commerce',
        'bank_account',
        'send_invoices_to_attention',
        'send_invoices_to_email',
        'send_estimates_to_attention',
        'send_estimates_to_email',
        'sepa_active',
        'sepa_iban',
        'sepa_iban_account_name',
        'sepa_bic',
        'sepa_mandate_id',
        'sepa_mandate_date',
        'sepa_sequence_type',
        'credit_card_number',
        'credit_card_reference',
        'credit_card_type',
        'tax_number_validated_at',
        'created_at',
        'updated_at',
        'notes',
        'custom_fields',
        'version'
    ];

    /**
     * @var string
     */
    protected $endpoint = 'contacts';

    /**
     * @var string
     */
    protected $namespace = 'contact';

    /**
     * @var array
     */
    protected $multipleNestedEntities = [
        'custom_fields' => [
            'entity' => 'ContactCustomField',
            'type' => self::NESTING_TYPE_NESTED_OBJECTS,
        ],
    ];

    /**
     * @param string|int $customerId
     *
     * @return static
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function findByCustomerId($customerId) {
        $result = $this->connection()->get($this->getEndpoint() . '/customer_id/' . urlencode($customerId));

        return $this->makeFromResponse($result);
    }

}
