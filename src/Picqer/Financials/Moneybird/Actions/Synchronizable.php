<?php namespace Picqer\Financials\Moneybird\Actions;

/**
 * Class Synchronizable
 * @package Picqer\Financials\Moneybird\Actions
 */
trait Synchronizable
{

    /**
     * @return mixed
     */
    public function listVersions()
    {
        $result = $this->connection()->get($this->getEndpoint() . '/synchronization');

        return $this->collectionFromResult($result);
    }

    /**
     * @param array $ids
     * @return mixed
     */
    public function getVersions(array $ids)
    {
        $result = $this->connection()->post($this->getEndpoint() .'/synchronization', json_encode([
            'ids' => $ids
        ]));

        return $this->collectionFromResult($result);
    }

}
