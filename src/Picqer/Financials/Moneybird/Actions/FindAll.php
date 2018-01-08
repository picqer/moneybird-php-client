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
     * @param array $params
     * @return mixed
     */
    public function getAll($params = [])
    {
        $result = $this->connection()->get($this->getEndpoint(), $params, true);

        return $this->collectionFromResult($result);
    }
    
}
