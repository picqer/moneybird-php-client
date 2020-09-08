<?php

namespace Picqer\Financials\Moneybird\Actions;

/**
 * Class FindAll.
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
