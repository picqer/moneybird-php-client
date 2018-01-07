<?php
declare(strict_types=1);

namespace Picqer\Financials\Moneybird\Connection;

interface ApiConnectionInterface
{
    /**
     * @param bool $testing
     */
    public function setTesting($testing);

    /**
     * @return bool
     */
    public function isTesting();

    /**
     * @param int|string $administrationId
     */
    public function setAdministrationId($administrationId);

    /**
     * @param int|string $administrationId
     *
     * @return static
     */
    public function withAdministrationId($administrationId);

    /**
     * @return static
     */
    public function withoutAdministrationId();

    /**
     * @return int|string|null
     */
    public function getAdministrationId();

    /**
     * @return \GuzzleHttp\Client
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function connect();

    /**
     * @param string $url
     * @param array $params
     * @param bool $fetchAll
     *
     * @return mixed
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function get($url, array $params = [], $fetchAll = false);

    /**
     * @param string $url
     * @param string $body
     *
     * @return mixed
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function post($url, $body);

    /**
     * @param string $url
     * @param string $body
     *
     * @return mixed
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function patch($url, $body);

    /**
     * @param string $url
     *
     * @return mixed
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function delete($url);

    /**
     * @return int|string|null
     */
    public function getAccessToken();
}
