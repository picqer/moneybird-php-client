<?php

namespace Picqer\Financials\Moneybird\Exceptions\Api;

use Picqer\Financials\Moneybird\Exceptions\ApiException;

class TooManyRequestsException extends ApiException
{
    /**
     * Moneybird Ratelimit header: RateLimit-Remaining.
     *
     * @link https://developer.moneybird.com/#throttling
     *
     * @var int
     */
    public $retryAfterNumberOfSeconds;

    /**
     * Moneybird Ratelimit header: RateLimit-Limit.
     *
     * @link https://developer.moneybird.com/#throttling
     *
     * @var int
     */
    public $currentRateLimit;

    /**
     * Moneybird Ratelimit header: RateLimit-Reset.
     *
     * @link https://developer.moneybird.com/#throttling
     *
     * @var int
     */
    public $rateLimitResetsAfterTimestamp;
}
