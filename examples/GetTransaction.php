<?php

try {

    // Config
    $config = [
        'apiKey'        => '000000000000000000',
        'sandbox'       => true,
        'baseUrl'       => 'https://www.yourdomain.com/',
    ];

    // Create transaction
    $transaction = (new \OBP\Transactions\GetTransaction($config))
        ->setUid('tra_000000000')
        ->doRequest();

    // Show response
    var_dump($transaction);

} catch (\Exception $exception) {
    var_dump($exception);
}