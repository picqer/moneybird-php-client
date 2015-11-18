<?php namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\Filterable;
use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Model;

/**
 * Class SalesInvoice
 * @package Picqer\Financials\Moneybird\Entities
 */
class SalesInvoice extends Model {

    use FindAll, FindOne, Storable, Removable, Filterable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'contact_id',
        'contact',
        'invoice_id',
        'workflow_id',
        'document_style_id',
        'identity_id',
        'state',
        'invoice_date',
        'payment_conditions',
        'reference',
        'language',
        'currency',
        'discount',
        'original_sales_invoice_id',
        'paid_at',
        'sent_at',
        'created_at',
        'updated_at',
        'details',
        'payments',
        'total_paid',
        'total_unpaid',
        'total_price_excl_tax',
        'total_price_excl_tax_base',
        'total_price_incl_tax',
        'total_price_incl_tax_base',
        'url',
        'custom_fields',
        'notes',
        'attachments',
    ];

    /**
     * @var string
     */
    protected $url = 'sales_invoices';

    /**
     * @var string
     */
    protected $namespace = 'sales_invoice';

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
        'details' => 'SalesInvoiceDetail'
    ];
}