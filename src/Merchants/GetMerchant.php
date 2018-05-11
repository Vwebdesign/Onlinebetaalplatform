<?php

namespace OBP\Merchants;

use OBP\Exception\OBPException;
use OBP\ObjectInterface;
use OBP\OBP;

class GetMerchant extends OBP implements ObjectInterface
{
    /**
     * Object params
     */
    const OBJECT_TYPE  = 'merchants';
    const REQUEST_TYPE = 'POST';

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

        return $this->_doRequest([], $this->_uid);
    }

    /**
     * @param   string $uid
     * @return  GetMerchant
     */
    public function setUid(string $uid): GetMerchant
    {
        $this->_uid = $uid;

        return $this;
    }
}