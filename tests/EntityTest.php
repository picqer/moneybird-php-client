<?php

/**
 * Class EntityTest
 *
 * Tests all entities to ensure entities have no PHP parse errors and have
 * at least the properties we need to use the entity
 */
class EntityTest extends \PHPUnit_Framework_TestCase
{

    public function testAdministrationEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\Administration::class);
    }

    public function testContactEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\Contact::class);
    }

    public function testContactCustomFieldEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\ContactCustomField::class);
    }

    public function testCustomFieldEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\CustomField::class);
    }

    public function testDocumentStyleEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\DocumentStyle::class);
    }

    public function testEstimateEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\Estimate::class);
    }

    public function testFinancialAccountEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\FinancialAccount::class);
    }

    public function testFinancialMutationEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\FinancialMutation::class);
    }

    public function testGeneralDocumentEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\GeneralDocument::class);
    }

    public function testGeneralJournalDocumentEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\GeneralJournalDocument::class);
    }

    public function testIdentityEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\Identity::class);
    }

    public function testImportMappingEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\ImportMapping::class);
    }

    public function testLedgerAccountEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\LedgerAccount::class);
    }

    public function testProductEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\Product::class);
    }

    public function testPurchaseInvoiceEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\PurchaseInvoice::class);
    }

    public function testPurchaseDetailInvoiceEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\PurchaseInvoiceDetail::class);
    }

    public function testReceiptEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\Receipt::class);
    }

    public function testReceiptDetailEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\ReceiptDetail::class);
    }

    public function testRecurringSalesInvoiceEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\RecurringSalesInvoice::class);
    }

    public function testRecurringSalesInvoiceDetailEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\RecurringSalesInvoiceDetail::class);
    }

    public function testSalesInvoiceEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\SalesInvoice::class);
    }

    public function testSalesInvoiceDetailEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\SalesInvoiceDetail::class);
    }

    public function testSalesInvoicePaymentEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\SalesInvoicePayment::class);
    }

    public function testSalesInvoiceReminderEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\SalesInvoiceReminder::class);
    }

    public function testNoteEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\Note::class);
    }

    public function testTaxRateEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\TaxRate::class);
    }

    public function testTypelessDocumentEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\TypelessDocument::class);
    }

    public function testWebhookEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\Webhook::class);
    }

    public function testWorkflowEntity()
    {
        $this->performEntityTest(\Picqer\Financials\Moneybird\Entities\Workflow::class);
    }

    public function testMoneybirdClass()
    {
        $reflectionClass = new ReflectionClass(\Picqer\Financials\Moneybird\Moneybird::class);

        $this->assertTrue($reflectionClass->isInstantiable());
        $this->assertTrue($reflectionClass->hasProperty('connection'));
        $this->assertEquals('Picqer\Financials\Moneybird', $reflectionClass->getNamespaceName());
    }

    private function performEntityTest($entityName)
    {
        $reflectionClass = new ReflectionClass($entityName);

        $this->assertTrue($reflectionClass->isInstantiable());
        $this->assertTrue($reflectionClass->hasProperty('fillable'));
        $this->assertTrue($reflectionClass->hasProperty('endpoint'));
        $this->assertEquals('Picqer\Financials\Moneybird\Entities', $reflectionClass->getNamespaceName());
    }

}
