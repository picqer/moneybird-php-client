<?php

namespace Picqer\Financials\Moneybird\Actions;

/**
 * Class Filterable.
 */
trait Filterable
{
    use BaseTrait;

    /**
     * @param array $filters
     * @param array $pager_params
     * @return mixed
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function filter(array $filters, $pager_params = false)
    {
        $filterList = [];
        foreach ($filters as $key => $value) {
            $filterList[] = $key .':' . $value;
        }

        $params['filter'] = implode(',', $filterList);
        if(isset($pager_params)){
            if(isset($pager_params['page'])){
                $params['page'] = $pager_params['page'];
            }
            if(isset($pager_params['per_page'])){
                $params['per_page'] = $pager_params['per_page'];
            }
        }

        $result = $this->connection()->get($this->getEndpoint(), $params);

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
            $filterList[] = $key . ':' . $value;
        }

        $result = $this->connection()->get($this->getEndpoint(), ['filter' => implode(',', $filterList)], true);

        return $this->collectionFromResult($result);
    }
}
