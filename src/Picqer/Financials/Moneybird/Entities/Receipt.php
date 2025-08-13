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
 * Class Receipt.
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
class Receipt extends Model
{
    use Filterable, FindAll, FindOne, Storable, Removable, Attachment, Noteable, Synchronizable;

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
    protected $endpoint = 'documents/receipts';

    /**
     * @var string
     */
    protected $namespace = 'receipt';

    /**
     * @var array
     */
    protected $multipleNestedEntities = [
        'attachments' => [
            'entity' => ReceiptAttachment::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'details' => [
            'entity' => ReceiptDetail::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];

    /**
     * Register a payment for the current purchase invoice.
     *
     * @param  ReceiptPayment  $receiptPayment  (payment_date and price are required)
     * @return $this
     *
     * @throws ApiException
     */
    public function registerPayment(ReceiptPayment $receiptPayment)
    {
        if (! isset($receiptPayment->payment_date)) {
            throw new ApiException('Required [payment_date] is missing');
        }

        if (! isset($receiptPayment->price)) {
            throw new ApiException('Required [price] is missing');
        }

        $this->connection()->post($this->endpoint . '/' . $this->id . '/payments',
            $receiptPayment->jsonWithNamespace()
        );

        return $this;
    }
}
