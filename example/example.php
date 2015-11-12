<?php

// Autoload composer installed libraries
require __DIR__ . '/../vendor/autoload.php';

// Set these params
define('REDIRECTURL', 'http://example.org/callback.php');
define('CLIENTID', '');
define('CLIENTSECRET', '');

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
 */
function authorize()
{
    $connection = new \Picqer\Financials\Moneybird\Connection();
    $connection->setRedirectUrl(REDIRECTURL);
    $connection->setClientId(CLIENTID);
    $connection->setClientSecret(CLIENTSECRET);
    $connection->redirectForAuthorization();
}

/**
 * Function to connect to Moneybird, this creates the client and automatically retrieves oAuth tokens if needed
 *
 * @return \Picqer\Financials\Moneybird\Connection
 * @throws Exception
 */
function connect()
{
    $connection = new \Picqer\Financials\Moneybird\Connection();
    $connection->setRedirectUrl(REDIRECTURL);
    $connection->setClientId(CLIENTID);
    $connection->setClientSecret(CLIENTSECRET);

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
    authorize();
}

// Create the Moneybird client
$connection = connect();
$connection->setAdministrationId($administrationId);
$moneybird = new \Picqer\Financials\Moneybird\Moneybird($connection);

// Get the contacts from our administration
try {
    $contacts = $moneybird->salesInvoice()->get();

    foreach ($contacts as $contact) {
        var_dump($contact);
    }
} catch (\Exception $e) {
    echo get_class($e) . ' : ' . $e->getMessage();
}
