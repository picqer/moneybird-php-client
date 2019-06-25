<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Model;
use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Filterable;
use Picqer\Financials\Moneybird\Actions\Synchronizable;
use Picqer\Financials\Moneybird\Exceptions\ApiException;

/**
 * Class PurchaseInvoice.
 */
class PurchaseInvoice extends Model
{
    use FindAll, FindOne, Storable, Removable, Filterable, Synchronizable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'contact_id',
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
        'details' => [
            'entity' => PurchaseInvoiceDetail::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];

    /**
     * Register a payment for the current purchase invoice.
     *
     * @param PurchaseInvoicePayment $purchaseInvoicePayment (payment_date and price are required)
     * @return $this
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
