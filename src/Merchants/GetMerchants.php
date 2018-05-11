<?php

namespace OBP\Merchants;

use OBP\Exception\OBPException;
use OBP\ObjectInterface;
use OBP\OBP;

class GetMerchants extends OBP implements ObjectInterface
{
    /**
     * Object params
     */
    const OBJECT_TYPE  = 'merchants';
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
     * @throws  \GuzzleHttp\Exception\GuzzleException
     * @throws  \OBP\Exception\OBPException
     */
    public function doRequest(): array
    {
        return $this->_doRequest([]);
    }
}