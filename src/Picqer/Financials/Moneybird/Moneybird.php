<?php namespace Picqer\Financials\Moneybird;

use Picqer\Financials\Moneybird\Entities\Administration;
use Picqer\Financials\Moneybird\Entities\Contact;
use Picqer\Financials\Moneybird\Entities\ContactCustomField;
use Picqer\Financials\Moneybird\Entities\CustomField;
use Picqer\Financials\Moneybird\Entities\DocumentStyle;
use Picqer\Financials\Moneybird\Entities\Estimate;
use Picqer\Financials\Moneybird\Entities\FinancialAccount;
use Picqer\Financials\Moneybird\Entities\FinancialMutation;
use Picqer\Financials\Moneybird\Entities\FinancialStatement;
use Picqer\Financials\Moneybird\Entities\GeneralDocument;
use Picqer\Financials\Moneybird\Entities\GeneralJournalDocument;
use Picqer\Financials\Moneybird\Entities\GeneralJournalDocumentEntry;
use Picqer\Financials\Moneybird\Entities\Identity;
use Picqer\Financials\Moneybird\Entities\ImportMapping;
use Picqer\Financials\Moneybird\Entities\LedgerAccount;
use Picqer\Financials\Moneybird\Entities\Note;
use Picqer\Financials\Moneybird\Entities\Product;
use Picqer\Financials\Moneybird\Entities\PurchaseInvoice;
use Picqer\Financials\Moneybird\Entities\PurchaseInvoiceDetail;
use Picqer\Financials\Moneybird\Entities\PurchaseInvoicePayment;
use Picqer\Financials\Moneybird\Entities\Receipt;
use Picqer\Financials\Moneybird\Entities\RecurringSalesInvoice;
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
     * @var \Picqer\Financials\Moneybird\Connection
     */
    protected $connection;

    /**
     * Moneybird constructor.
     * @param \Picqer\Financials\Moneybird\Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\Administration
     */
    public function administration($attributes = [])
    {
        return new Administration(
            $this->connection->withoutAdministrationId(),
            $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\Contact
     */
    public function contact($attributes = [])
    {
        return new Contact($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\ContactCustomField
     */
    public function contactCustomField($attributes = [])
    {
        return new ContactCustomField($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\Note
     */
    public function note($attributes = [])
    {
        return new Note($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\CustomField
     */
    public function customField($attributes = [])
    {
        return new CustomField($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\DocumentStyle
     */
    public function documentStyle($attributes = [])
    {
        return new DocumentStyle($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\Estimate
     */
    public function estimate($attributes = [])
    {
        return new Estimate($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\FinancialAccount
     */
    public function financialAccount($attributes = [])
    {
        return new FinancialAccount($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\FinancialMutation
     */
    public function financialMutation($attributes = [])
    {
        return new FinancialMutation($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\FinancialStatement
     */
    public function financialStatement($attributes = [])
    {
        return new FinancialStatement($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\GeneralDocument
     */
    public function generalDocument($attributes = [])
    {
        return new GeneralDocument($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\GeneralJournalDocument
     */
    public function generalJournalDocument($attributes = [])
    {
        return new GeneralJournalDocument($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\GeneralJournalDocumentEntry
     */
    public function generalJournalDocumentEntry($attributes = [])
    {
        return new GeneralJournalDocumentEntry($this->connection, $attributes);
    }

    /**
     * @return \Picqer\Financials\Moneybird\Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\Identity
     */
    public function identity($attributes = [])
    {
        return new Identity($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\ImportMapping
     */
    public function importMapping($attributes = [])
    {
        return new ImportMapping($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\LedgerAccount
     */
    public function ledgerAccount($attributes = [])
    {
        return new LedgerAccount($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\Product
     */
    public function product($attributes = [])
    {
        return new Product($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\PurchaseInvoice
     */
    public function purchaseInvoice($attributes = [])
    {
        return new PurchaseInvoice($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\PurchaseInvoiceDetail
     */
    public function purchaseInvoiceDetail($attributes = [])
    {
        return new PurchaseInvoiceDetail($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\PurchaseInvoicePayment
     */
    public function purchaseInvoicePayment($attributes = [])
    {
        return new PurchaseInvoicePayment($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\Receipt
     */
    public function receipt($attributes = [])
    {
        return new Receipt($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\RecurringSalesInvoice
     */
    public function recurringSalesInvoice($attributes = [])
    {
        return new RecurringSalesInvoice($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\RecurringSalesInvoiceDetail
     */
    public function recurringSalesInvoiceDetail($attributes = [])
    {
        return new RecurringSalesInvoiceDetail($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\SalesInvoice
     */
    public function salesInvoice($attributes = [])
    {
        return new SalesInvoice($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\SalesInvoiceCustomField
     */
    public function salesInvoiceCustomField($attributes = [])
    {
        return new SalesInvoiceCustomField($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\SalesInvoiceDetail
     */
    public function salesInvoiceDetail($attributes = [])
    {
        return new SalesInvoiceDetail($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\SalesInvoicePayment
     */
    public function salesInvoicePayment($attributes = [])
    {
        return new SalesInvoicePayment($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\SalesInvoiceReminder
     */
    public function salesInvoiceReminder($attributes = [])
    {
        return new SalesInvoiceReminder($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\TaxRate
     */
    public function taxRate($attributes = [])
    {
        return new TaxRate($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\TypelessDocument
     */
    public function typelessDocument($attributes = [])
    {
        return new TypelessDocument($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\Webhook
     */
    public function webhook($attributes = [])
    {
        return new Webhook($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     * @return \Picqer\Financials\Moneybird\Entities\Workflow
     */
    public function workflow($attributes = [])
    {
        return new Workflow($this->connection, $attributes);
    }

}
