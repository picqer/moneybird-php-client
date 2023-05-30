<?php

namespace Picqer\Financials\Moneybird\Actions;

/**
 * Class Removable.
 */
trait Removable
{
    use BaseTrait;

    /**
     * @return mixed
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function delete($params = [])
    {
        return $this->connection()->delete(
            $this->getEndpoint() . '/' . urlencode($this->id),
            null,
            [$this->namespace => $params]
        );
    }
}
