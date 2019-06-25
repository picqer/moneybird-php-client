<?php

namespace PicqerTest\Financials\Moneybird\Entities;

use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Picqer\Financials\Moneybird\Connection;
use Picqer\Financials\Moneybird\Entities\Note;
use Picqer\Financials\Moneybird\Entities\Contact;
use Picqer\Financials\Moneybird\Entities\SalesInvoice;
use Picqer\Financials\Moneybird\Entities\ContactCustomField;

class ModelTest extends TestCase
{
    /** @var ObjectProphecy */
    private $connection;

    protected function setUp()
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
}
