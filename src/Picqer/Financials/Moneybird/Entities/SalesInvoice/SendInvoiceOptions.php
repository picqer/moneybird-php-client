<?php

namespace Picqer\Financials\Moneybird\Entities\SalesInvoice;

use DateTime;
use JsonSerializable;
use InvalidArgumentException;

/**
 * Configuration options when sending an invoice.
 */
class SendInvoiceOptions implements JsonSerializable
{
    const METHOD_EMAIL = 'Email';
    const METHOD_SIMPLER_INVOICING = 'Simplerinvoicing';
    const METHOD_POST = 'Post';
    const METHOD_MANUAL = 'Manual';

    /** @var string */
    private $method;
    /** @var string|null */
    private $emailAddress;
    /** @var string */
    private $emailMessage;

    /**
     * If set to true, the e-mail is scheduled for the given $scheduleDate
     * By default it is false meaning the mail is sent immediately.
     *
     * @var bool
     */
    private $scheduled = null;
    private $scheduleDate;

    /** Undocumented boolean properties */

    /** @var bool */
    private $mergeable;
    /** @var bool */
    private $deliverUbl;

    public function __construct($deliveryMethod = null,
                                $emailAddress = null, $emailMessage = null)
    {
        $this->setMethod($deliveryMethod ?: self::METHOD_EMAIL);
        $this->setEmailAddress($emailAddress);
        $this->setEmailMessage($emailMessage);
    }

    private static function getValidMethods()
    {
        // TODO move this to a private const VALID_METHODS when php 7 is supported
        return [
            self::METHOD_EMAIL,
            self::METHOD_SIMPLER_INVOICING,
            self::METHOD_POST,
            self::METHOD_MANUAL,
        ];
    }

    public function schedule(DateTime $date)
    {
        $this->scheduleDate = $date;
        $this->scheduled = true;
    }

    public function isScheduled()
    {
        return $this->scheduled === true;
    }

    public function jsonSerialize()
    {
        return array_filter([
            'delivery_method' => $this->getMethod(),
            'sending_scheduled' => $this->isScheduled() ?: null,
            'deliver_ubl' => $this->getDeliverUbl(),
            'mergeable' => $this->getMergeable(),
            'email_address' => $this->getEmailAddress(),
            'email_message' => $this->getEmailMessage(),
            'invoice_date' => $this->getScheduleDate() ? $this->getScheduleDate()->format('Y-m-d') : null,
        ], function ($item) {
            return $item !== null;
        });
    }

    /**
     * @return mixed
     */
    public function getScheduleDate()
    {
        return $this->scheduleDate;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $validMethods = self::getValidMethods();
        if (! in_array($method, $validMethods)) {
            $method = is_object($method) ? get_class($method) : $method;
            $validMethodNames = implode(',', $validMethods);
            throw new InvalidArgumentException("Invalid method: '$method'. Expected one of: '$validMethodNames'");
        }

        $this->method = $method;
    }

    /**
     * @return null|string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @param null|string $emailAddress
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * @return string
     */
    public function getEmailMessage()
    {
        return $this->emailMessage;
    }

    /**
     * @param string $emailMessage
     */
    public function setEmailMessage($emailMessage)
    {
        $this->emailMessage = $emailMessage;
    }

    /**
     * @return bool
     */
    public function getMergeable()
    {
        return $this->mergeable;
    }

    /**
     * @param bool $mergeable
     */
    public function setMergeable($mergeable)
    {
        $this->mergeable = $mergeable;
    }

    /**
     * @return bool
     */
    public function getDeliverUbl()
    {
        return $this->deliverUbl;
    }

    /**
     * @param bool $deliverUbl
     */
    public function setDeliverUbl($deliverUbl)
    {
        $this->deliverUbl = $deliverUbl;
    }
}
