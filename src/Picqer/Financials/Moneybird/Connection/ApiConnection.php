<?php
declare(strict_types=1);

namespace Picqer\Financials\Moneybird\Connection;

class ApiConnection extends ApiConnectionBase
{

    /**
     * @var string|int|null
     */
    private $administrationId;

    /**
     * @param string|int $accessToken
     * @param callable[] $middleWares
     *
     * @return \Picqer\Financials\Moneybird\Connection\ApiConnection
     */
    public static function createRoot($accessToken, array $middleWares = []) {
        return new self(
            ConnectionUtil::createClient($middleWares),
            $accessToken);
    }

    /**
     * @param int|string $administrationId
     */
    public function setAdministrationId($administrationId)
    {
        $this->administrationId = $administrationId;
    }

    /**
     * @param int|string $administrationId
     *
     * @return static
     */
    public function withAdministrationId($administrationId)
    {
        $clone = clone $this;
        $clone->administrationId = $administrationId;
        return $clone;
    }

    /**
     * @return static
     */
    public function withoutAdministrationId()
    {
        $clone = clone $this;
        $clone->administrationId = null;
        return $clone;
    }

    /**
     * @return int|string|null
     */
    public function getAdministrationId()
    {
        return $this->administrationId;
    }

    /**
     * @param string $url
     * @param string $method
     *
     * @return string
     */
    protected function formatUrl($url, $method = 'get')
    {
        if (null !== $this->administrationId) {
            $url = $this->administrationId . '/' . $url;
        }

        return parent::formatUrl($url, $method);
    }
}
