<?php

use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Middleware;
use GuzzleHttp\Promise\PromiseInterface;
use Picqer\Financials\Moneybird\Connection\ApiConnection;
use Picqer\Financials\Moneybird\Entities\Contact;
use Picqer\Financials\Moneybird\Exceptions\Api\TooManyRequestsException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ConnectionTest
 *
 * Tests the connection for proper headers, authentication and other stuff
 */
class ApiConnectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Container to hold the Guzzle history (by reference)
     *
     * @var array
     */
    private $container;

    /**
     * @param callable[] $additionalMiddlewares
     *
     * @return \Picqer\Financials\Moneybird\Connection\ApiConnectionInterface
     */
    private function getConnectionForTesting(array $additionalMiddlewares = [])
    {
        $this->container = [];
        $history = Middleware::history($this->container);

        array_unshift($additionalMiddlewares, $history);

        $connection = ApiConnection::createRoot(
            'testAccessToken',
            array_values($additionalMiddlewares));

        $connection->setTesting(true);

        return $connection;
    }

    /**
     * @param int $requestNumber
     *
     * @return RequestInterface
     */
    private function getRequestFromHistoryContainer($requestNumber = 0)
    {
        $this->assertArrayHasKey($requestNumber, $this->container);
        $this->assertArrayHasKey('request', $this->container[$requestNumber]);
        $this->assertInstanceOf(RequestInterface::class, $this->container[$requestNumber]['request']);

        return $this->container[$requestNumber]['request'];
    }

    /**
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function testClientIncludesAuthenticationHeader()
    {
        $connection = $this->getConnectionForTesting();

        $contact = new Contact($connection);
        $contact->get();

        $request = $this->getRequestFromHistoryContainer();

        $this->assertEquals(
            'Bearer testAccessToken',
            $request->getHeaderLine('Authorization'));
    }

    /**
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function testClientIncludesJsonHeaders()
    {
        $connection = $this->getConnectionForTesting();

        $contact = new Contact($connection);
        $contact->get();

        $request = $this->getRequestFromHistoryContainer();
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals('application/json', $request->getHeaderLine('Content-Type'));
    }

    /**
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function testClientDetectsApiRateLimit()
    {
        $responseStatusCode = 429;
        $responseHeaderName = 'Retry-After';
        $responseHeaderValue = 300;

        //Note that middlewares are processed 'LIFO': first the response header should be added, then an exception thrown
        $additionalMiddlewares = array(
            $this->getMiddleWareThatThrowsBadResponseException($responseStatusCode),
            $this->getMiddleWareThatAddsResponseHeader(
                $responseHeaderName,
                $responseHeaderValue),
        );

        $connection = $this->getConnectionForTesting($additionalMiddlewares);
        $contact = new Contact($connection);
        try {
            $contact->get();
        } catch(TooManyRequestsException $exception){
            $this->assertEquals($responseStatusCode, $exception->getCode());
            $this->assertEquals($responseHeaderValue, $exception->retryAfterNumberOfSeconds);
        } catch (BadResponseException $exception) {
            $this->fail('Wrong exception type thrown.');
        }
    }

    /**
     * @param string $header
     * @param string|int $value
     *
     * @return \Closure
     */
    private function getMiddleWareThatAddsResponseHeader($header, $value)
    {
        return function (callable $handler) use ($header, $value) {
            return function (RequestInterface $request, array $options) use ($handler, $header, $value) {
                /* @var PromiseInterface $promise */
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
                /* @var PromiseInterface $promise */
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
