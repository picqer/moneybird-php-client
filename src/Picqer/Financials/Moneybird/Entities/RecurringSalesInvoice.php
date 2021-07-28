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
 * Class RecurringSalesInvoice.
 */
class RecurringSalesInvoice extends Model
{
    use FindAll, FindOne, Storable, Removable, Filterable, Synchronizable, Noteable;

    /**
     * @var array
     */
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

    /**
     * @var string
     */
    protected $endpoint = 'recurring_sales_invoices';

    /**
     * @var string
     */
    protected $namespace = 'recurring_sales_invoice';

    /**
     * @var array
     */
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
