<?php namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Filterable;
use Picqer\Financials\Moneybird\Model;

/**
 * Class PurchaseInvoice
 * @package Picqer\Financials\Moneybird\Entities
 */
class PurchaseInvoice extends Model
{
    use FindAll, FindOne, Storable, Removable, Filterable;

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
        'contact' => 'Contact'
    ];

    /**
     * @var array
     */
    protected $multipleNestedEntities = [
        'details' => [
            'entity' => 'PurchaseInvoiceDetail',
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];
}
