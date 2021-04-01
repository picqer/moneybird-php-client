<?php

namespace PicqerTest\Financials\Moneybird\Entities\SalesInvoice;

use DateTime;
use InvalidArgumentException;
use JsonSerializable;
use PHPUnit\Framework\TestCase;
use Picqer\Financials\Moneybird\Entities\SalesInvoice\SendInvoiceOptions;

class SendInvoiceOptionsTest extends TestCase
{
    private $validMethods = [
        SendInvoiceOptions::METHOD_EMAIL,
        SendInvoiceOptions::METHOD_SIMPLER_INVOICING,
        SendInvoiceOptions::METHOD_POST,
        SendInvoiceOptions::METHOD_MANUAL,
    ];

    public function testConstructorArguments()
    {
        $options =
            new SendInvoiceOptions(SendInvoiceOptions::METHOD_POST, 'my-email@foo.com', 'my message');
        self::assertEquals(SendInvoiceOptions::METHOD_POST, $options->getMethod());
        self::assertEquals('my-email@foo.com', $options->getEmailAddress());
        self::assertEquals('my message', $options->getEmailMessage());
    }

    public function testDefaultMethodIsEmail()
    {
        $options = new SendInvoiceOptions();
        self::assertEquals(SendInvoiceOptions::METHOD_EMAIL, $options->getMethod());
    }

    public function testMethodIsValidated()
    {
        try {
            new SendInvoiceOptions('some-invalid-method');
            self::fail('Should have thrown exception');
        } catch (InvalidArgumentException $e) {
            foreach ($this->validMethods as $validMethod) {
                self::assertStringContainsString($validMethod, $e->getMessage());
            }

            self::assertStringContainsString('some-invalid-method', $e->getMessage(),
                'Did not provide which value is invalid');
        }
    }

    public function testIsSerializable()
    {
        $options = new SendInvoiceOptions();
        self::assertInstanceOf(JsonSerializable::class, $options);
    }

    public function testSerializes()
    {
        $options = new SendInvoiceOptions(null, 'test@foo.com', 'my message');
        $options->setDeliverUbl(true);
        $options->setMergeable(true);
        $options->schedule(new DateTime('2018-01-01'));

        $json = $options->jsonSerialize();
        self::assertEquals(SendInvoiceOptions::METHOD_EMAIL, $json['delivery_method']);
        self::assertEquals(true, $json['sending_scheduled']);
        self::assertEquals(true, $json['mergeable']);
        self::assertEquals('test@foo.com', $json['email_address']);
        self::assertEquals('my message', $json['email_message']);
        self::assertEquals('2018-01-01', $json['invoice_date']);
    }

    public function testOmitsNullValues()
    {
        $options = new SendInvoiceOptions(null, 'test@foo.com');

        $json = $options->jsonSerialize();
        self::assertEquals(SendInvoiceOptions::METHOD_EMAIL, $json['delivery_method']);
        self::assertEquals('test@foo.com', $json['email_address']);

        $omittedKeys = [
            'sending_scheduled', 'email_message', 'invoice_date',
            'mergeable',
        ];
        foreach ($omittedKeys as $key) {
            self::assertArrayNotHasKey($key, $json);
        }
    }

    public function testGetSetEmailAddress()
    {
        $options = new SendInvoiceOptions();
        self::assertNull($options->getEmailAddress());

        $options->setEmailAddress('foo@bar.com');
        self::assertEquals('foo@bar.com', $options->getEmailAddress());
    }

    public function testGetSetEmailMessage()
    {
        $options = new SendInvoiceOptions();
        self::assertNull($options->getEmailAddress());

        $options->setEmailMessage('my message');
        self::assertEquals('my message', $options->getEmailMessage());
    }

    public function testGetSetSchedule()
    {
        $options = new SendInvoiceOptions();
        self::assertFalse($options->isScheduled());
        self::assertNull($options->getScheduleDate());

        $date = new DateTime();
        $options->schedule($date);

        self::assertEquals($date, $options->getScheduleDate());
        self::assertTrue($options->isScheduled());
    }

    public function testGetSetDeliverUbl()
    {
        $options = new SendInvoiceOptions();
        self::assertNull($options->getDeliverUbl());

        $options->setDeliverUbl(true);
        self::assertTrue($options->getDeliverUbl());
    }

    public function testGetSetMethod()
    {
        $options = new SendInvoiceOptions();

        foreach ($this->validMethods as $method) {
            $options->setMethod($method);
            self::assertEquals($method, $options->getMethod());
        }
    }

    public function testGetSetMergeable()
    {
        $options = new SendInvoiceOptions();
        self::assertNull($options->getMergeable());

        $options->setMergeable(true);
        self::assertTrue($options->getMergeable());
    }
}
