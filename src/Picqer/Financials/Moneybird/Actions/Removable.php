<?php namespace Picqer\Financials\Moneybird\Actions;

/**
 * Class Removable
 * @package Picqer\Financials\Moneybird\Actions
 */
trait Removable {

    /**
     * @return mixed
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function delete()
    {
        return $this->connection()->delete($this->getEndpoint() . '/' . urlencode($this->id));
    }

}
