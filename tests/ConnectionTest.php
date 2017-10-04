<?php

use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7;
use Picqer\Financials\Moneybird\Exceptions\Api\TooManyRequestsException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ConnectionTest
 *
 * Tests the connection for proper headers, authentication and other stuff
 */
class ConnectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Container to hold the Guzzle history (by reference)
     *
     *
     * @var array
     */
    private $container;

    /**
     * @param callable[] $additionalMiddlewares
     *
     * @return \Picqer\Financials\Moneybird\Connection
     */
    private function getConnectionForTesting($additionalMiddlewares = array())
    {
        $this->container = [];
        $history = Middleware::history($this->container);

        $connection = new \Picqer\Financials\Moneybird\Connection();
        $connection->insertMiddleWare($history);
        if(count($additionalMiddlewares) > 0){
            foreach($additionalMiddlewares as $additionalMiddleware){
                $connection->insertMiddleWare($additionalMiddleware);
            }
        }
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
            'redirect_uri=testRedirectUrl&grant_type=authorization_code&client_id=testClientId&client_secret=testClientSecret&code=testAuthorizationCode',
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

    public function testClientDetectsApiRateLimit()
    {
        $responseStatusCode = 429;
        $responseHeaderName = 'Retry-After';
        $responseHeaderValue = 300;

        //Note that middlewares are processed 'LIFO': first the response header should be added, then an exception thrown
        $additionalMiddlewares = array(
            $this->getMiddleWareThatThrowsBadResponseException($responseStatusCode),
            $this->getMiddleWareThatAddsResponseHeader($responseHeaderName, $responseHeaderValue),
        );

        $connection = $this->getConnectionForTesting($additionalMiddlewares);
        $contact = new \Picqer\Financials\Moneybird\Entities\Contact($connection);
        try {
            $contact->get();
        } catch(TooManyRequestsException $exception){
            $this->assertEquals($responseStatusCode, $exception->getCode());
            $this->assertEquals($responseHeaderValue, $exception->retryAfterNumberOfSeconds);
        }
    }

    private function getMiddleWareThatAddsResponseHeader($header, $value)
    {
        return function (callable $handler) use ($header, $value) {
            return function (RequestInterface $request, array $options) use ($handler, $header, $value) {
                $promise = $handler($request, $options);

                return $promise->then(
                    function (ResponseInterface $response) use ($header, $value) {
                        return $response->withHeader($header, $value);
                    }
                );

                $request = $request->withHeader($header, $value);

                return $handler($request, $options);
            };
        };
    }

    private function getMiddleWareThatThrowsBadResponseException($statusCode = null)
    {
        return function (callable $handler) use($statusCode) {
            return function (RequestInterface $request, array $options) use ($handler, $statusCode) {
                $promise = $handler($request, $options);

                return $promise->then(
                    function (ResponseInterface $response) use($request, $statusCode)  {
                        if(is_int($statusCode)) {
                            $response = $response->withStatus($statusCode);
                        }

                        throw new BadResponseException( 'DummyException as injected by: ' . __METHOD__, $request, $response);
                    }
                );
            };
        };
    }

}