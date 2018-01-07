<?php
declare(strict_types=1);

namespace Picqer\Financials\Moneybird\Connection;

use GuzzleHttp\Client;

/**
 * Base class for classes that have a guzzle http client.
 */
abstract class ClientHavingBase
{

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @var array Middlewares for the Guzzle 6 client
     */
    private $middleWares = [];

    /**
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param callable $middleWare
     *
     * @return static
     */
    public function withInsertedMiddleWare(callable $middleWare)
    {
        $clone = clone $this;
        $clone->middleWares[] = $middleWare;
        $clone->client = ConnectionUtil::createClient($clone->middleWares);
        return $clone;
    }

    /**
     * @return \GuzzleHttp\Client
     */
    protected function getClient()
    {
        return $this->client;
    }

}
