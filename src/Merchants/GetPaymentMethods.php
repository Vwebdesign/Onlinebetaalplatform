<?php

namespace OBP\Merchants;

use OBP\Exception\OBPException;
use OBP\ObjectInterface;
use OBP\OBP;

class GetPaymentMethods extends OBP implements ObjectInterface
{
    /**
     * Object params
     */
    const OBJECT_TYPE  = 'merchants';
    const REQUEST_TYPE = 'GET';

    /**
     * @var string
     */
    private $_uid;

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
        if (is_null($this->_uid)) {
            throw new OBPException('Set uid to get merchant');
        }

        return $this->_doRequest([], $this->_uid . '/payment_methods');
    }

    /**
     * @param   string $uid
     * @return  GetPaymentMethods
     */
    public function setUid(string $uid): GetPaymentMethods
    {
        $this->_uid = $uid;

        return $this;
    }
}