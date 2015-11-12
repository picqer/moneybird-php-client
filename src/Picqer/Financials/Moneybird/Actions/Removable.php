<?php namespace Picqer\Financials\Moneybird\Actions;

/**
 * Class Removable
 * @package Picqer\Financials\Moneybird\Actions
 */
trait Removable {

    /**
     * @return mixed
     */
    public function delete()
    {
        return $this->connection()->delete($this->url . '/' . urlencode($this->id));
    }

}