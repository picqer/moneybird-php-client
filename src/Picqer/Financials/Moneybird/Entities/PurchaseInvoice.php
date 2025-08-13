<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\Attachment;
use Picqer\Financials\Moneybird\Actions\Filterable;
use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Noteable;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Actions\Synchronizable;
use Picqer\Financials\Moneybird\Exceptions\ApiException;
use Picqer\Financials\Moneybird\Model;

/**
 * Class PurchaseInvoice.
 *
 * @property string|int $id
 * @property string|int $administration_id
 * @property string|int $contact_id
 * @property Contact $contact
 * @property string $reference
 * @property string $date
 * @property string $due_date
 * @property string $entry_number
 * @property string $state
 * @property string $currency
 * @property string $exchange_rate
 * @property bool $revenue_invoice
 * @property bool $prices_are_incl_tax
 * @property string $origin
 * @property string|null $paid_at
 * @property string $tax_number
 * @property string $total_price_excl_tax
 * @property string $total_price_excl_tax_base
 * @property string $total_price_incl_tax
 * @property string $total_price_incl_tax_base
 * @property string $created_at
 * @property string $updated_at
 * @property array $details
 * @property array $payments
 * @property array $notes
 * @property array $attachments
 * @property int $version
 * @property array $events
 */
class PurchaseInvoice extends Model
{
    use FindAll, FindOne, Storable, Removable, Filterable, Synchronizable, Attachment, Noteable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'administration_id',
        'contact_id',
        'contact',
        'reference',
        'date',
        'due_date',
        'entry_number',
        'state',
        'currency',
        'exchange_rate',
        'revenue_invoice',
        'prices_are_incl_tax',
        'origin',
        'paid_at',
        'tax_number',
        'total_price_excl_tax',
        'total_price_excl_tax_base',
        'total_price_incl_tax',
        'total_price_incl_tax_base',
        'created_at',
        'updated_at',
        'details',
        'payments',
        'notes',
        'attachments',
        'version',
        'events',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'documents/purchase_invoices';

    /**
     * @var string
     */
    protected $namespace = 'purchase_invoice';

    /**
     * @var array
     */
    protected $singleNestedEntities = [
        'contact' => Contact::class,
    ];

    /**
     * @var array
     */
    protected $multipleNestedEntities = [
        'attachments' => [
            'entity' => PurchaseInvoiceAttachment::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'details' => [
            'entity' => PurchaseInvoiceDetail::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'payments' => [
            'entity' => PurchaseInvoicePayment::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];

    /**
     * Register a payment for the current purchase invoice.
     *
     * @param  PurchaseInvoicePayment  $purchaseInvoicePayment  (payment_date and price are required)
     * @return $this
     *
     * @throws ApiException
     */
    public function registerPayment(PurchaseInvoicePayment $purchaseInvoicePayment)
    {
        if (! isset($purchaseInvoicePayment->payment_date)) {
            throw new ApiException('Required [payment_date] is missing');
        }

        if (! isset($purchaseInvoicePayment->price)) {
            throw new ApiException('Required [price] is missing');
        }

        $this->connection()->patch($this->endpoint . '/' . $this->id . '/register_payment',
            $purchaseInvoicePayment->jsonWithNamespace()
        );

        return $this;
    }
}
