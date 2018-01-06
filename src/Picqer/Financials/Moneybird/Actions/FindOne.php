<?php namespace Picqer\Financials\Moneybird\Actions;

/**
 * Class FindOne
 * @package Picqer\Financials\Moneybird\Actions
 */
trait FindOne {

    /**
     * @param string|int $id
     *
     * @return mixed
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function find($id)
    {
        $result = $this->connection()->get($this->getEndpoint() . '/' . urlencode($id));

        return $this->makeFromResponse($result);
    }

}
