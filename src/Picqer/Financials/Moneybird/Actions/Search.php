<?php namespace Picqer\Financials\Moneybird\Actions;

/**
 * Class FindAll
 * @package Picqer\Financials\Moneybird\Actions
 */
trait Search
{

    /**
     * @return mixed
     */
    public function search($query)
    {
        $result = $this->connection()->get($this->getEndpoint(), ['query' => $query], true);

        return $this->collectionFromResult($result);
    }
}
