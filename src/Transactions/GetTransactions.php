<?php

namespace OBP\Transactions;

use OBP\Exception\OBPException;
use OBP\ObjectInterface;
use OBP\OBP;

/**
 * Class GetTransactions
 *
 * @package OBP\Transactions
 */
class GetTransactions extends OBP implements ObjectInterface
{
    /**
     * Object params
     */
    const OBJECT_TYPE  = 'transactions';
    const REQUEST_TYPE = 'GET';

    /**
     * GetTransactions constructor.
     *
     * @param   array $settings
     * @throws  OBPException
     */
    public function __construct(array $settings = [])
    {
        parent::__construct($settings, self::OBJECT_TYPE, self::REQUEST_TYPE);
    }

    /**
     * Do request
     *
     * @return  array
     * @throws  \GuzzleHttp\Exception\GuzzleException
     * @throws  \OBP\Exception\OBPException
     */
    public function doRequest(): array
    {
        return $this->_doRequest([]);
    }
}