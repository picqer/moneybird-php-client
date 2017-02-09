<?php namespace Picqer\Financials\Moneybird\Actions;

/**
 * Class Filterable
 * @package Picqer\Financials\Moneybird\Actions
 */
trait Filterable
{

    /**
     * @param array $filters
     * @return mixed
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

}
