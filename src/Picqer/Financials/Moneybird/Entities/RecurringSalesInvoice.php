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
 *
 * @property string|int $id
 * @property string|int $administration_id
 * @property string|int $contact_id
 * @property Contact $contact
 * @property string|int|null $contact_person_id
 * @property Contact $contact_person
 * @property string|int $workflow_id
 * @property string $state
 * @property string $start_date
 * @property string $invoice_date
 * @property string $last_date
 * @property string $payment_conditions
 * @property string $reference
 * @property string $language
 * @property string $currency
 * @property string $discount
 * @property string $first_due_interval
 * @property bool $auto_send
 * @property bool $mergeable
 * @property string|null $sending_scheduled_at
 * @property string|int|null $sending_scheduled_user_id
 * @property string $frequency_type
 * @property string $frequency
 * @property string $created_at
 * @property string $updated_at
 * @property array $details
 * @property array $notes
 * @property array $attachments
 * @property bool $has_desired_count
 * @property int $desired_count
 * @property int $version
 * @property bool $active
 * @property array $custom_fields
 * @property bool $prices_are_incl_tax
 * @property string $total_price_excl_tax
 * @property string $total_price_excl_tax_base
 * @property string $total_price_incl_tax
 * @property string $total_price_incl_tax_base
 * @property array $events
 * @property array $subscription
 */
class RecurringSalesInvoice extends Model
{
    use FindAll, FindOne, Storable, Removable, Filterable, Synchronizable, Noteable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'administration_id',
        'contact_id',
        'contact',
        'contact_person_id',
        'contact_person',
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
        'events',
        'subscription',
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
