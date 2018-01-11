<?php namespace Picqer\Financials\Moneybird\Actions;

/**
 * Class Filterable
 * @package Picqer\Financials\Moneybird\Actions
 */
trait Filterable
{
    use BaseTrait;

    /**
     * @param array $filters
     * @return mixed
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function filter(array $filters)
    {
        $filterList = [];
        foreach ($filters as $key => $value) {
            $filterList[] = $key .':' . $value;
        }

        $result = $this->connection()->get($this->getEndpoint(), ['filter' => implode(',', $filterList)]);

        return $this->collectionFromResult($result);
    }

    /**
     * @param array $filters
     * @return mixed
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function filterAll(array $filters)
    {
        $filterList = [];
        foreach ($filters as $key => $value) {
            $filterList[] = $key .':' . $value;
        }

        $result = $this->connection()->get($this->getEndpoint(), ['filter' => implode(',', $filterList)], true);

        return $this->collectionFromResult($result);
    }

}
