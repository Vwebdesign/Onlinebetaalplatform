<?php

namespace OBP\Transactions;

use OBP\ObjectInterface;
use OBP\OBP;
use OBP\Exception\OBPException;

/**
 * Class CreateTransaction
 *
 * @package OBP\Transactions
 */
class CreateTransaction extends OBP implements ObjectInterface
{
    /**
     * Object params
     */
    const OBJECT_TYPE  = 'transactions';
    const REQUEST_TYPE = 'POST';

    /**
     * @var string
     */
    private $_merchant_uid;

    /**
     * @var int
     */
    private $_partner_fee;

    /**
     * @var bool
     */
    private $_checkout = 'false';

    /**
     * @var string
     */
    private $_payment_method;

    /**
     * @var string direct|email
     */
    private $_payment_flow = 'direct';

    /**
     * @var bool
     */
    private $_escrow;

    /**
     * @var string number of days
     */
    private $_escrow_period;

    /**
     * @var string YYYY-MM-DD HH:MM:SS
     */
    private $_escrow_date;

    /**
     * @var string nl|en|fr
     */
    private $_locale;

    /**
     * @var string
     */
    private $_buyer_name_first;

    /**
     * @var string
     */
    private $_buyer_name_last;

    /**
     * @var string
     */
    private $_buyer_emailaddress;

    /**
     * @var array
     */
    private $_products = [];

    /**
     * @var int
     */
    private $_shipping_costs;

    /**
     * @var int
     */
    private $_discount;

    /**
     * @var int
     */
    private $_total_price;

    /**
     * @var string
     */
    private $_return_url;

    /**
     * @var string
     */
    private $_notify_url;

    /**
     * @var string
     */
    private $_issuer;

    /**
     * @var array
     */
    private $_metadata;

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
        $this->_validate();

        $params = [
            'merchant_uid' => $this->_merchant_uid,
            'products'     => $this->_products,
            'return_url'   => $this->_return_url,
            'total_price'  => $this->_total_price,
        ];

        $nonRequiredFields = [
            '_buyer_emailaddress',
            '_partner_fee',
            '_payment_method',
            '_escrow',
            '_escrow_period',
            '_escrow_date',
            '_locale',
            '_buyer_name_first',
            '_buyer_name_last',
            '_buyer_emailaddress',
            '_shipping_costs',
            '_discount',
            '_payment_method',
            '_notify_url',
            '_metadata',
            '_checkout',
            '_issuer',
        ];

        foreach ($nonRequiredFields as $nonRequiredField) {
            if (!is_null($this->{$nonRequiredField})) {
                $params[ltrim($nonRequiredField, '_')] = $this->{$nonRequiredField};
            }
        }

        return $this->_doRequest($params);
    }

    /**
     * Validate params
     *
     * @throws  OBPException
     */
    private function _validate(): void
    {
        // Merchant uid
        if (is_null($this->_merchant_uid)) {
            throw new OBPException('Merchant uid is required');
        }

        // Payment flow email requires a emailaddress
        if ($this->_payment_flow === 'email' && is_null($this->_buyer_emailaddress)) {
            throw new OBPException('Email is required for payment flow `email`');
        }

        // Validate e-mail address format
        if (!is_null($this->_buyer_emailaddress) && !filter_var($this->_buyer_emailaddress, FILTER_VALIDATE_EMAIL)) {
            throw new OBPException('Incorrect e-mail address, check e-mail address format');
        }

        // Must have a product
        if (empty($this->_products)) {
            throw new OBPException('Add a product');
        }

        // Must have a return url
        if (is_null($this->_return_url)) {
            throw new OBPException('Return url is required');
        }

        // Must have a total price
        if (empty($this->_total_price)) {
            throw new OBPException('Total price is required');
        }
    }

    /**
     * @param   array $product [
     *                         'name',      // (required) product name
     *                         'price',     // (required)product EAN (European Article Numbering) code
     *                         'quantity',  // number, number of products
     *                         'ean',       // product EAN (European Article Numbering) code
     *                         'code'       // product code
     *                         ]
     * @return  CreateTransaction
     * @throws  OBPException
     */
    public function addProduct(array $product): CreateTransaction
    {
        // Name
        if (!array_key_exists('name', $product)) {
            throw new OBPException('Product name is required');
        } else {
            $newProductArray['name'] = (string)$product['name'];
        }

        // Price
        if (!array_key_exists('price', $product)) {
            throw new OBPException('Price is required');
        } else {
            $newProductArray['price'] = (int)$product['price'];
        }

        // Quantity
        if (!array_key_exists('quantity', $product) || !is_int($product['quantity'])) {
            $newProductArray['quantity'] = 1;
        } else {
            $newProductArray = (int)$product['quantity'];
        }

        // Ean
        if (array_key_exists('ean', $product)) {
            $newProductArray['ean'] = (string)$product['ean'];
        }

        // Code
        if (array_key_exists('code', $product)) {
            $newProductArray['code'] = (string)$product['code'];
        }

        $this->_products[] = $newProductArray;

        return $this;
    }

    /**
     * @param   string $merchant_uid
     * @return  CreateTransaction
     */
    public function setMerchantUid(string $merchant_uid): CreateTransaction
    {
        $this->_merchant_uid = $merchant_uid;

        return $this;
    }

    /**
     * @param   int $partner_fee
     * @return  CreateTransaction
     */
    public function setPartnerFee(int $partner_fee): CreateTransaction
    {
        $this->_partner_fee = $partner_fee;

        return $this;
    }

    /**
     * @param   bool $checkout
     * @return  CreateTransaction
     */
    public function setCheckout(bool $checkout): CreateTransaction
    {
        $this->_checkout = $checkout ? 'true' : 'false';

        return $this;
    }

    /**
     * @param   string $payment_method
     * @return  CreateTransaction
     */
    public function setPaymentMethod(string $payment_method): CreateTransaction
    {
        $this->_payment_method = $payment_method;

        return $this;
    }

    /**
     * @param   string $payment_flow
     * @return  CreateTransaction
     */
    public function setPaymentFlow(string $payment_flow): CreateTransaction
    {
        $this->_payment_flow = $payment_flow;

        return $this;
    }

    /**
     * @param   bool $escrow
     * @return  CreateTransaction
     */
    public function setEscrow(bool $escrow): CreateTransaction
    {
        $this->_escrow = $escrow ? 'true' : 'false';

        return $this;
    }

    /**
     * @param   string $escrow_period
     * @return  CreateTransaction
     */
    public function setEscrowPeriod(string $escrow_period): CreateTransaction
    {
        $this->_escrow_period = $escrow_period;

        return $this;
    }

    /**
     * @param   string $escrow_date
     * @return  CreateTransaction
     */
    public function setEscrowDate(string $escrow_date): CreateTransaction
    {
        $this->_escrow_date = $escrow_date;

        return $this;
    }

    /**
     * @param   string $locale
     * @return  CreateTransaction
     */
    public function setLocale(string $locale): CreateTransaction
    {
        $this->_locale = $locale;

        return $this;
    }

    /**
     * @param   string $buyer_name_first
     * @return  CreateTransaction
     */
    public function setBuyerNameFirst(string $buyer_name_first): CreateTransaction
    {
        $this->_buyer_name_first = $buyer_name_first;

        return $this;
    }

    /**
     * @param   string $buyer_name_last
     * @return  CreateTransaction
     */
    public function setBuyerNameLast(string $buyer_name_last): CreateTransaction
    {
        $this->_buyer_name_last = $buyer_name_last;

        return $this;
    }

    /**
     * @param   string $buyer_emailaddress
     * @return  CreateTransaction
     */
    public function setBuyerEmailaddress(string $buyer_emailaddress): CreateTransaction
    {
        $this->_buyer_emailaddress = $buyer_emailaddress;

        return $this;
    }

    /**
     * @param   int $shipping_costs
     * @return  CreateTransaction
     */
    public function setShippingCosts(int $shipping_costs): CreateTransaction
    {
        $this->_shipping_costs = $shipping_costs;

        return $this;
    }

    /**
     * @param   int $discount
     * @return  CreateTransaction
     */
    public function setDiscount(int $discount): CreateTransaction
    {
        $this->_discount = $discount;

        return $this;
    }

    /**
     * @param   int $total_price
     * @return  CreateTransaction
     */
    public function setTotalPrice(int $total_price): CreateTransaction
    {
        $this->_total_price = $total_price;

        return $this;
    }

    /**
     * @param   string $return_url
     * @return  CreateTransaction
     */
    public function setReturnUrl(string $return_url): CreateTransaction
    {
        $this->_return_url = $this->_createUrl($return_url);

        return $this;
    }

    /**
     * @param   string $notify_url
     * @return  CreateTransaction
     */
    public function setNotifyUrl(string $notify_url): CreateTransaction
    {
        $this->_notify_url = $this->_createUrl($notify_url);

        return $this;
    }

    /**
     * @param   string $issuer
     * @return  CreateTransaction
     */
    public function setIssuer(string $issuer): CreateTransaction
    {
        $this->_issuer = $issuer;

        return $this;
    }

    /**
     * @param   array $metadata
     * @return  CreateTransaction
     */
    public function setMetadata(array $metadata): CreateTransaction
    {
        $this->_metadata = $metadata;

        return $this;
    }
}