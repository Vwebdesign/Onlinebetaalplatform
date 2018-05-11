<?php

namespace OBP\Transactions;

use OBP\Exception\OBPException;
use OBP\ObjectInterface;
use OBP\OBP;

/**
 * Class GetTransaction
 *
 * @package OBP\Transactions
 */
class GetTransaction extends OBP implements ObjectInterface
{
    /**
     * Object params
     */
    const OBJECT_TYPE  = 'transactions';
    const REQUEST_TYPE = 'POST';

    /**
     * @var string
     */
    private $_uid;

    /**
     * GetTransaction constructor.
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
            throw new OBPException('Set uid to get transaction');
        }

        return $this->_doRequest([], $this->_uid);
    }

    /**
     * @param   string $uid
     * @return  GetTransaction
     */
    public function setUid(string $uid): GetTransaction
    {
        $this->_uid = $uid;

        return $this;
    }
}