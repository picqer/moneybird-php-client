<?php

namespace Picqer\Financials\Moneybird\Actions;

/**
 * Class FindAll.
 */
trait FindAll
{
    use BaseTrait;

    /**
     * @param array $params
     *
     * @return mixed
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function get($params = [])
    {
        $result = $this->connection()->get($this->getEndpoint(), $params);

        return $this->collectionFromResult($result);
    }

    /**
     * @param array $params
     *
     * @return mixed
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function getAll($params = [])
    {
        $result = $this->connection()->get($this->getEndpoint(), $params, true);

        return $this->collectionFromResult($result);
    }
}
