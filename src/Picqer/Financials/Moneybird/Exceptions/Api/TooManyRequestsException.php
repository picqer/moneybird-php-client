<?php

namespace Picqer\Financials\Moneybird\Exceptions\Api;

use Picqer\Financials\Moneybird\Exceptions\ApiException;

class TooManyRequestsException extends ApiException
{
    /**
     * @link https://developer.moneybird.com/#throttling
     *
     * @var int
     */
    public $retryAfterNumberOfSeconds;
}
