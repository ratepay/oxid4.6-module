<?php

/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * @category  PayIntelligent
 * @package   PayIntelligent_RatePAY
 * @copyright (C) 2011 PayIntelligent GmbH  <http://www.payintelligent.de/>
 * @license	http://www.gnu.org/licenses/  GNU General Public License 3
 */

/**
 * Create a Ratepay_XML Object
 *
 * Set the url to the server with the method "setRatepayserver($ratepayserver)"
 * Set the parameter list with a nested array to create the request XML
 *
 * @package PayIntelligent_RatePAY
 * @extends oxSuperCfg
 */
class pi_ratepay_XmlService extends oxSuperCfg
{
    private static $_server = array(
        'live' => 'https://webservices.eos-payment.com/custom/ratepay/xml/1_0',
        'sandbox' => 'https://webservices-int.eos-payment.com/custom/ratepay/xml/1_0'
    );

    private static $_instance = null;

    /**
     * Get instance of pi_ratepay_xmlService
     *
     * @return pi_ratepay_xmlService
     */
    public static function getInstance()
    {
        // disable caching for test modules
        if (defined('OXID_PHP_UNIT')) {
            self::$_instance = modInstances::getMod(__CLASS__);
        }

        if (!self::$_instance instanceof pi_ratepay_xmlService) {
            self::$_instance = oxNew('pi_ratepay_xmlService');

            if (defined('OXID_PHP_UNIT')) {
                modInstances::addMod(__CLASS__, self::$_instance);
            }
        }

        return self::$_instance;
    }

    /**
     * Get RatePAY server url for either live system or development system.
     *
     * @param string $paymentMethod 'INVOICE' or 'INSTALLMENT'
     * @return string
     */
    public function getRatepayServer($paymentMethod)
    {
        $paymentMethod = strtoupper($paymentMethod);

        if ($paymentMethod == 'INVOICE' || $paymentMethod == 'INSTALLMENT' || $paymentMethod == 'ELV') {
            $settings = oxNew('pi_ratepay_settings');
            $settings->loadByType($paymentMethod);

            if ($settings->pi_ratepay_settings__sandbox->rawValue != '1') {
                return self::$_server['live'];
            }
        }
        return self::$_server['sandbox'];
    }

    /**
     * Do RatePAY request, return response as SimpleXMLElement on success
     * otherwise return false.
     *
     * @param SimpleXMLExtended $xmlRequest
     * @param string $paymentMethod
     * @return boolean|SimpleXMLElement
     */
    public function paymentOperation($xmlRequest, $paymentMethod)
    {
        $response = $this->_httpsPost($xmlRequest->asXML(), $this->getRatepayServer($paymentMethod));

        return $response? new SimpleXMLElement($response) : false;
    }

    /**
     * This method sends a request to the RatePAY server and returns the response or false if request fails.
     *
     * @param string $xmlRequest
     * @return boolean|string
     */
    protected function _httpsPost($xmlRequest, $ratepayServer)
    {
        // Initialisation
        $curl = curl_init();
        // Set parameters
        curl_setopt($curl, CURLOPT_URL, $ratepayServer);
        // Return a variable instead of posting it directly
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // Active the POST method
        curl_setopt($curl, CURLOPT_POST, 1);
        //Set HTTP Version
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        //Set HTTP Header
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Content-Type: text/xml; charset=UTF-8",
            "Accept: */*",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Connection: keep-alive"
        ));
        // Request
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xmlRequest);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        // Execute the connection
        $result = curl_exec($curl);
        // Close it
        curl_close($curl);
        // Uncomment for xml debug
        //return $this->createXML();
        return $result;
    }

    /**
     * Wrapper method to create an SimpleXMLExtended Object
     * @return SimpleXMLExtended
     */
    public function getXMLObject()
    {
        $xmlString = '<?xml version="1.0" encoding="UTF-8"?>' . '<request version="1.0" xmlns="urn://www.ratepay.com/payment/1_0"></request>';
        require_once('SimpleXMLExtended.php');
        $xml = new SimpleXMLExtended($xmlString);

        return $xml;
    }

}
