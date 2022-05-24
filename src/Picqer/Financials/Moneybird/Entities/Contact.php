<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\Filterable;
use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Noteable;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Search;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Actions\Synchronizable;
use Picqer\Financials\Moneybird\Exceptions\ApiException;
use Picqer\Financials\Moneybird\Model;


/**
 * @property string id
 * @property string company_name
 * @property string firstname
 * @property string lastname
 * @property string attention
 * @property string address1
 * @property string address2
 * @property string zipcode
 * @property string city
 * @property string country
 * @property string email
 * @property string phone
 * @property string delivery_method
 * @property string customer_id
 * @property string tax_number
 * @property string chamber_of_commerce
 * @property string bank_account
 * @property string send_invoices_to_attention
 * @property string send_invoices_to_email
 * @property string send_estimates_to_attention
 * @property string send_estimates_to_email
 * @property string sepa_active
 * @property string sepa_iban
 * @property string sepa_iban_account_name
 * @property string sepa_bic
 * @property string sepa_mandate_id
 * @property string sepa_mandate_date
 * @property string sepa_sequence_type
 * @property string credit_card_number
 * @property string credit_card_reference
 * @property string credit_card_type
 * @property string invoice_workflow_id
 * @property string estimate_workflow_id
 * @property string email_ubl
 * @property string tax_number_validated_at
 * @property string created_at
 * @property string updated_at
 * @property string notes
 * @property string custom_fields
 * @property string contact_people
 * @property string version
 */
class Contact extends Model
{
    use Search, FindAll, FindOne, Storable, Removable, Filterable, Synchronizable, Noteable;

    
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
        'invoice_workflow_id',
        'estimate_workflow_id',
        'email_ubl',
        'tax_number_validated_at',
        'created_at',
        'updated_at',
        'notes',
        'custom_fields',
        'contact_people',
        'version',
    ];

    
    protected $endpoint = 'contacts';

    
    protected $namespace = 'contact';

    
    protected $filter_endpoint = 'contacts/filter';

    
    protected $multipleNestedEntities = [
        'custom_fields' => [
            'entity' => ContactCustomField::class,
            'type' => self::NESTING_TYPE_NESTED_OBJECTS,
        ],
        'contact_people' => [
            'entity' => ContactPeople::class,
            'type' => self::NESTING_TYPE_NESTED_OBJECTS,
        ],
    ];

    
    public function findByCustomerId($customerId)
    {
        $result = $this->connection()->get($this->getEndpoint() . '/customer_id/' . urlencode($customerId));

        return $this->makeFromResponse($result);
    }
}
