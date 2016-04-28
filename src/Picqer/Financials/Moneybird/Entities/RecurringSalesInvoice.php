<?php namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Model;

/**
 * Class RecurringSalesInvoice
 * @package Picqer\Financials\Moneybird\Entities
 */
class RecurringSalesInvoice extends Model {

    use FindAll, FindOne, Storable, Removable;

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
        'sending_scheduled_at',
        'sending_scheduled_user_id',
        'frequency_type',
        'frequency',
        'created_at',
        'updated_at',
        'details',
        'notes',
        'attachments',
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
            'entity' => 'RecurringSalesInvoiceDetail',
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];
}
