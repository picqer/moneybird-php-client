<?php

// Autoload composer installed libraries
require __DIR__ . '/../vendor/autoload.php';

// Set these params
$redirectUrl = 'http://example.org/callback.php';
$clientId = '';
$clientSecret = '';

// Set the administrationid to work with
$administrationId = '';

/**
 * Function to retrieve persisted data for the example
 * @param string $key
 * @return null|string
 */
function getValue($key)
{
    $storage = json_decode(file_get_contents('storage.json'), true);
    if (array_key_exists($key, $storage)) {
        return $storage[$key];
    }
    return null;
}

/**
 * Function to persist some data for the example
 * @param string $key
 * @param string $value
 */
function setValue($key, $value)
{
    $storage = json_decode(file_get_contents('storage.json'), true);
    $storage[$key] = $value;
    file_put_contents('storage.json', json_encode($storage));
}

/**
 * Function to authorize with Moneybird, this redirects to Moneybird login promt and retrieves authorization code
 * to set up requests for oAuth tokens
 *
 * @param string $redirectUrl
 * @param string $clientId
 * @param string $clientSecret
 */
function authorize($redirectUrl, $clientId, $clientSecret)
{
    $connection = new \Picqer\Financials\Moneybird\Connection();
    $connection->setRedirectUrl($redirectUrl);
    $connection->setClientId($clientId);
    $connection->setClientSecret($clientSecret);
    $connection->redirectForAuthorization();
}

/**
 * Function to connect to Moneybird, this creates the client and automatically retrieves oAuth tokens if needed
 *
 * @param string $redirectUrl
 * @param string $clientId
 * @param string $clientSecret
 *
 * @return \Picqer\Financials\Moneybird\Connection
 * @throws Exception
 */
function connect($redirectUrl, $clientId, $clientSecret)
{
    $connection = new \Picqer\Financials\Moneybird\Connection();
    $connection->setRedirectUrl($redirectUrl);
    $connection->setClientId($clientId);
    $connection->setClientSecret($clientSecret);

    // Retrieves authorizationcode from database
    if (getValue('authorizationcode')) {
        $connection->setAuthorizationCode(getValue('authorizationcode'));
    }

    // Retrieves accesstoken from database
    if (getValue('accesstoken')) {
        $connection->setAccessToken(getValue('accesstoken'));
    }

    // Make the client connect and exchange tokens
    try {
        $connection->connect();
    } catch (\Exception $e) {
        throw new Exception('Could not connect to Moneybird: ' . $e->getMessage());
    }

    // Save the new tokens for next connections
    setValue('accesstoken', $connection->getAccessToken());

    return $connection;
}

// If authorization code is returned from Moneybird, save this to use for token request
if (isset($_GET['code']) && is_null(getValue('authorizationcode'))) {
    setValue('authorizationcode', $_GET['code']);
}

// If we do not have a authorization code, authorize first to setup tokens
if (getValue('authorizationcode') === null) {
    authorize($redirectUrl, $clientId, $clientSecret);
}

// Create the Moneybird client
$connection = connect($redirectUrl, $clientId, $clientSecret);
$connection->setAdministrationId($administrationId);
$moneybird = new \Picqer\Financials\Moneybird\Moneybird($connection);

// Get the sales invoices from our administration
try {
    $salesInvoices = $moneybird->salesInvoice()->get();

    foreach ($salesInvoices as $salesInvoice) {
        var_dump($salesInvoice);
    }
} catch (\Exception $e) {
    echo get_class($e) . ' : ' . $e->getMessage();
}
