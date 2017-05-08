<?php namespace Picqer\Financials\Moneybird\Actions;

/**
 * Class FindAll
 * @package Picqer\Financials\Moneybird\Actions
 */
trait FindAll
{

    /**
     * @return mixed
     */
    public function get()
    {
        $result = $this->connection()->get($this->getEndpoint());

        return $this->collectionFromResult($result);
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        $result = $this->connection()->get($this->getEndpoint(), [], true);

        return $this->collectionFromResult($result);
    }

}
