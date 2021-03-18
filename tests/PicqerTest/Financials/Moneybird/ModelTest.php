<?php

namespace PicqerTest\Financials\Moneybird\Entities;

use PHPUnit\Framework\TestCase;
use Picqer\Financials\Moneybird\Connection;
use Picqer\Financials\Moneybird\Entities\Contact;
use Picqer\Financials\Moneybird\Entities\ContactCustomField;
use Picqer\Financials\Moneybird\Entities\Note;
use Picqer\Financials\Moneybird\Entities\SalesInvoice;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;

class ModelTest extends TestCase
{
    use ProphecyTrait;

    /** @var ObjectProphecy */
    private $connection;

    protected function setUp(): void
    {
        parent::setUp();

        $this->connection = $this->prophesize(Connection::class);
    }

    public function testMakeFromResponse()
    {
        $note = new Note($this->connection->reveal());

        $id = 1;
        $noteText = __METHOD__;
        $isToDo = true;
        $dummyResponse = [
            'id' => $id,
            'note' => $noteText,
            'todo' => $isToDo,
            'fakePropertyThatShouldNotBePopulated' => ' ignoredValue',
        ];

        $note = $note->makeFromResponse($dummyResponse);

        $this->assertEquals($id, $note->id);
        $this->assertEquals($noteText, $note->note);
        $this->assertEquals($isToDo, $note->todo);
        $this->assertNull($note->fakePropertyThatShouldNotBePopulated);
    }

    public function testMakeFromResponseWithSingleNestedEntities()
    {
        $salesInvoice = new SalesInvoice($this->connection->reveal());

        $salesInvoiceId = 1;
        $contactId = 10;

        $dummyResponse = [
            'id' => $salesInvoiceId,
            'contact' => [
                'id' =>$contactId,
            ],
        ];

        $salesInvoice = $salesInvoice->makeFromResponse($dummyResponse);

        $this->assertEquals($salesInvoiceId, $salesInvoice->id);
        $this->assertInstanceOf(Contact::class, $salesInvoice->contact);
        $this->assertEquals($contactId, $salesInvoice->contact->id);
    }

    public function testMakeFromResponseWithMultipleNestedEntities()
    {
        $contact = new Contact($this->connection->reveal());

        $id = 1;
        $dummyCustomFields = [
            [
                'id' => 1,
                'name' => 'dummyCustomFieldName1',
                'value' => 'dummyCustomFieldName1',
            ],
            [
                'id' => 2,
                'name' => 'dummyCustomFieldName2',
                'value' => 'dummyCustomFieldName2',
            ],
        ];
        $dummyResponse = [
            'id' => $id,
            'custom_fields' => $dummyCustomFields,
        ];

        $contact = $contact->makeFromResponse($dummyResponse);

        $this->assertEquals($id, $contact->id);
        $this->assertCount(count($dummyCustomFields), $contact->custom_fields);
        foreach ($contact->custom_fields as $customContactField) {
            $this->assertInstanceOf(ContactCustomField::class, $customContactField);
        }
    }

    public function testRegisterAttributesAsDirty()
    {
        $invoice = new SalesInvoice($this->connection->reveal());

        $id = 1;
        $invoice_date = '2019-01-01';
        $dummyResponse = [
            'id' => $id,
            'invoice_date' => $invoice_date,
            'ignoredAttribute' => 'ignoredValue',
        ];

        $invoice = $invoice->makeFromResponse($dummyResponse);

        //check if the correct dirty values are set
        $this->assertEquals('id', $invoice->getDirty()[0]);
        $this->assertEquals('invoice_date', $invoice->getDirty()[1]);
        $this->assertEquals(2, count($invoice->getDirty()));
        $this->assertTrue($invoice->isAttributeDirty('id'));
        $this->assertTrue($invoice->isAttributeDirty('invoice_date'));
        $this->assertFalse($invoice->isAttributeDirty('unknown_key'));

        //check if the getDirtyValues from is null (new object)
        $this->assertEquals(null, $invoice->getDirtyValues()['invoice_date']['from']);
        $this->assertEquals(null, $invoice->getDirtyValues()['id']['from']);

        //check if the getDirtyValues from is filled with the new value (new object)
        $this->assertEquals($id, $invoice->getDirtyValues()['id']['to']);
        $this->assertEquals($invoice_date, $invoice->getDirtyValues()['invoice_date']['to']);
    }
}
