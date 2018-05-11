<?php

namespace OBP\Merchants;

use OBP\Exception\OBPException;
use OBP\ObjectInterface;
use OBP\OBP;

/**
 * Class Create
 *
 * @package Onlinebetaalplatform\Merchants
 */
class CreateMerchant extends OBP implements ObjectInterface
{
    /**
     * Object params
     */
    const OBJECT_TYPE  = 'merchants';
    const REQUEST_TYPE = 'POST';

    /**
     * required
     *
     * @var string
     */
    private $_country = 'nld';

    /**
     * required
     *
     * @var string
     */
    private $_type = 'business';

    /**
     * required
     *
     * @var string
     */
    private $_emailaddress;

    /**
     * required
     *
     * @var string
     */
    private $_phone;

    /**
     * required
     *
     * @var string
     */
    private $_coc_nr;

    /**
     * @var string
     */
    private $_vat_nr;

    /**
     * @var string
     */
    private $_legal_entity;

    /**
     * @var string
     */
    private $_legal_name;

    /**
     * @var array
     */
    private $_addresses = [];

    /**
     * @var array
     */
    private $_trading_names = [];

    /**
     * @var string
     */
    private $_notify_url;

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
        $this->_validate();

        $params = [
            'notify_url'   => $this->_notify_url,
            'country'      => $this->_country,
            'type'         => $this->_type,
            'emailaddress' => $this->_emailaddress,
            'phone'        => $this->_phone,
            'coc_nr'       => $this->_coc_nr,
            'legal_name'   => $this->_legal_name,
        ];

        if (is_null($this->_vat_nr)) {
            $params['vat_nr'] = $this->_vat_nr;
        }

        if (is_null($this->_legal_entity)) {
            $params['legal_entity'] = $this->_legal_entity;
        }

        if (!empty($this->_addresses)) {
            $params['addresses'] = $this->_addresses;
        }

        if (!empty($this->_trading_names)) {
            $params['trading_names'] = $this->_trading_names;
        }

        return $this->_doRequest($params);
    }

    /**
     * Validate fields before submitting
     *
     * @throws  OBPException
     */
    private function _validate(): void
    {
        // Required fields
        foreach (['_country', '_type', '_emailaddress', '_phone', '_coc_nr', '_legal_name', '_notify_url'] as $requiredField) {
            if (is_null($this->{$requiredField})) {
                throw new OBPException("Required field `$requiredField` not set");
            }
        }

        // Country must be iso 3 letters
        if (strlen($this->_country) !== 3) {
            throw new OBPException('Country must be iso 3 letters');
        }

        // Validate e-mail address format
        if (!filter_var($this->_emailaddress, FILTER_VALIDATE_EMAIL)) {
            throw new OBPException('Incorrect e-mail address, check e-mail address format');
        }
    }

    /**
     * @param   string $country
     * @return  CreateMerchant
     */
    public function setCountry(string $country): CreateMerchant
    {
        $this->_country = $country;

        return $this;
    }

    /**
     * @param   string $type
     * @return  CreateMerchant
     */
    public function setType(string $type): CreateMerchant
    {
        $this->_type = $type;

        return $this;
    }

    /**
     * @param   string $emailaddress
     * @return  CreateMerchant
     */
    public function setEmailaddress(string $emailaddress): CreateMerchant
    {
        $this->_emailaddress = $emailaddress;

        return $this;
    }

    /**
     * @param   string $phone
     * @return  CreateMerchant
     */
    public function setPhone(string $phone): CreateMerchant
    {
        $this->_phone = $phone;

        return $this;
    }

    /**
     * @param   string $coc_nr
     * @return  CreateMerchant
     */
    public function setCocNr(string $coc_nr): CreateMerchant
    {
        $this->_coc_nr = $coc_nr;

        return $this;
    }

    /**
     * @param   string $vat_nr
     * @return  CreateMerchant
     */
    public function setVatNr(string $vat_nr): CreateMerchant
    {
        $this->_vat_nr = $vat_nr;

        return $this;
    }

    /**
     * @param   string $legal_entity
     * @return  CreateMerchant
     */
    public function setLegalEntity(string $legal_entity): CreateMerchant
    {
        $this->_legal_entity = $legal_entity;

        return $this;
    }

    /**
     * @param   string $legal_name
     * @return  CreateMerchant
     */
    public function setLegalName(string $legal_name): CreateMerchant
    {
        $this->_legal_name = $legal_name;

        return $this;
    }

    /**
     * @param   array $addresses
     * @return  CreateMerchant
     */
    public function setAddresses(array $addresses): CreateMerchant
    {
        $this->_addresses = json_encode($addresses);

        return $this;
    }

    /**
     * @param   array $trading_names
     * @return  CreateMerchant
     */
    public function setTradingNames(array $trading_names): CreateMerchant
    {
        $this->_trading_names = json_encode($trading_names);

        return $this;
    }

    /**
     * @param   string $notify_url
     * @return  CreateMerchant
     */
    public function setNotifyUrl(string $notify_url): CreateMerchant
    {
        $this->_notify_url = $this->_createUrl($notify_url);

        return $this;
    }
}