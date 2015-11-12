<?php namespace Picqer\Financials\Moneybird\Actions;

/**
 * Class FindAll
 * @package Picqer\Financials\Moneybird\Actions
 */
trait FindAll
{

    /**
     * @return mixed
     */
    public function get()
    {
        $result = $this->connection()->get($this->url);

        return $this->collectionFromResult($result);
    }

}