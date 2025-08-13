<?php

namespace Picqer\Financials\Moneybird\Entities;

use InvalidArgumentException;
use Picqer\Financials\Moneybird\Actions\Attachment;
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
 * Class Estimate.
 *
 * @property string|int $id
 * @property string|int $administration_id
 * @property string|int $contact_id
 * @property string|int $contact_person_id
 * @property Contact $contact
 * @property string|int $estimate_id
 * @property string|int $workflow_id
 * @property string|int $document_style_id
 * @property string|int $identity_id
 * @property string|int $draft_id
 * @property string $state
 * @property string $estimate_date
 * @property string $due_date
 * @property string $reference
 * @property string $language
 * @property string $currency
 * @property string $exchange_rate
 * @property string $discount
 * @property string|int $original_estimate_id
 * @property bool $show_tax
 * @property bool $sign_online
 * @property string|null $sent_at
 * @property string|null $accepted_at
 * @property string|null $rejected_at
 * @property string|null $archived_at
 * @property string $created_at
 * @property string $updated_at
 * @property string $public_view_code
 * @property int $version
 * @property string|null $pre_text
 * @property string|null $post_text
 * @property array $details
 * @property string $total_price_excl_tax
 * @property string $total_price_excl_tax_base
 * @property string $total_price_incl_tax
 * @property string $total_price_incl_tax_base
 * @property string $total_discount
 * @property string $url
 * @property array $custom_fields
 * @property array $notes
 * @property array $attachments
 * @property array $events
 * @property array $tax_totals
 * @property bool $prices_are_incl_tax
 * @property Contact $contact_person
 * @property string|int $estimate_sequence_id
 * @property string|null $public_view_code_expires_at
 */
class Estimate extends Model
{
    use Attachment, FindAll, FindOne, Storable, Removable, Synchronizable, Filterable, Downloadable, Noteable;

    /**
     * @var array
     */
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
        'contact_person',
        'estimate_sequence_id',
        'public_view_code_expires_at',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'estimates';

    /**
     * @var string
     */
    protected $namespace = 'estimate';

    /**
     * @var array
     */
    protected $multipleNestedEntities = [
        'attachments' => [
            'entity' => EstimateAttachment::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
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

    /**
     * Instruct Moneybird to send the estimate to the contact.
     *
     * @param  string|SendInvoiceOptions  $deliveryMethodOrOptions
     * @return $this
     *
     * @throws ApiException
     */
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

    /**
     * Change the state of the estimate.
     *
     * @see https://developer.moneybird.com/api/estimates/#patch_estimates_id_change_state
     *
     * @param  string  $state
     * @return $this
     *
     * @throws ApiException
     */
    public function changeState(string $state)
    {
        $response = $this->connection()->patch($this->getEndpoint() . '/' . urlencode($this->id) . '/change_state', json_encode([
            'state' => $state,
        ]));

        if (is_array($response)) {
            $this->selfFromResponse($response);
        }

        return $this;
    }
}
