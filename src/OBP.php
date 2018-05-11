<?php

namespace OBP;

use GuzzleHttp\Client;
use OBP\Exception\OBPException;

/**
 * Class Onlinebetaalplatform
 *
 * @package Onlinebetaalplatform
 */
abstract class OBP
{
    /**
     * Object will be placed after rest api url
     *
     * @var string
     */
    protected $_object;

    /**
     * @var Client
     */
    private $_HttpClient;

    /**
     * @var string
     */
    private $_requestType;

    /**
     * @var array
     */
    protected $_settings = [
        'apiKey'        => '',
        'sandbox'       => true,
        'url'           => 'https://api.onlinebetaalplatform.nl/v1/',
        'sandboxUrl'    => 'https://api-sandbox.onlinebetaalplatform.nl/v1/',
        'baseUrl'       => 'https://www.yourdomain.com/',
    ];

    /**
     * OBP constructor.
     *
     * @param   array  $settings
     * @param   string $objectType
     * @param   string $requestType
     * @throws  OBPException
     */
    public function __construct(array $settings = [], string $objectType, string $requestType = 'POST')
    {
        // Update settings
        foreach ($settings as $setting => $value) {
            $this->_updateSetting($setting, $value);
        }

        $this->_HttpClient  = new Client();
        $this->_object      = $objectType;
        $this->_requestType = $requestType;
    }

    /**
     * Update setting value
     *
     * @param   string $setting
     * @param   string $value
     * @throws  OBPException
     */
    private function _updateSetting(string $setting, string $value): void
    {
        // Check if setting exists in array
        if (array_key_exists($setting, $this->_settings) === false) {
            throw new OBPException('Setting key does not exists: ' . $setting);
        }

        $this->_settings[$setting] = $value;
    }

    /**
     * Use guzzle to create a authenticated curl request
     *
     * @param   array  $params       Post params
     * @param   string $urlExtension Extend url, f.e. with transaction id
     *
     * @throws  \GuzzleHttp\Exception\GuzzleException
     * @throws  OBPException
     * @return  array
     */
    protected function _doRequest(array $params = [], string $urlExtension = ''): array
    {
        // Use guzzle to create a curl http request
        $response = $this->_HttpClient->request(
            $this->_requestType,
            $this->_getUri($urlExtension),
            [
                'auth'        => [
                    $this->_settings['apiKey'],
                    null
                ],
                'form_params' => $params
            ]
        );

        // Check response
        if ($response->getStatusCode() !== 200) {
            throw new OBPException('Invalid response: ' . $response->getStatusCode());
        }

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get uri for curl request
     *
     * @param   string $urlExtension
     * @return  string
     */
    private function _getUri(string $urlExtension = ''): string
    {
        $baseUri = $this->_settings['sandbox'] ? $this->_settings['sandboxUrl'] : $this->_settings['url'];

        return $baseUri . $this->_object . ($urlExtension !== '' ? '/' . $urlExtension : '');
    }

    /**
     * Get notify base url
     *
     * @return string
     */
    protected function _getBaseUrl(): string
    {
        return rtrim($this->_settings['baseUrl'], '/') . '/';
    }

    /**
     * Mix base url with notify/return url
     *
     * @param   string $url
     * @return  string
     */
    protected function _createUrl(string $url): string
    {
        // Base url not in $url so add it to create a complete url
        if (strpos($this->_getBaseUrl(), $url) === false) {
            return $this->_getBaseUrl() . ltrim($url, '/');
        }

        return $url;
    }
}