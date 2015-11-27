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
            $this->update();
        } else
        {
            $this->insert();
        }
    }

    /**
     * @return mixed
     */
    public function insert()
    {
        $result = $this->connection()->post($this->url, $this->jsonWithNamespace());

        $this->selfFromResponse($result);
    }

    /**
     * @return mixed
     */
    public function update()
    {
        $result = $this->connection()->patch($this->url . '/' . urlencode($this->id), $this->jsonWithNamespace());

        $this->selfFromResponse($result);
    }

}