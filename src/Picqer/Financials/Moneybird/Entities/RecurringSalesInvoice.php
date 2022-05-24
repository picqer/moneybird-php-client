<?php

namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\Filterable;
use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Noteable;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Actions\Synchronizable;
use Picqer\Financials\Moneybird\Model;


/**
 * @property string id
 * @property string contact_id
 * @property string contact
 * @property string workflow_id
 * @property string state
 * @property string start_date
 * @property string invoice_date
 * @property string last_date
 * @property string payment_conditions
 * @property string reference
 * @property string language
 * @property string currency
 * @property string discount
 * @property string first_due_interval
 * @property string auto_send
 * @property string mergeable
 * @property string sending_scheduled_at
 * @property string sending_scheduled_user_id
 * @property string frequency_type
 * @property string frequency
 * @property string created_at
 * @property string updated_at
 * @property string details
 * @property string notes
 * @property string attachments
 * @property string has_desired_count
 * @property string desired_count
 * @property string version
 * @property string active
 * @property string custom_fields
 * @property string prices_are_incl_tax
 * @property string total_price_excl_tax
 * @property string total_price_excl_tax_base
 * @property string total_price_incl_tax
 * @property string total_price_incl_tax_base
 */
class RecurringSalesInvoice extends Model
{
    use FindAll, FindOne, Storable, Removable, Filterable, Synchronizable, Noteable;

    
    protected $fillable = [
        'id',
        'contact_id',
        'contact',
        'workflow_id',
        'state',
        'start_date',
        'invoice_date',
        'last_date',
        'payment_conditions',
        'reference',
        'language',
        'currency',
        'discount',
        'first_due_interval',
        'auto_send',
        'mergeable',
        'sending_scheduled_at',
        'sending_scheduled_user_id',
        'frequency_type',
        'frequency',
        'created_at',
        'updated_at',
        'details',
        'notes',
        'attachments',
        'has_desired_count',
        'desired_count',
        'version',
        'active',
        'custom_fields',
        'prices_are_incl_tax',
        'total_price_excl_tax',
        'total_price_excl_tax_base',
        'total_price_incl_tax',
        'total_price_incl_tax_base',
    ];

    
    protected $endpoint = 'recurring_sales_invoices';

    
    protected $namespace = 'recurring_sales_invoice';

    
    protected $multipleNestedEntities = [
        'details' => [
            'entity' => RecurringSalesInvoiceDetail::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'custom_fields' => [
            'entity' => RecurringSalesInvoiceCustomField::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];
}
