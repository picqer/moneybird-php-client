<?php

namespace Picqer\Financials\Moneybird\Entities;

use InvalidArgumentException;
use Picqer\Financials\Moneybird\Actions\Downloadable;
use Picqer\Financials\Moneybird\Actions\Filterable;
use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Noteable;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Actions\Synchronizable;
use Picqer\Financials\Moneybird\Entities\SalesInvoice\SendInvoiceOptions;
use Picqer\Financials\Moneybird\Model;


/**
 * @property string id
 * @property string administration_id
 * @property string contact_id
 * @property string contact
 * @property string estimate_id
 * @property string workflow_id
 * @property string document_style_id
 * @property string identity_id
 * @property string draft_id
 * @property string state
 * @property string estimate_date
 * @property string due_date
 * @property string reference
 * @property string language
 * @property string currency
 * @property string exchange_rate
 * @property string discount
 * @property string original_estimate_id
 * @property string show_tax
 * @property string sign_online
 * @property string sent_at
 * @property string accepted_at
 * @property string rejected_at
 * @property string archived_at
 * @property string created_at
 * @property string updated_at
 * @property string public_view_code
 * @property string version
 * @property string pre_text
 * @property string post_text
 * @property string details
 * @property string total_price_excl_tax
 * @property string total_price_excl_tax_base
 * @property string total_price_incl_tax
 * @property string total_price_incl_tax_base
 * @property string total_discount
 * @property string url
 * @property string custom_fields
 * @property string notes
 * @property string attachments
 * @property string events
 * @property string tax_totals
 * @property string prices_are_incl_tax
 */
class Estimate extends Model
{
    use FindAll, FindOne, Storable, Removable, Synchronizable, Filterable, Downloadable, Noteable;

    
    protected $fillable = [
        'id',
        'administration_id',
        'contact_id',
        'contact_person_id',
        'contact',
        'estimate_id',
        'workflow_id',
        'document_style_id',
        'identity_id',
        'draft_id',
        'state',
        'estimate_date',
        'due_date',
        'reference',
        'language',
        'currency',
        'exchange_rate',
        'discount',
        'original_estimate_id',
        'show_tax',
        'sign_online',
        'sent_at',
        'accepted_at',
        'rejected_at',
        'archived_at',
        'created_at',
        'updated_at',
        'public_view_code',
        'version',
        'pre_text',
        'post_text',
        'details',
        'total_price_excl_tax',
        'total_price_excl_tax_base',
        'total_price_incl_tax',
        'total_price_incl_tax_base',
        'total_discount',
        'url',
        'custom_fields',
        'notes',
        'attachments',
        'events',
        'tax_totals',
        'prices_are_incl_tax',
    ];

    
    protected $endpoint = 'estimates';

    
    protected $namespace = 'estimate';

    
    protected $multipleNestedEntities = [
        'custom_fields' => [
            'entity' => SalesInvoiceCustomField::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'details' => [
            'entity' => SalesInvoiceDetail::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'notes' => [
            'entity' => Note::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'events' => [
            'entity' => EstimateEvent::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'tax_totals' => [
            'entity' => EstimateTaxTotal::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];

    
    public function sendEstimate($deliveryMethodOrOptions = SendInvoiceOptions::METHOD_EMAIL)
    {
        if (is_string($deliveryMethodOrOptions)) {
            $options = new SendInvoiceOptions($deliveryMethodOrOptions);
        } else {
            $options = $deliveryMethodOrOptions;
        }
        unset($deliveryMethodOrOptions);

        if (! $options instanceof SendInvoiceOptions) {
            $options = is_object($options) ? get_class($options) : gettype($options);
            throw new InvalidArgumentException("Expected string or options instance. Received: '$options'");
        }

        $response = $this->connection->patch($this->endpoint . '/' . $this->id . '/send_estimate', json_encode([
            'estimate_sending' => $options->jsonSerialize(),
        ]));

        if (is_array($response)) {
            $this->selfFromResponse($response);
        }

        return $this;
    }
}
