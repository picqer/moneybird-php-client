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
     * @param string $query
     * @return mixed
     */
    public function getAll($query = '')
    {
        $result = $this->connection()->get($this->getEndpoint(), ['query' => $query], true);

        return $this->collectionFromResult($result);
    }
}
