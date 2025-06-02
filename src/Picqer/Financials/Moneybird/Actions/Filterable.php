<?php

namespace Picqer\Financials\Moneybird\Actions;

/**
 * Class Filterable.
 */
trait Filterable
{
    use BaseTrait;

    /**
     * @param  array  $filters
     * @param  int|null  $perPage  Number of results per page
     * @param  int|null  $page  Page to load, typically starts at 1.
     * @param  bool  $fetchAll  Whether to fetch all results or just the current page, this will override perPage and page parameters.
     * @return mixed
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function filter(array $filters, $perPage = null, $page = null, $fetchAll = false)
    {
        $filterList = [];
        foreach ($filters as $key => $value) {
            $filterList[] = $key . ':' . $value;
        }

        if($fetchAll === true) {
            $perPage = null; // If fetching all, perPage should not be set
            $page = null; // If fetching all, page should not be set
        }

        $result = $this->connection()->get($this->getFilterEndpoint(), [
            'filter' => implode(',', $filterList),
            'per_page' => $perPage,
            'page' => $page,
        ], $fetchAll);

        return $this->collectionFromResult($result);
    }

    /**
     * @param  array  $filters
     * @return mixed
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function filterAll(array $filters)
    {
        $filterList = [];
        foreach ($filters as $key => $value) {
            $filterList[] = $key . ':' . $value;
        }

        $result = $this->connection()->get($this->getFilterEndpoint(), ['filter' => implode(',', $filterList)], true);

        return $this->collectionFromResult($result);
    }
}
