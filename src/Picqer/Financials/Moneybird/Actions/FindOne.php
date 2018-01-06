<?php namespace Picqer\Financials\Moneybird\Actions;

/**
 * Class FindOne
 * @package Picqer\Financials\Moneybird\Actions
 */
trait FindOne {

    use BaseTrait;

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $result = $this->connection()->get($this->getEndpoint() . '/' . urlencode($id));

        return $this->makeFromResponse($result);
    }

}
