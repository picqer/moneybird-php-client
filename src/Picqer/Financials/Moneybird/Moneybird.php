<?php namespace Picqer\Financials\Moneybird;

use Picqer\Financials\Moneybird\Entities\Administration;
use Picqer\Financials\Moneybird\Entities\Contact;
use Picqer\Financials\Moneybird\Entities\ContactCustomField;
use Picqer\Financials\Moneybird\Entities\CustomField;
use Picqer\Financials\Moneybird\Entities\DocumentStyle;
use Picqer\Financials\Moneybird\Entities\FinancialAccount;
use Picqer\Financials\Moneybird\Entities\FinancialMutation;
use Picqer\Financials\Moneybird\Entities\GeneralDocument;
use Picqer\Financials\Moneybird\Entities\GeneralJournalDocument;
use Picqer\Financials\Moneybird\Entities\Identity;
use Picqer\Financials\Moneybird\Entities\ImportMapping;
use Picqer\Financials\Moneybird\Entities\LedgerAccount;
use Picqer\Financials\Moneybird\Entities\Product;
use Picqer\Financials\Moneybird\Entities\PurchaseInvoice;
use Picqer\Financials\Moneybird\Entities\Receipt;
use Picqer\Financials\Moneybird\Entities\RecurringSalesInvoice;
use Picqer\Financials\Moneybird\Entities\SalesInvoice;
use Picqer\Financials\Moneybird\Entities\SalesInvoiceDetail;
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
     * @return Administration
     */
    public function administration()
    {
        return new Administration($this->connection);
    }

    /**
     * @return Contact
     */
    public function contact()
    {
        return new Contact($this->connection);
    }

    /**
     * @return ContactCustomField
     */
    public function contactCustomField()
    {
        return new ContactCustomField($this->connection);
    }

    /**
     * @return CustomField
     */
    public function customField()
    {
        return new CustomField($this->connection);
    }

    /**
     * @return DocumentStyle
     */
    public function documentStyle()
    {
        return new DocumentStyle($this->connection);
    }

    /**
     * @return FinancialAccount
     */
    public function financialAccount()
    {
        return new FinancialAccount($this->connection);
    }

    /**
     * @return FinancialMutation
     */
    public function financialMutation()
    {
        return new FinancialMutation($this->connection);
    }

    /**
     * @return GeneralDocument
     */
    public function generalDocument()
    {
        return new GeneralDocument($this->connection);
    }

    /**
     * @return GeneralJournalDocument
     */
    public function generalJournalDocument()
    {
        return new GeneralJournalDocument($this->connection);
    }

    /**
     * @return Identity
     */
    public function identity()
    {
        return new Identity($this->connection);
    }

    /**
     * @return ImportMapping
     */
    public function importMapping()
    {
        return new ImportMapping($this->connection);
    }

    /**
     * @return LedgerAccount
     */
    public function ledgerAccount()
    {
        return new LedgerAccount($this->connection);
    }

    /**
     * @return Product
     */
    public function product()
    {
        return new Product($this->connection);
    }

    /**
     * @return PurchaseInvoice
     */
    public function purchaseInvoice()
    {
        return new PurchaseInvoice($this->connection);
    }

    /**
     * @return Receipt
     */
    public function receipt()
    {
        return new Receipt($this->connection);
    }

    /**
     * @return RecurringSalesInvoice
     */
    public function recurringSalesInvoice()
    {
        return new RecurringSalesInvoice($this->connection);
    }

    /**
     * @return SalesInvoice
     */
    public function salesInvoice()
    {
        return new SalesInvoice($this->connection);
    }

    /**
     * @return SalesInvoiceDetail
     */
    public function salesInvoiceDetail()
    {
        return new SalesInvoiceDetail($this->connection);
    }

    /**
     * @return TaxRate
     */
    public function taxRate()
    {
        return new TaxRate($this->connection);
    }

    /**
     * @return TypelessDocument
     */
    public function typelessDocument()
    {
        return new TypelessDocument($this->connection);
    }

    /**
     * @return Webhook
     */
    public function webhook()
    {
        return new Webhook($this->connection);
    }

    /**
     * @return Workflow
     */
    public function workflow()
    {
        return new Workflow($this->connection);
    }

}
