<?php

namespace Picqer\Financials\Moneybird\Entities;

use InvalidArgumentException;
use Picqer\Financials\Moneybird\Model;
use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Filterable;
use Picqer\Financials\Moneybird\Actions\Synchronizable;
use Picqer\Financials\Moneybird\Actions\PrivateDownloadable;
use Picqer\Financials\Moneybird\Entities\SalesInvoice\SendInvoiceOptions;

/**
 * Class Contact.
 *
 * @property int $id
 * @property string $company_name
 * @property string $first_name
 * @property string $last_name
 */
class Estimate extends Model
{
    use FindAll, FindOne, Storable, Removable, Synchronizable, Filterable, PrivateDownloadable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'contact_id',
        'contact',
        'estimate_id',
        'workflow_id',
        'document_style_id',
        'identity_id',
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
        'pre_text',
        'post_text',
        'details',
        'total_price_excl_tax',
        'total_price_excl_tax_base',
        'total_price_incl_tax',
        'total_price_incl_tax_base',
        'url',
        'custom_fields',
        'notes',
        'attachments',
        'public_view_code',
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
    ];

    /**
     * Instruct Moneybird to send the estimate to the contact.
     *
     * @param string|SendInvoiceOptions $deliveryMethodOrOptions
     *
     * @return $this
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

        $this->connection->patch($this->endpoint . '/' . $this->id . '/send_estimate', json_encode([
            'estimate_sending' => $options->jsonSerialize(),
        ]));

        return $this;
    }
}
