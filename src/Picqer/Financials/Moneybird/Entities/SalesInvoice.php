<?php

namespace Picqer\Financials\Moneybird\Entities;

use InvalidArgumentException;
use Picqer\Financials\Moneybird\Model;
use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Filterable;
use Picqer\Financials\Moneybird\Actions\Synchronizable;
use Picqer\Financials\Moneybird\Exceptions\ApiException;
use Picqer\Financials\Moneybird\Actions\PrivateDownloadable;
use Picqer\Financials\Moneybird\Entities\SalesInvoice\SendInvoiceOptions;

/**
 * Class SalesInvoice.
 *
 * @property string $id
 * @property Contact $contact
 */
class SalesInvoice extends Model
{
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
        'first_due_interval',
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
        'public_view_code',
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
        'contact' => Contact::class,
    ];

    /**
     * @var array
     */
    protected $multipleNestedEntities = [
        'custom_fields' => [
            'entity' => SalesInvoiceCustomField::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'details' => [
            'entity' => SalesInvoiceDetail::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'payments' => [
            'entity' => SalesInvoicePayment::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'notes' => [
            'entity' => Note::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];

    /**
     * Instruct Moneybird to send the invoice to the contact.
     *
     * @param string|SendInvoiceOptions $deliveryMethodOrOptions
     *
     * @return $this
     * @throws ApiException
     */
    public function sendInvoice($deliveryMethodOrOptions = SendInvoiceOptions::METHOD_EMAIL)
    {
        if (is_string($deliveryMethodOrOptions)) {
            $options = new SendInvoiceOptions($deliveryMethodOrOptions);
        } else {
            $options = $deliveryMethodOrOptions;
        }
        unset($deliveryMethodOrOptions);

        if (! $options instanceof SendInvoiceOptions) {
            $options = is_object($options) ? get_class($options) : gettype($options);
            throw new InvalidArgumentException("Expected string or options instance. Received: '$options'");
        }

        $this->connection->patch($this->endpoint . '/' . $this->id . '/send_invoice', json_encode([
            'sales_invoice_sending' => $options->jsonSerialize(),
        ]));

        return $this;
    }

    /**
     * Find SalesInvoice by invoice_id.
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
     * Register a payment for the current invoice.
     *
     * @param SalesInvoicePayment $salesInvoicePayment (payment_date and price are required)
     * @return $this
     * @throws ApiException
     */
    public function registerPayment(SalesInvoicePayment $salesInvoicePayment)
    {
        if (! isset($salesInvoicePayment->payment_date)) {
            throw new ApiException('Required [payment_date] is missing');
        }

        if (! isset($salesInvoicePayment->price)) {
            throw new ApiException('Required [price] is missing');
        }

        $this->connection()->post($this->endpoint . '/' . $this->id . '/payments',
            $salesInvoicePayment->jsonWithNamespace()
        );

        return $this;
    }

    /**
     * Delete a payment for the current invoice.
     *
     * @param SalesInvoicePayment $salesInvoicePayment (id is required)
     * @return $this
     * @throws ApiException
     */
    public function deletePayment(SalesInvoicePayment $salesInvoicePayment)
    {
        if (! isset($salesInvoicePayment->id)) {
            throw new ApiException('Required [id] is missing');
        }

        $this->connection()->delete($this->endpoint . '/' . $this->id . '/payments/' . $salesInvoicePayment->id);

        return $this;
    }

    /**
     * Add a note to the current invoice.
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

    /**
     * Register a payment for a credit invoice.
     *
     * @return \Picqer\Financials\Moneybird\Entities\SalesInvoice
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function registerPaymentForCreditInvoice()
    {
        $response = $this->connection()->patch($this->getEndpoint() . '/' . $this->id . '/register_payment_creditinvoice',
            json_encode([])	// No body needed for this call. The patch method however needs one.
        );

        return $this->makeFromResponse($response);
    }

    /**
     * Add Attachment to this invoice.
     *
     * You can use fopen('/path/to/file', 'r') in $resource.
     *
     * @param string $filename The filename of the attachment
     * @param resource $contents A StreamInterface/resource/string, @see http://docs.guzzlephp.org/en/stable/request-options.html?highlight=multipart#multipart
     *
     * @return \Picqer\Financials\Moneybird\Entities\SalesInvoice
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function addAttachment($filename, $contents)
    {
        $this->connection()->upload($this->endpoint . '/' . $this->id . '/attachments', [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => $contents,
                    'filename' => $filename,
                ],
            ],
        ]);

        return $this;
    }

    /**
     * Pauses the sales invoice. The automatic workflow steps will not be executed while the sales invoice is paused.
     *
     * @return bool
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function pauseWorkflow()
    {
        try {
            $this->connection()->post($this->endpoint . '/' . $this->id . '/pause', json_encode([]));
        } catch (ApiException $exception) {
            if (strpos($exception->getMessage(), 'The sales_invoice is already paused') !== false) {
                return true; // Everything is fine since the sales invoice was already paused we don't need an error.
            }

            throw $exception;
        }

        return true;
    }

    /**
     * Resumes the sales invoice. The automatic workflow steps will execute again after resuming.
     *
     * @return bool
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function resumeWorkflow()
    {
        try {
            $this->connection()->post($this->endpoint . '/' . $this->id . '/resume', json_encode([]));
        } catch (ApiException $exception) {
            if (strpos($exception->getMessage(), "The sales_invoice isn't paused") !== false) {
                return true; // Everything is fine since the sales invoice wasn't paused we don't need an error.
            }

            throw $exception;
        }

        return true;
    }
}
