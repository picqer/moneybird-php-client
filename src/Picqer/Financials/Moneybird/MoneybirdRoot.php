<?php
declare(strict_types=1);

namespace Picqer\Financials\Moneybird;

use Picqer\Financials\Moneybird\Connection\ApiConnection;
use Picqer\Financials\Moneybird\Connection\ApiConnectionInterface;
use Picqer\Financials\Moneybird\Entities\Administration;

class MoneybirdRoot
{

    /**
     * The HTTP connection
     *
     * @var \Picqer\Financials\Moneybird\Connection\ApiConnectionInterface
     */
    protected $connection;

    /**
     * @param string $accessToken
     * @param callable[] $middleWares
     *
     * @return self
     */
    public static function create($accessToken, array $middleWares = [])
    {
        $connection = ApiConnection::createRoot(
            $accessToken,
            $middleWares);

        return new self($connection);
    }

    /**
     * @param \Picqer\Financials\Moneybird\Connection\ApiConnectionInterface $connection
     */
    public function __construct(ApiConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param array $attributes
     *
     * @return \Picqer\Financials\Moneybird\Entities\Administration
     */
    public function administration(array $attributes = [])
    {
        return new Administration(
            $this->connection,
            $attributes);
    }

    /**
     * @param string|int $administrationId
     *
     * @return \Picqer\Financials\Moneybird\Moneybird
     */
    public function realm($administrationId)
    {
        return new Moneybird(
            $this->connection->withAdministrationId($administrationId));
    }
}
