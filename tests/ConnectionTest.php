<?php

use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7;

/**
 * Class ConnectionTest
 *
 * Tests the connection for proper headers, authentication and other stuff
 */
class ConnectionTest extends \PHPUnit_Framework_TestCase
{

    protected $container;

    private function getConnectionForTesting()
    {
        $this->container = [];
        $history = Middleware::history($this->container);

        $connection = new \Picqer\Financials\Moneybird\Connection();
        $connection->insertMiddleWare($history);
        $connection->setClientId('testClientId');
        $connection->setClientSecret('testClientSecret');
        $connection->setAccessToken('testAccessToken');
        $connection->setAuthorizationCode('testAuthorizationCode');
        $connection->setRedirectUrl('testRedirectUrl');
        $connection->setTesting(true);

        return $connection;
    }


    public function testClientIncludesAuthenticationHeader()
    {
        $connection = $this->getConnectionForTesting();

        $contact = new \Picqer\Financials\Moneybird\Entities\Contact($connection);
        $contact->get();

        $this->assertEquals('Bearer testAccessToken', $this->container[0]['request']->getHeaderLine('Authorization'));
    }

    public function testClientIncludesJsonHeaders()
    {
        $connection = $this->getConnectionForTesting();

        $contact = new \Picqer\Financials\Moneybird\Entities\Contact($connection);
        $contact->get();

        $this->assertEquals('application/json', $this->container[0]['request']->getHeaderLine('Accept'));
        $this->assertEquals('application/json', $this->container[0]['request']->getHeaderLine('Content-Type'));
    }

    public function testClientTriesToGetAccessTokenWhenNoneGiven()
    {
        $connection = $this->getConnectionForTesting();
        $connection->setAccessToken(null);

        $contact = new \Picqer\Financials\Moneybird\Entities\Contact($connection);
        $contact->get();

        $this->assertEquals('POST', $this->container[0]['request']->getMethod());

        Psr7\rewind_body($this->container[0]['request']);
        $this->assertEquals(
            "redirect_uri=testRedirectUrl&grant_type=authorization_code&client_id=testClientId&client_secret=testClientSecret&code=testAuthorizationCode",
            $this->container[0]['request']->getBody()->getContents()
        );
    }

    public function testClientContinuesWithRequestAfterGettingAccessTokenWhenNoneGiven()
    {
        $connection = $this->getConnectionForTesting();
        $connection->setAccessToken(null);

        $contact = new \Picqer\Financials\Moneybird\Entities\Contact($connection);
        $contact->get();

        $this->assertEquals('GET', $this->container[1]['request']->getMethod());
    }

}