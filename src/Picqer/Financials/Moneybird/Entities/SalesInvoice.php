<?php

namespace Picqer\Financials\Moneybird\Entities;

use InvalidArgumentException;
use Picqer\Financials\Moneybird\Actions\Attachment;
use Picqer\Financials\Moneybird\Actions\Downloadable;
use Picqer\Financials\Moneybird\Actions\Filterable;
use Picqer\Financials\Moneybird\Actions\FindAll;
use Picqer\Financials\Moneybird\Actions\FindOne;
use Picqer\Financials\Moneybird\Actions\Noteable;
use Picqer\Financials\Moneybird\Actions\Removable;
use Picqer\Financials\Moneybird\Actions\Storable;
use Picqer\Financials\Moneybird\Actions\Synchronizable;
use Picqer\Financials\Moneybird\Entities\SalesInvoice\SendInvoiceOptions;
use Picqer\Financials\Moneybird\Exceptions\ApiException;
use Picqer\Financials\Moneybird\Model;


/**
 * @property string id
 * @property string administration_id
 * @property string contact_id
 * @property string update_contact
 * @property string contact
 * @property string invoice_id
 * @property string invoice_sequence_id
 * @property string recurring_sales_invoice_id
 * @property string workflow_id
 * @property string document_style_id
 * @property string identity_id
 * @property string draft_id
 * @property string state
 * @property string invoice_date
 * @property string due_date
 * @property string first_due_interval
 * @property string payment_conditions
 * @property string payment_reference
 * @property string reference
 * @property string language
 * @property string currency
 * @property string discount
 * @property string original_sales_invoice_id
 * @property string paused
 * @property string paid_at
 * @property string sent_at
 * @property string created_at
 * @property string updated_at
 * @property string public_view_code
 * @property string version
 * @property string details
 * @property string payments
 * @property string total_paid
 * @property string total_unpaid
 * @property string total_unpaid_base
 * @property string prices_are_incl_tax
 * @property string total_price_excl_tax
 * @property string total_price_excl_tax_base
 * @property string total_price_incl_tax
 * @property string total_price_incl_tax_base
 * @property string total_discount
 * @property string marked_dubious_on
 * @property string marked_uncollectible_on
 * @property string url
 * @property string payment_url
 * @property string custom_fields
 * @property string notes
 * @property string attachments
 * @property string events
 * @property string tax_totals
 */
class SalesInvoice extends Model
{
    use FindAll, FindOne, Storable, Removable, Filterable, Downloadable, Synchronizable, Attachment, Noteable;

    
    protected $fillable = [
        'id',
        'administration_id',
        'contact_id',
        'contact_person_id',
        'update_contact',
        'contact',
        'invoice_id',
        'invoice_sequence_id',
        'recurring_sales_invoice_id',
        'workflow_id',
        'document_style_id',
        'identity_id',
        'draft_id',
        'state',
        'invoice_date',
        'due_date',
        'first_due_interval',
        'payment_conditions',
        'payment_reference',
        'reference',
        'language',
        'currency',
        'discount',
        'original_sales_invoice_id',
        'paused',
        'paid_at',
        'sent_at',
        'created_at',
        'updated_at',
        'public_view_code',
        'version',
        'details',
        'payments',
        'total_paid',
        'total_unpaid',
        'total_unpaid_base',
        'prices_are_incl_tax',
        'total_price_excl_tax',
        'total_price_excl_tax_base',
        'total_price_incl_tax',
        'total_price_incl_tax_base',
        'total_discount',
        'marked_dubious_on',
        'marked_uncollectible_on',
        'url',
        'payment_url',
        'custom_fields',
        'notes',
        'attachments',
        'events',
        'tax_totals',
    ];

    
    protected $endpoint = 'sales_invoices';

    
    protected $namespace = 'sales_invoice';

    
    protected $singleNestedEntities = [
        'contact' => Contact::class,
    ];

    
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
        'events' => [
            'entity' => SalesInvoiceEvent::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'tax_totals' => [
            'entity' => SalesInvoiceTaxTotal::class,
            'type' => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];

    
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

        $response = $this->connection->patch($this->endpoint . '/' . $this->id . '/send_invoice', json_encode([
            'sales_invoice_sending' => $options->jsonSerialize(),
        ]));

        if (is_array($response)) {
            $this->selfFromResponse($response);
        }

        return $this;
    }

    
    public function findByInvoiceId($invoiceId)
    {
        $result = $this->connection()->get($this->getEndpoint() . '/find_by_invoice_id/' . urlencode($invoiceId));

        return $this->makeFromResponse($result);
    }

    
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

    
    public function deletePayment(SalesInvoicePayment $salesInvoicePayment)
    {
        if (! isset($salesInvoicePayment->id)) {
            throw new ApiException('Required [id] is missing');
        }

        $this->connection()->delete($this->endpoint . '/' . $this->id . '/payments/' . $salesInvoicePayment->id);

        return $this;
    }

    
    public function duplicateToCreditInvoice()
    {
        $response = $this->connection()->patch($this->getEndpoint() . '/' . $this->id . '/duplicate_creditinvoice',
            json_encode([])	// No body needed for this call. The patch method however needs one.
        );

        return $this->makeFromResponse($response);
    }

    
    public function registerPaymentForCreditInvoice()
    {
        $response = $this->connection()->patch($this->getEndpoint() . '/' . $this->id . '/register_payment_creditinvoice',
            json_encode([])	// No body needed for this call. The patch method however needs one.
        );

        return $this->makeFromResponse($response);
    }

    
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

    
    public function downloadUBL()
    {
        $response = $this->connection()->download($this->getEndpoint() . '/' . urlencode($this->id) . '/download_ubl');

        return $response->getBody()->getContents();
    }

    
    public function downloadPackageSlip()
    {
        $response = $this->connection()->download($this->getEndpoint() . '/' . urlencode($this->id) . '/download_packing_slip_pdf');

        return $response->getBody()->getContents();
    }
}
