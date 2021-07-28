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
    public function search($query, $perPage = null, $page = null)
    {
        $result = $this->connection()->get($this->getEndpoint(), [
            'query' => $query,
            'per_page' => $perPage,
            'page' => $page,
        ], true);

        return $this->collectionFromResult($result);
    }
}
