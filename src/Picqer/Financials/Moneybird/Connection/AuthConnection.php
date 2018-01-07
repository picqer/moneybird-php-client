<?php
declare(strict_types=1);

namespace Picqer\Financials\Moneybird\Connection;

use GuzzleHttp\Client;
use Picqer\Financials\Moneybird\Exceptions\ApiException;

/**
 * A special connection for:
 * - The initial redirect for authorization.
 * - Fetching the access token.
 */
class AuthConnection extends ClientHavingBase
{

    /**
     * @var string
     */
    private $authUrl = 'https://moneybird.com/oauth/authorize';

    /**
     * @var string
     */
    private $tokenUrl = 'https://moneybird.com/oauth/token';

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $clientSecret;

    /**
     * @var string
     */
    private $redirectUrl;

    /**
     * @var string[]
     */
    private $scopes = [];

    /**
     * @param string $clientId
     * @param string $clientSecret
     * @param string $redirectUrl
     * @param array $middleWares
     *
     * @return self
     *
     * @throws \Exception
     */
    public static function create(
        $clientId,
        $clientSecret,
        $redirectUrl,
        array $middleWares = [])
    {

        if ('' === $clientId || !\is_string($clientId)) {
            throw new \Exception("Missing client id.");
        }

        if ('' === $clientSecret || !\is_string($clientSecret)) {
            throw new \Exception("Missing client .");
        }

        if ('' === $redirectUrl || !\is_string($redirectUrl)) {
            throw new \Exception("Missing redirect url.");
        }

        return new self(
            $clientId,
            $clientSecret,
            $redirectUrl,
            ConnectionUtil::createClient($middleWares));
    }

    /**
     * @param string $clientId
     * @param string $clientSecret
     * @param string $redirectUrl
     * @param \GuzzleHttp\Client $client
     */
    public function __construct($clientId, $clientSecret, $redirectUrl, Client $client)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUrl = $redirectUrl;
        parent::__construct($client);
    }

    /**
     * @param string $tokenUrl
     *
     * @return \Picqer\Financials\Moneybird\Connection\AuthConnection
     */
    public function withTokenUrl($tokenUrl) {
        $clone = clone $this;
        $clone->tokenUrl = $tokenUrl;
        return $clone;
    }

    /**
     * @param string[] $scopes
     *
     * @return static
     */
    public function withScopes(array $scopes) {
        $clone = clone $this;
        $clone->scopes = $scopes;
        return $clone;
    }

    /**
     * Redirects to an authorization page.
     */
    public function redirectForAuthorization()
    {
        $authUrl = $this->getAuthUrl();
        \header('Location: ' . $authUrl);
        exit;
    }

    /**
     * @return string
     */
    public function getAuthUrl()
    {
        $query = [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUrl,
            'response_type' => 'code',
            'scope' =>  $this->scopes
                ? implode(' ', $this->scopes)
                : 'sales_invoices documents estimates bank settings',
        ];

        return $this->authUrl . '?' . \http_build_query($query);
    }

    /**
     * @param $authorizationCode
     *
     * @return string|null
     *
     * @throws \Picqer\Financials\Moneybird\Exceptions\ApiException
     */
    public function acquireAccessToken($authorizationCode)
    {

        $body = [
            'form_params' => [
                // See https://tools.ietf.org/html/rfc6749#section-4.1.3
                // @todo Do we need the redirect url?
                'redirect_uri' => $this->redirectUrl,
                'grant_type' => 'authorization_code',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'code' => $authorizationCode,
            ]
        ];

        $response = $this->getClient()->post($this->tokenUrl, $body);

        if (200 !== (int)$response->getStatusCode()) {
            throw new ApiException('Could not acquire or refresh tokens');
        }

        \GuzzleHttp\Psr7\rewind_body($response);

        $body = \json_decode($response->getBody()->getContents(), true);

        if (\json_last_error() !== \JSON_ERROR_NONE) {
            throw new ApiException(''
                . 'Could not acquire tokens, json decode failed. '
                . 'Got response: ' . $response->getBody()->getContents());
        }

        return $body['access_token'] ?? NULL;
    }

}
