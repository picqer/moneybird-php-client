<?php

namespace Picqer\Financials\Moneybird\Actions;

trait BaseTrait
{

    /**
     * @return \Picqer\Financials\Moneybird\Connection\ApiConnectionInterface
     *
     * @see \Picqer\Financials\Moneybird\Model::connection()
     */
    abstract protected function connection();

    /**
     * @return string
     *
     * @see \Picqer\Financials\Moneybird\Model::getEndpoint()
     */
    abstract protected function getEndpoint();

    /**
     * @param array $result
     *
     * @return array
     *
     * @see \Picqer\Financials\Moneybird\Model::collectionFromResult()
     */
    abstract protected function collectionFromResult($result);

    /**
     * Create a new object with the response from the API
     *
     * @param $response
     *
     * @return static
     *
     * @see \Picqer\Financials\Moneybird\Model::makeFromResponse()
     */
    abstract protected function makeFromResponse($response);

}
