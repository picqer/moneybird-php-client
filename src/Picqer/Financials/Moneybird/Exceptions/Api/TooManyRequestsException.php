<?php

namespace Picqer\Financials\Moneybird\Exceptions\Api;

use Picqer\Financials\Moneybird\Exceptions\ApiException;

class TooManyRequestsException extends ApiException
{
    /**
     * @var int
     */
    public $retryAfterNumberOfSeconds;

    /**
     * @link https://developer.moneybird.com/#throttling
     *
     * @param int $retryAfterNumberOfSeconds
     *
     * @return TooManyRequestsException
     */
    public static function retryAfter($retryAfterNumberOfSeconds)
    {
        $exceptionMessage = sprintf('Too many requests received, API throttling has been enabled, please try again in %d seconds', $retryAfterNumberOfSeconds);
        $exception = new self($exceptionMessage);
        $exception->retryAfterNumberOfSeconds = $retryAfterNumberOfSeconds;

        return $exception;
    }
}