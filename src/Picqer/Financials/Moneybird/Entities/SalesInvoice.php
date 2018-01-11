<?php namespace Picqer\Financials\Moneybird\Entities;

use Picqer\Financials\Moneybird\Actions\Filterable;
use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\PrivateDownloadable;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Actions\Synchronizable;
use Picqer\Financials\Moneybird\Exceptions\ApiException;
use Picqer\Financials\Moneybird\Model;

/**
 * Class SalesInvoice
 * @package Picqer\Financials\Moneybird\Entities
 */
class SalesInvoice extends Model {

    use FindAll, FindOne, Storable, Removable, Filterable, PrivateDownloadable, Synchronizable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'contact_id',
        'contact',
        'invoice_id',
        'invoice_sequence_id',
        'workflow_id',
        'document_style_id',
        'identity_id',
        'state',
        'invoice_date',
        'due_date',
        'payment_conditions',
        'reference',
        'language',
        'currency',
        'prices_are_incl_tax',
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
        'version',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'sales_invoices';

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
        'custom_fields' => [
            'entity' => 'SalesInvoiceCustomField',
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'details' => [
            'entity' => 'SalesInvoiceDetail',
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'payments' => [
            'entity' => 'SalesInvoicePayment',
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'notes' => [
            'entity' => 'Note',
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];

    /**
     * Instruct Moneybird to send the invoice to the contact
     *
     * @param string $deliveryMethod Email/Post/Manual are allowed types
     * @return $this
     * @throws ApiException
     */
    public function sendInvoice($deliveryMethod = 'Email')
    {
        if (!in_array($deliveryMethod, ['Email', 'Post', 'Manual'])) {
            throw new ApiException('Invalid delivery method for sending invoice');
        }

        $this->connection->patch($this->endpoint . '/' . $this->id . '/send_invoice', json_encode([
            'sales_invoice_sending' => [
                'delivery_method' => $deliveryMethod
            ]
        ]));

        return $this;
    }

    /**
     * Find SalesInvoice by invoice_id
     *
     * @param string|int $invoiceId
     *
     * @return static
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function findByInvoiceId($invoiceId)
    {
        $result = $this->connection()->get($this->getEndpoint() . '/find_by_invoice_id/' . urlencode($invoiceId));

        return $this->makeFromResponse($result);
    }

    /**
     * Register a payment for the current invoice
     *
     * @param SalesInvoicePayment $salesInvoicePayment (payment_date and price are required)
     * @return $this
     * @throws ApiException
     */
    public function registerPayment(SalesInvoicePayment $salesInvoicePayment)
    {
        if  (! isset($salesInvoicePayment->payment_date)) {
            throw new ApiException('Required [payment_date] is missing');
        }

        if  (! isset($salesInvoicePayment->price)) {
            throw new ApiException('Required [price] is missing');
        }

        $this->connection()->post($this->endpoint . '/' . $this->id . '/payments',
            $salesInvoicePayment->jsonWithNamespace()
        );

        return $this;
    }

    /**
     * Add a note to the current invoice
     *
     * @param Note $note
     * @return $this
     * @throws ApiException
     */
    public function addNote(Note $note)
    {
        $this->connection()->post($this->endpoint . '/' . $this->id . '/notes',
            $note->jsonWithNamespace()
        );

        return $this;
    }

    /**
     * Create a credit invoice based on the current invoice.
     *
     * @return \Picqer\Financials\Moneybird\Entities\SalesInvoice
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function duplicateToCreditInvoice()
    {
        $response = $this->connection()->patch($this->getEndpoint() . '/' . $this->id . '/duplicate_creditinvoice',
            json_encode([])	// No body needed for this call. The patch method however needs one.
        );

        return $this->makeFromResponse($response);
    }
}
