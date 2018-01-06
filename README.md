# moneybird-php-client

[![Build Status](https://travis-ci.org/picqer/moneybird-php-client.svg?branch=master)](https://travis-ci.org/picqer/moneybird-php-client)

PHP Client for Moneybird V2

## Installation
This project can easily be installed through Composer.

```
composer require picqer/moneybird-php-client
```

## Usage
You need to have to following credentials and information ready. You can get this from your Moneybird account.
- Client ID
- Client Secret
- Callback URL

You need to be able to store some data locally:
- The three credentials mentioned above
- Authorizationcode
- Accesstoken

### Authorization code
If you have no authorization code yet, you will need this first. The client supports fetching the authorization code as follows.

```php
<?php

require __DIR__ . '/vendor/autoload.php';

$connection = new \Picqer\Financials\Moneybird\Connection();
$connection->setRedirectUrl('REDIRECTURL');
$connection->setClientId('CLIENTID');
$connection->setClientSecret('CLIENTSECRET');
$connection->redirectForAuthorization();
```

This will perform a redirect to Moneybird at which you can login and authorize the app for a specific Moneybird administration.
After login, Moneybird will redirect you to the callback URL with request param "code" which you should save as the authorization code.

### Setting the administration ID

Most methods require you to set the Administration ID to fetch the correct data. You can get the Administration ID from the URL at MoneyBird, but you can also list the administrations your user has access to running the following method after connecting. In the code samples below there's an example on how to set the first administrations from the results of the call below:

```php
$administrations = $moneybird->administration()->getAll();
```

### Normal actions
After you have the authorization code as described above, you can perform normal requests. The client will take care of the accesstoken automatically.

```php
<?php

require __DIR__ . '/vendor/autoload.php';

$connection = new \Picqer\Financials\Moneybird\Connection();
$connection->setRedirectUrl('REDIRECTURL');
$connection->setClientId('CLIENTID');
$connection->setClientSecret('CLIENTSECRET');

// Get authorization code as described in readme (always set this when available)
$connection->setAuthorizationCode('AUTHORIZATIONCODE');

// Set this in case you got the access token, otherwise client will fetch it (always set this when available)
$connection->setAccessToken('ACCESSTOKEN');

try {
    $connection->connect();
} catch (\Exception $e) {
    throw new Exception('Could not connect to Moneybird: ' . $e->getMessage());
}

// After connection save the last access token for reuse 
$connection->getAccessToken(); // will return the access token you need to save

// Set up a new Moneybird instance and inject the connection
$moneybird = new \Picqer\Financials\Moneybird\Moneybird($connection);

// Example: Get administrations and set the first result as active administration
$administrations = $moneybird->administration()->getAll();
$connection->setAdministrationId($administrations[0]['id']);

// Example: Fetch list of salesinvoices 
$salesInvoices = $moneybird->salesInvoice()->get();
var_dump($salesInvoices); // Array with SalesInvoice objects

// Example: Fetch a sales invoice
$salesInvoice = $moneybird->salesInvoice()->find(3498576378625);
var_dump($salesInvoice); // SalesInvoice object

// Example: Get sales invoice PDF contents
// *** Officially unsupported in the Moneybird API ***
$pdfContents = $salesInvoice->download();

// Example: Create credit invoice based on existing invoice
$creditInvoice = $salesInvoice->duplicateToCreditInvoice();
var_dump($creditInvoice); // SalesInvoice object

// Example: Create a new contact
$contact = $moneybird->contact();

$contact->company_name = 'Picqer';
$contact->firstname = 'Stephan';
$contact->lastname = 'Groen';
$contact->save();
var_dump($contact); // Contact object (as saved in Moneybird)

// Example: Update existing contact, change email address
$contact = $moneybird->contact()->find(89672345789233);
$contact->email = 'example@example.org';
$contact->save();
var_dump($contact); // Contact object (as saved in Moneybird)

// Example: Use the Moneybird synchronisation API
$contactVersions = $moneybird->contact()->listVersions();
var_dump($contactVersions); // Array with ids and versions to compare to your own

// Example: Use the Moneybird synchronisation API to get new versions of specific ids
$contacts = $moneybird->contact()->getVersions([
  2389475623478568,
  2384563478959922
]);
var_dump($contacts); // Array with two Contact objects

// Example: List sales invoices that are in draft (max 100)
$salesInvoices = $moneybird->salesInvoice()->filter([
  'state' => 'draft'
]);
var_dump($salesInvoices); // Array with filtered SalesInvoice objects

// Example: Get import mappings for contacts
$mappings = $moneybird->importMapping()->setType('contact')->get();
var_dump($mappings); // Array with ImportMapping objects

// Example: Register a payment for a sales invoice
$salesInvoicePayment = $moneybird->salesInvoicePayment();
$salesInvoicePayment->price = 153.75;
$salesInvoicePayment->payment_date = '2015-12-03';

$salesInvoice = $moneybird->salesInvoice()->find(3498576378625);
$salesInvoice->registerPayment($salesInvoicePayment);

// How to add SalesInvoiceDetails (invoice lines) to a SalesInvoice
$salesInvoiceDetailsArray = [];

foreach ($invoiceLines as $invoiceLine) { // Your invoice lines
   $salesInvoiceDetail = $moneybird->salesInvoiceDetail();
   $salesInvoiceDetail->price = 34.33;
   ...

   $salesInvoiceDetailsArray[] = $salesInvoiceDetail;
}

$salesInvoice = $moneybird->salesInvoice();
$salesInvoice->details = $salesInvoiceDetailsArray;

```

## Code example
See for example: [example/example.php](example/example.php)

## TODO
- Receiving webhooks support (would be nice)
- Some linked/nested entities (notes, attachments etcetera)
- Dedicated Exception for RateLimit reached and return of Retry-After value
