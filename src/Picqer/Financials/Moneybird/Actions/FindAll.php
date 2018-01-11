<?php namespace Picqer\Financials\Moneybird\Actions;

/**
 * Class FindAll
 * @package Picqer\Financials\Moneybird\Actions
 */
trait FindAll
{
    use BaseTrait;

    /**
     * @return mixed
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function get()
    {
        $result = $this->connection()->get($this->getEndpoint());

        return $this->collectionFromResult($result);
    }

    /**
     * @return mixed
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function getAll()
    {
        $result = $this->connection()->get($this->getEndpoint(), [], true);

        return $this->collectionFromResult($result);
    }

}
