<?php

namespace OBP\Merchants;

use OBP\Exception\OBPException;
use OBP\ObjectInterface;
use OBP\OBP;

/**
 * Class Create bank account
 *
 * @package Onlinebetaalplatform\Merchants
 */
class CreateBankAccount extends OBP implements ObjectInterface
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
     * CreateMerchant constructor.
     *
     * @param   array $settings
     * @throws  OBPException
     */
    public function __construct(array $settings = [])
    {
        parent::__construct($settings, self::OBJECT_TYPE, self::REQUEST_TYPE);
    }

    /**
     * Check values and do rest api request
     *
     * @return  array
     * @throws  OBPException
     * @throws  \GuzzleHttp\Exception\GuzzleException
     */
    public function doRequest(): array
    {
        // Must have uid
        if (is_null($this->_uid)) {
            throw new OBPException('uid is required');
        }

        $params = [
            'notify_url'   => $this->_getBaseUrl() . 'obp/postback/create-merchant',
            'return_url'   => $this->_getBaseUrl() . 'obp/merchant/index'
        ];

        return $this->_doRequest($params, $this->_uid . '/bank_accounts');
    }

    /**
     * @param   string $uid
     * @return  CreateBankAccount
     */
    public function setUid(string $uid): CreateBankAccount
    {
        $this->_uid = $uid;

        return $this;
    }
}