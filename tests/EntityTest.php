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
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\Administration');
    }

    public function testContactEntity()
    {
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\Contact');
    }

    public function testContactCustomFieldEntity()
    {
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\ContactCustomField');
    }

    public function testCustomFieldEntity()
    {
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\CustomField');
    }

    public function testDocumentStyleEntity()
    {
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\DocumentStyle');
    }

    public function testEstimateEntity()
    {
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\Estimate');
    }

    public function testFinancialAccountEntity()
    {
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\FinancialAccount');
    }

    public function testFinancialMutationEntity()
    {
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\Administration');
    }

    public function testGeneralDocumentEntity()
    {
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\GeneralDocument');
    }

    public function testGeneralJournalDocumentEntity()
    {
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\GeneralJournalDocument');
    }

    public function testIdentityEntity()
    {
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\Identity');
    }

    public function testImportMappingEntity()
    {
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\ImportMapping');
    }

    public function testLedgerAccountEntity()
    {
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\LedgerAccount');
    }

    public function testProductEntity()
    {
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\Product');
    }

    public function testPurchaseInvoiceEntity()
    {
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\PurchaseInvoice');
    }

    public function testPurchaseDetailInvoiceEntity()
    {
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\PurchaseInvoiceDetail');
    }

    public function testReceiptEntity()
    {
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\Receipt');
    }

    public function testRecurringSalesInvoiceEntity()
    {
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\RecurringSalesInvoice');
    }

    public function testRecurringSalesInvoiceDetailEntity()
    {
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\RecurringSalesInvoiceDetail');
    }

    public function testSalesInvoiceEntity()
    {
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\SalesInvoice');
    }

    public function testSalesInvoiceDetailEntity()
    {
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\SalesInvoiceDetail');
    }

    public function testSalesInvoicePaymentEntity()
    {
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\SalesInvoicePayment');
    }

    public function testNoteEntity()
    {
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\Note');
    }

    public function testTaxRateEntity()
    {
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\TaxRate');
    }

    public function testTypelessDocumentEntity()
    {
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\TypelessDocument');
    }

    public function testWebhookEntity()
    {
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\Webhook');
    }

    public function testWorkflowEntity()
    {
        $this->performEntityTest('\Picqer\Financials\Moneybird\Entities\Workflow');
    }

    public function testMoneybirdClass()
    {
        $reflectionClass = new ReflectionClass('\Picqer\Financials\Moneybird\Moneybird');

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
