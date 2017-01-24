<?php namespace Picqer\Financials\Moneybird;

use Picqer\Financials\Moneybird\Entities\Administration;
use Picqer\Financials\Moneybird\Entities\Contact;
use Picqer\Financials\Moneybird\Entities\ContactCustomField;
use Picqer\Financials\Moneybird\Entities\CustomField;
use Picqer\Financials\Moneybird\Entities\DocumentStyle;
use Picqer\Financials\Moneybird\Entities\Estimate;
use Picqer\Financials\Moneybird\Entities\FinancialAccount;
use Picqer\Financials\Moneybird\Entities\FinancialMutation;
use Picqer\Financials\Moneybird\Entities\GeneralDocument;
use Picqer\Financials\Moneybird\Entities\GeneralJournalDocument;
use Picqer\Financials\Moneybird\Entities\GeneralJournalDocumentEntry;
use Picqer\Financials\Moneybird\Entities\Identity;
use Picqer\Financials\Moneybird\Entities\ImportMapping;
use Picqer\Financials\Moneybird\Entities\LedgerAccount;
use Picqer\Financials\Moneybird\Entities\Product;
use Picqer\Financials\Moneybird\Entities\PurchaseInvoice;
use Picqer\Financials\Moneybird\Entities\PurchaseInvoiceDetail;
use Picqer\Financials\Moneybird\Entities\PurchaseInvoicePayment;
use Picqer\Financials\Moneybird\Entities\Receipt;
use Picqer\Financials\Moneybird\Entities\RecurringSalesInvoice;
use Picqer\Financials\Moneybird\Entities\Note;
use Picqer\Financials\Moneybird\Entities\RecurringSalesInvoiceDetail;
use Picqer\Financials\Moneybird\Entities\SalesInvoice;
use Picqer\Financials\Moneybird\Entities\SalesInvoiceCustomField;
use Picqer\Financials\Moneybird\Entities\SalesInvoiceDetail;
use Picqer\Financials\Moneybird\Entities\SalesInvoicePayment;
use Picqer\Financials\Moneybird\Entities\SalesInvoiceReminder;
use Picqer\Financials\Moneybird\Entities\TaxRate;
use Picqer\Financials\Moneybird\Entities\TypelessDocument;
use Picqer\Financials\Moneybird\Entities\Webhook;
use Picqer\Financials\Moneybird\Entities\Workflow;

/**
 * Class Moneybird
 * @package Picqer\Financials\Moneybird
 */
class Moneybird
{

    /**
     * The HTTP connection
     *
     * @var Connection
     */
    protected $connection;

    /**
     * Moneybird constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param array $attributes
     * @return Administration
     */
    public function administration($attributes = [])
    {
        return new Administration($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return Contact
     */
    public function contact($attributes = [])
    {
        return new Contact($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return ContactCustomField
     */
    public function contactCustomField($attributes = [])
    {
        return new ContactCustomField($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return Note
     */
    public function note($attributes = [])
    {
        return new Note($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return CustomField
     */
    public function customField($attributes = [])
    {
        return new CustomField($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return DocumentStyle
     */
    public function documentStyle($attributes = [])
    {
        return new DocumentStyle($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return Estimate
     */
    public function estimate($attributes = [])
    {
        return new Estimate($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return FinancialAccount
     */
    public function financialAccount($attributes = [])
    {
        return new FinancialAccount($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return FinancialMutation
     */
    public function financialMutation($attributes = [])
    {
        return new FinancialMutation($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return GeneralDocument
     */
    public function generalDocument($attributes = [])
    {
        return new GeneralDocument($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return GeneralJournalDocument
     */
    public function generalJournalDocument($attributes = [])
    {
        return new GeneralJournalDocument($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return GeneralJournalDocumentEntry
     */
    public function generalJournalDocumentEntry($attributes = [])
    {
        return new GeneralJournalDocumentEntry($this->connection, $attributes);
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param array $attributes
     * @return Identity
     */
    public function identity($attributes = [])
    {
        return new Identity($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return ImportMapping
     */
    public function importMapping($attributes = [])
    {
        return new ImportMapping($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return LedgerAccount
     */
    public function ledgerAccount($attributes = [])
    {
        return new LedgerAccount($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return Product
     */
    public function product($attributes = [])
    {
        return new Product($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return PurchaseInvoice
     */
    public function purchaseInvoice($attributes = [])
    {
        return new PurchaseInvoice($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return PurchaseInvoiceDetail
     */
    public function purchaseInvoiceDetail($attributes = [])
    {
        return new PurchaseInvoiceDetail($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return PurchaseInvoicePayment
     */
    public function purchaseInvoicePayment($attributes = [])
    {
        return new PurchaseInvoicePayment($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return Receipt
     */
    public function receipt($attributes = [])
    {
        return new Receipt($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return RecurringSalesInvoice
     */
    public function recurringSalesInvoice($attributes = [])
    {
        return new RecurringSalesInvoice($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return RecurringSalesInvoiceDetail
     */
    public function recurringSalesInvoiceDetail($attributes = [])
    {
        return new RecurringSalesInvoiceDetail($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return SalesInvoice
     */
    public function salesInvoice($attributes = [])
    {
        return new SalesInvoice($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return SalesInvoiceCustomField
     */
    public function salesInvoiceCustomField($attributes = [])
    {
        return new SalesInvoiceCustomField($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return SalesInvoiceDetail
     */
    public function salesInvoiceDetail($attributes = [])
    {
        return new SalesInvoiceDetail($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return SalesInvoicePayment
     */
    public function salesInvoicePayment($attributes = [])
    {
        return new SalesInvoicePayment($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return SalesInvoiceReminder
     */
    public function salesInvoiceReminder($attributes = [])
    {
        return new SalesInvoiceReminder($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return TaxRate
     */
    public function taxRate($attributes = [])
    {
        return new TaxRate($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return TypelessDocument
     */
    public function typelessDocument($attributes = [])
    {
        return new TypelessDocument($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return Webhook
     */
    public function webhook($attributes = [])
    {
        return new Webhook($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return Workflow
     */
    public function workflow($attributes = [])
    {
        return new Workflow($this->connection, $attributes);
    }

}
