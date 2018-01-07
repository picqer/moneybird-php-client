<?php namespace Picqer\Financials\Moneybird;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7;
use Picqer\Financials\Moneybird\Exceptions\Api\TooManyRequestsException;
use Picqer\Financials\Moneybird\Exceptions\ApiException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Connection
 * @package Picqer\Financials\Moneybird
 */
class Connection
{
    /**
     * @var string
     */
    protected $authorizationCode;

    /**
     * @var string
     */
    protected $administrationId;

    /**
     * @var string
     */
    private $apiUrl = 'https://moneybird.com/api/v2';

    /**
     * @var string
     */
    private $authUrl = 'https://moneybird.com/oauth/authorize';

    /**
     * @var string
     */
    private $tokenUrl = 'https://moneybird.com/oauth/token';

    /**
     * @var
     */
    private $clientId;

    /**
     * @var
     */
    private $clientSecret;

    /**
     * @var
     */
    private $accessToken;

    /**
     * @var
     */
    private $redirectUrl;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var array Middlewares for the Guzzle 6 client
     */
    protected $middleWares = [];

    /**
     * @var bool
     */
    private $testing = false;

    /**
     * @var array
     */
    private $scopes = [];

    /**
     * @return Client
     */
    private function client()
    {
        if ($this->client) {
            return $this->client;
        }

        $handlerStack = HandlerStack::create();
        foreach ($this->middleWares as $middleWare) {
            $handlerStack->push($middleWare);
        }

        $this->client = new Client([
            'http_errors' => true,
            'handler' => $handlerStack,
            'expect' => false,
        ]);

        return $this->client;
    }

    /**
     * Insert a Middleware for the Guzzle Client
     * @param $middleWare
     */
    public function insertMiddleWare($middleWare)
    {
        $this->middleWares[] = $middleWare;
    }

    /**
     * @return Client
     * @throws ApiException
     */
    public function connect()
    {
        // If access token is not set or token has expired, acquire new token
        if (empty($this->accessToken)) {
            $this->acquireAccessToken();
        }

        $client = $this->client();

        return $client;
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param null $body
     * @param array $params
     * @param array $headers
     * @return Request
     */
    private function createRequest($method = 'GET', $endpoint, $body = null, array $params = [], array $headers = [])
    {
        // Add default json headers to the request
        $headers = array_merge($headers, [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);

        // If access token is not set or token has expired, acquire new token
        if (empty($this->accessToken)) {
            $this->acquireAccessToken();
        }

        // If we have a token, sign the request
        if (! empty($this->accessToken)) {
            $headers['Authorization'] = 'Bearer ' . $this->accessToken;
        }

        // Create param string
        if (!empty($params)) {
            $endpoint .= '?' . http_build_query($params);
        }

        // Create the request
        $request = new Request($method, $endpoint, $headers, $body);

        return $request;
    }

    /**
     * @param string $url
     * @param array $params
     * @param bool $fetchAll
     * @return mixed
     * @throws ApiException
     */
    public function get($url, array $params = [], $fetchAll = false)
    {
        try {
            $request = $this->createRequest('GET', $this->formatUrl($url, 'get'), null, $params);
            $response = $this->client()->send($request);

            $json = $this->parseResponse($response);

            if ($fetchAll === true) {
                if (($nextParams = $this->getNextParams($response->getHeaderLine('Link')))) {
                    $json = array_merge($json, $this->get($url, $nextParams, $fetchAll));
                }
            }

            return $json;
        } catch (Exception $e) {
            $this->parseExceptionForErrorMessages($e);
        }
    }

    /**
     * @param string $url
     * @param string $body
     * @return mixed
     * @throws ApiException
     */
    public function post($url, $body)
    {
        try {
            $request = $this->createRequest('POST', $this->formatUrl($url, 'post'), $body);
            $response = $this->client()->send($request);

            return $this->parseResponse($response);
        } catch (Exception $e) {
            $this->parseExceptionForErrorMessages($e);
        }
    }

    /**
     * @param string $url
     * @param string $body
     * @return mixed
     * @throws ApiException
     */
    public function patch($url, $body)
    {
        try {
            $request = $this->createRequest('PATCH', $this->formatUrl($url, 'patch'), $body);
            $response = $this->client()->send($request);

            return $this->parseResponse($response);
        } catch (Exception $e) {
            $this->parseExceptionForErrorMessages($e);
        }
    }

    /**
     * @param string $url
     * @return mixed
     * @throws ApiException
     */
    public function delete($url)
    {
        try {
            $request = $this->createRequest('DELETE', $this->formatUrl($url, 'delete'));
            $response = $this->client()->send($request);

            return $this->parseResponse($response);
        } catch (Exception $e) {
            $this->parseExceptionForErrorMessages($e);
        }
    }

    /**
     * @return string
     */
    private function getAuthUrl()
    {
        return $this->authUrl . '?' . http_build_query(array(
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUrl,
            'response_type' => 'code',
            'scope' => $this->scopes ? implode(' ', $this->scopes) : 'sales_invoices documents estimates bank settings'
        ));
    }

    /**
     * @param mixed $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @param mixed $clientSecret
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    /**
     * @param mixed $authorizationCode
     */
    public function setAuthorizationCode($authorizationCode)
    {
        $this->authorizationCode = $authorizationCode;
    }

    /**
     * @param mixed $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return void
     */
    public function redirectForAuthorization()
    {
        $authUrl = $this->getAuthUrl();
        header('Location: ' . $authUrl);
        exit;
    }

    /**
     * @param mixed $redirectUrl
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * @return bool
     */
    public function needsAuthentication()
    {
        return empty($this->authorizationCode);
    }

    /**
     * @param Response $response
     * @return mixed
     * @throws ApiException
     */
    private function parseResponse(Response $response)
    {
        try {
            Psr7\rewind_body($response);
            $json = json_decode($response->getBody()->getContents(), true);

            return $json;
        } catch (\RuntimeException $e) {
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * @param $headerLine
     * @return bool | array
     */
    private function getNextParams($headerLine)
    {
        $links = Psr7\parse_header($headerLine);

        foreach ($links as $link) {
            if (isset($link['rel']) && $link['rel'] === 'next') {
                $query = parse_url(trim($link[0], '<>'), PHP_URL_QUERY);
                parse_str($query, $params);

                return $params;
            }
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @throws ApiException
     */
    private function acquireAccessToken()
    {
        $body = [
            'form_params' => [
                'redirect_uri' => $this->redirectUrl,
                'grant_type' => 'authorization_code',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'code' => $this->authorizationCode,
            ]
        ];

        $response = $this->client()->post($this->getTokenUrl(), $body);

        if ($response->getStatusCode() == 200) {
            Psr7\rewind_body($response);
            $body = json_decode($response->getBody()->getContents(), true);

            if (json_last_error() === JSON_ERROR_NONE) {
                $this->accessToken = array_key_exists('access_token', $body) ? $body['access_token'] : null;
            } else {
                throw new ApiException('Could not acquire tokens, json decode failed. Got response: ' . $response->getBody()->getContents());
            }
        } else {
            throw new ApiException('Could not acquire or refresh tokens');
        }
    }

    /**
     * Parse the response in the Exception to return the Exact error messages.
     *
     * @param Exception $exception
     *
     * @throws ApiException | TooManyRequestsException
     */
    private function parseExceptionForErrorMessages(Exception $exception)
    {
        if (!$exception instanceof BadResponseException) {
            throw new ApiException($exception->getMessage());
        }

        $response = $exception->getResponse();
        Psr7\rewind_body($response);
        $responseBody = $response->getBody()->getContents();
        $decodedResponseBody = json_decode($responseBody, true);

        if (!is_null($decodedResponseBody) && isset($decodedResponseBody['error']['message']['value'])) {
            $errorMessage = $decodedResponseBody['error']['message']['value'];
        } else {
            $errorMessage = $responseBody;
        }

        $this->checkWhetherRateLimitHasBeenReached($response, $errorMessage);

        throw new ApiException('Error ' . $response->getStatusCode() . ': ' . $errorMessage, $response->getStatusCode());
    }

    /**
     * @param ResponseInterface $response
     * @param string $errorMessage
     *
     * @return void
     *
     * @throws TooManyRequestsException
     */
    private function checkWhetherRateLimitHasBeenReached(ResponseInterface $response, $errorMessage)
    {
        $retryAfterHeaders = $response->getHeader('Retry-After');
        if($response->getStatusCode() === 429 && count($retryAfterHeaders) > 0){
            $exception = new TooManyRequestsException('Error ' . $response->getStatusCode() . ': ' . $errorMessage, $response->getStatusCode());
            $exception->retryAfterNumberOfSeconds = (int) current($retryAfterHeaders);

            throw $exception;
        }
    }

    /**
     * @param string $url
     * @param string $method
     *
     * @return string
     */
    private function formatUrl($url, $method = 'get')
    {
        if ($this->testing) {
            return 'https://httpbin.org/' . $method;
        }

        return $this->apiUrl . '/' . ($this->administrationId ? $this->administrationId . '/' : '') . $url . '.json';
    }

    /**
     * @return mixed
     */
    public function getAdministrationId()
    {
        return $this->administrationId;
    }

    /**
     * @param mixed $administrationId
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
     * @return bool
     */
    public function isTesting()
    {
        return $this->testing;
    }

    /**
     * @param bool $testing
     */
    public function setTesting($testing)
    {
        $this->testing = $testing;
    }

    /**
     * @return string
     */
    public function getTokenUrl()
    {
        if ($this->testing) {
            return 'https://httpbin.org/post';
        }

        return $this->tokenUrl;
    }

    /**
     * @param array $scopes
     */
    public function setScopes($scopes)
    {
        $this->scopes = $scopes;
    }

}

