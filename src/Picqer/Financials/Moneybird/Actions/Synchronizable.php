<?php

namespace Picqer\Financials\Moneybird\Actions;

/**
 * Class Synchronizable.
 */
trait Synchronizable
{
    use BaseTrait;

    public function getFillable()
    {
        return array_merge(parent::getFillable(), [
            'version',
        ]);
    }

    /**
     * @param  array  $filters
     * @return mixed
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function listVersions(array $filters = [])
    {
        $filter = [];

        if (! empty($filters)) {
            $filterList = [];
            foreach ($filters as $key => $value) {
                $filterList[] = $key . ':' . $value;
            }

            $filter = ['filter' => implode(',', $filterList)];
        }

        $result = $this->connection()->get($this->getEndpoint() . '/synchronization', $filter);

        return $this->collectionFromResult($result);
    }

    /**
     * @param  array  $ids
     * @return mixed
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function getVersions(array $ids)
    {
        $result = $this->connection()->post($this->getEndpoint() . '/synchronization', json_encode([
            'ids' => $ids,
        ]));

        return $this->collectionFromResult($result);
    }
}
