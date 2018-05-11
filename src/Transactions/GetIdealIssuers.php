<?php

namespace OBP\Transactions;

use OBP\ObjectInterface;
use OBP\OBP;
use OBP\Exception\OBPException;

class GetIdealIssuers extends OBP implements ObjectInterface
{
    /**
     * Object params
     */
    const OBJECT_TYPE  = 'ideal_issuers';
    const REQUEST_TYPE = 'GET';

    /**
     * GetMerchants constructor.
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
     * @throws  OBPException
     * @throws  \GuzzleHttp\Exception\GuzzleException
     */
    public function doRequest(): array
    {
        return $this->_doRequest([]);
    }
}