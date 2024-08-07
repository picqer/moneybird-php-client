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
     * @param  int|null $perPage Number of results per page
     * @param  int|null $page Page to load, typically starts at 1
     * @return mixed
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function filter(array $filters, ?int $perPage = null, ?int $page = null)
    {
        $filterList = [];
        foreach ($filters as $key => $value) {
            $filterList[] = $key . ':' . $value;
        }

        $result = $this->connection()->get($this->getFilterEndpoint(), [
            'filter' => implode(',', $filterList),
            'per_page' => $perPage,
            'page' => $page,                             
        ], false);

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
