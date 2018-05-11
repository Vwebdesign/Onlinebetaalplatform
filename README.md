# Onlinebetaalplatform
PHP wrapper for onlinebetaalplatform.nl rest api

## Usage ##

Create a new \OBP\Transactions or \OBP\Merchants instance and add a config array to constructor. The OBP instance has fluent setters for all accepted params.

## Code examples ##

### Create transaction ###

```
<?php

// Config
$config = [
    'apiKey'        => '000000000000000000',
    'sandbox'       => true,
    'baseUrl'       => 'https://www.yourdomain.com/',
];

// Create transaction
$transaction = (new \OBP\Transactions\CreateTransaction($config))
    ->setTotalPrice(100)
    ->addProduct([
        'Test product',
        100
    ])
    ->setReturnUrl('/return')
    ->setMerchantUid('mer_000000000')
    ->doRequest();

```
