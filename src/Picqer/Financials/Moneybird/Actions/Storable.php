<?php namespace Picqer\Financials\Moneybird\Actions;

/**
 * Class Storable
 * @package Picqer\Financials\Moneybird\Actions
 */
trait Storable {

    /**
     * @return mixed
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
     */
    public function insert()
    {
        $result = $this->connection()->post($this->getUrl(), $this->jsonWithNamespace());

        return $this->selfFromResponse($result);
    }

    /**
     * @return mixed
     */
    public function update()
    {
        $result = $this->connection()->patch($this->getUrl() . '/' . urlencode($this->id), $this->jsonWithNamespace());
        if ($result === 200) {
            return true;
        }

        return $this->selfFromResponse($result);
    }

}
