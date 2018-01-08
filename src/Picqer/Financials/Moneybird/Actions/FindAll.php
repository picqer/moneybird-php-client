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
     * @param bool $fetchAll
     * @return mixed
     */
    public function getAll($params = [], $fetchAll = true)
    {
        $result = $this->connection()->get($this->getEndpoint(), $params, $fetchAll);

        return $this->collectionFromResult($result);
    }
    
}
