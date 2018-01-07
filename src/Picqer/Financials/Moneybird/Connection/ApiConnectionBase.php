<?php
declare(strict_types=1);

namespace Picqer\Financials\Moneybird\Connection;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Request;
use Picqer\Financials\Moneybird\Exceptions\Api\TooManyRequestsException;
use Picqer\Financials\Moneybird\Exceptions\ApiException;
use Psr\Http\Message\ResponseInterface;

abstract class ApiConnectionBase extends ClientHavingBase implements ApiConnectionInterface
{

    /**
     * @var string
     */
    private $apiUrl = 'https://moneybird.com/api/v2';

    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var bool
     */
    private $testing = false;

    /**
     * @param \GuzzleHttp\Client $client
     * @param string $accessToken
     */
    public function __construct(Client $client, string $accessToken) {
        parent::__construct($client);
        $this->accessToken = $accessToken;
    }

    /**
     * @param bool $testing
     */
    public function setTesting($testing)
    {
        $this->testing = $testing;
    }

    /**
     * @return bool
     */
    public function isTesting()
    {
        return $this->testing;
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param string|null|resource|\Psr\Http\Message\StreamInterface $body
     * @param array $params
     * @param array $headers
     *
     * @return \GuzzleHttp\Psr7\Request
     */
    private function createRequest(
        string $method = 'GET',
        string $endpoint,
        $body = null,
        array $params = [],
        array $headers = []
    ) {
        // Add default json headers to the request
        $headers = \array_merge($headers, [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);

        // If we have a token, sign the request
        $headers['Authorization'] = 'Bearer ' . $this->accessToken;

        // Create param string
        if ([] !== $params) {
            $endpoint .= '?' . \http_build_query($params);
        }

        // Create the request
        $request = new Request($method, $endpoint, $headers, $body);

        return $request;
    }

    /**
     * @param string $url
     * @param array $params
     * @param bool $fetchAll
     *
     * @return mixed
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function get($url, array $params = [], $fetchAll = false)
    {
        try {
            $request = $this->createRequest(
                'GET',
                $this->formatUrl($url, 'get'),
                null,
                $params);

            $response = $this->getClient()->send($request);

            $json = $this->parseResponse($response);

            if ($fetchAll === true) {
                if ($nextParams = $this->getNextParams($response->getHeaderLine('Link'))) {
                    $json = \array_merge(
                        $json,
                        $this->get($url, $nextParams, $fetchAll));
                }
            }

            return $json;
        }
        catch (\Exception $e) {
            throw $this->parseExceptionForErrorMessages($e);
        }
    }

    /**
     * @param string $headerLine
     * @return bool|array
     */
    private function getNextParams($headerLine)
    {
        $links = \GuzzleHttp\Psr7\parse_header($headerLine);

        foreach ($links as $link) {
            if (isset($link['rel']) && $link['rel'] === 'next') {
                $query = \parse_url(\trim($link[0], '<>'), \PHP_URL_QUERY);
                \parse_str($query, $params);

                return $params;
            }
        }

        return false;
    }

    /**
     * @param string $url
     * @param string $body
     *
     * @return mixed
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function post($url, $body)
    {
        try {
            $request = $this->createRequest('POST', $this->formatUrl($url, 'post'), $body);
            $response = $this->getClient()->send($request);

            return $this->parseResponse($response);
        }
        catch (\Exception $e) {
            throw $this->parseExceptionForErrorMessages($e);
        }
    }

    /**
     * @param string $url
     * @param string $body
     *
     * @return mixed
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function patch($url, $body)
    {
        try {
            $request = $this->createRequest('PATCH', $this->formatUrl($url, 'patch'), $body);
            $response = $this->getClient()->send($request);

            return $this->parseResponse($response);
        }
        catch (\Exception $e) {
            throw $this->parseExceptionForErrorMessages($e);
        }
    }

    /**
     * @param string $url
     *
     * @return mixed
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function delete($url)
    {
        try {
            $request = $this->createRequest(
                'DELETE',
                $this->formatUrl($url, 'delete'));

            $response = $this->getClient()->send($request);

            return $this->parseResponse($response);
        }
        catch (\Exception $e) {
            throw $this->parseExceptionForErrorMessages($e);
        }
    }

    /**
     * @param string $url
     * @param string $method
     *
     * @return string
     */
    protected function formatUrl($url, $method = 'get')
    {
        if ($this->testing) {
            return 'https://httpbin.org/' . $method;
        }

        return $this->apiUrl . '/' . $url . '.json';
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return mixed
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    private function parseResponse(ResponseInterface $response)
    {
        try {
            \GuzzleHttp\Psr7\rewind_body($response);
            $json = \json_decode($response->getBody()->getContents(), true);

            return $json;
        }
        catch (\RuntimeException $e) {
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * Parse the reponse in the Exception to return the Exact error messages
     *
     * @param \Exception $exception
     *
     * @return \Picqer\Financials\Moneybird\Exceptions\ApiException
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\Api\TooManyRequestsException
     */
    private function parseExceptionForErrorMessages(\Exception $exception)
    {
        if (!$exception instanceof BadResponseException) {
            return new ApiException($exception->getMessage(), 0, $exception);
        }

        $response = $exception->getResponse();

        if (null === $response) {
            return new ApiException('Response is NULL.', 0, $exception);
        }

        \GuzzleHttp\Psr7\rewind_body($response);
        $responseBody = $response->getBody()->getContents();
        $decodedResponseBody = \json_decode($responseBody, true);

        if (isset($decodedResponseBody['error']['message']['value'])) {
            $errorMessage = $decodedResponseBody['error']['message']['value'];
        }
        else {
            $errorMessage = $responseBody;
        }

        $this->checkWhetherRateLimitHasBeenReached($response, $errorMessage);

        return new ApiException(
            'Error ' . $response->getStatusCode() . ': ' . $errorMessage,
            $response->getStatusCode(),
            $exception);
    }

    /**
     * @param ResponseInterface $response
     * @param string $errorMessage
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\Api\TooManyRequestsException
     */
    private function checkWhetherRateLimitHasBeenReached(ResponseInterface $response, $errorMessage)
    {
        if (429 !== $response->getStatusCode()) {
            return;
        }

        $retryAfterHeaders = $response->getHeader('Retry-After');

        if (0 >= count($retryAfterHeaders)) {
            return;
        }

        $exception = new TooManyRequestsException(
            'Error ' . $response->getStatusCode() . ': ' . $errorMessage,
            $response->getStatusCode());

        $exception->retryAfterNumberOfSeconds = (int) current($retryAfterHeaders);

        throw $exception;
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function connect() {
        return $this->getClient();
    }

    /**
     * @return int|string|null
     */
    public function getAccessToken() {
        return $this->accessToken;
    }

}
