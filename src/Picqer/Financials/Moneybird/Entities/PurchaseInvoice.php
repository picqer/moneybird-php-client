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
 * @property string id
 * @property string contact_id
 * @property string reference
 * @property string date
 * @property string due_date
 * @property string entry_number
 * @property string state
 * @property string currency
 * @property string exchange_rate
 * @property string revenue_invoice
 * @property string prices_are_incl_tax
 * @property string origin
 * @property string paid_at
 * @property string tax_number
 * @property string total_price_excl_tax
 * @property string total_price_excl_tax_base
 * @property string total_price_incl_tax
 * @property string total_price_incl_tax_base
 * @property string created_at
 * @property string updated_at
 * @property string details
 * @property string payments
 * @property string notes
 * @property string attachments
 * @property string version
 */
class PurchaseInvoice extends Model
{
    use FindAll, FindOne, Storable, Removable, Filterable, Synchronizable, Attachment, Noteable;

    
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

    
    protected $endpoint = 'documents/purchase_invoices';

    
    protected $namespace = 'purchase_invoice';

    
    protected $singleNestedEntities = [
        'contact' => Contact::class,
    ];

    
    protected $multipleNestedEntities = [
        'details' => [
            'entity' => PurchaseInvoiceDetail::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'payments' => [
            'entity' => PurchaseInvoicePayment::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'notes' => [
            'entity' => Note::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];

    
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
