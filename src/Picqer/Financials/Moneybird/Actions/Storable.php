<?php namespace Picqer\Financials\Moneybird\Actions;

/**
 * Class Storable
 * @package Picqer\Financials\Moneybird\Actions
 */
trait Storable {

    /**
     * @return mixed
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function save()
    {
        if ($this->exists())
        {
            return $this->update();
        } else
        {
            return $this->insert();
        }
    }

    /**
     * @return mixed
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function insert()
    {
        $result = $this->connection()->post($this->getEndpoint(), $this->jsonWithNamespace());

        return $this->selfFromResponse($result);
    }

    /**
     * @return mixed
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function update()
    {
        $result = $this->connection()->patch($this->getEndpoint() . '/' . urlencode($this->id), $this->jsonWithNamespace());
        if ($result === 200) {
            return true;
        }

        return $this->selfFromResponse($result);
    }

}
