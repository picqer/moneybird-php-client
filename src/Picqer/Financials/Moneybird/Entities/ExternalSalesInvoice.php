<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\Attachment;
use Picqer\Financials\Moneybird\Actions\Downloadable;
use Picqer\Financials\Moneybird\Actions\Filterable;
use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Actions\Synchronizable;
use Picqer\Financials\Moneybird\Connection;
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
 * @property string prices_are_incl_tax
 * @property string source
 * @property string source_url
 * @property string origin
 * @property string paid_at
 * @property string total_paid
 * @property string total_unpaid
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
class ExternalSalesInvoice extends Model
{
    use FindAll, FindOne, Storable, Removable, Filterable, Downloadable, Synchronizable, Attachment;

    
    protected $fillable = [
        'id',
        'contact_id',
        'reference',
        'date',
        'due_date',
        'entry_number',
        'state',
        'currency',
        'prices_are_incl_tax',
        'source',
        'source_url',
        'origin',
        'paid_at',
        'total_paid',
        'total_unpaid',
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

    
    protected $endpoint = 'external_sales_invoices';

    
    protected $namespace = 'external_sales_invoice';

    
    protected $singleNestedEntities = [
        'contact' => Contact::class,
    ];

    
    protected $multipleNestedEntities = [
        'details' => [
            'entity' => ExternalSalesInvoiceDetail::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'payments' => [
            'entity' => ExternalSalesInvoicePayment::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];

    public function __construct(Connection $connection, array $attributes = [])
    {
        parent::__construct($connection, $attributes);

        $this->attachmentPath = 'attachment';
    }
}
