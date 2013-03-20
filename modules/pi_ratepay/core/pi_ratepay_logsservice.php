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
 * Logging service class
 * @extends oxSuperCfg
 */
class pi_ratepay_LogsService extends oxSuperCfg
{

    /**
     * pi_ratepay_LogsService class instance.
     *
     * @var pi_ratepay_LogsService instance
     */
    private static $_instance = null;

    /**
     * Returns object instance of pi_ratepay_LogsService
     *
     * @return pi_ratepay_LogsService
     */
    public static function getInstance()
    {
        // disable caching for test modules
        if (defined('OXID_PHP_UNIT')) {
            self::$_instance = modInstances::getMod(__CLASS__);
        }

        if (!self::$_instance instanceof pi_ratepay_LogsService) {
            self::$_instance = oxNew('pi_ratepay_LogsService');

            if (defined('OXID_PHP_UNIT')) {
                modInstances::addMod(__CLASS__, self::$_instance);
            }
        }
        return self::$_instance;
    }

    /**
     * Logs Ratepay requests and responses to database
     *
     * @param string $orderId
     * @param string $transactionId
     * @param string $paymentType
     * @param string $paymentSubtype
     * @param SimpleXMLExtended $request
     * @param mixed $response is optional; if there is a response than SimpleXMLExtended is expected, else it defaults to boolean false
     *
     * @return mixed pi_ratepay_Logs or null
     */
    public function logRatepayTransaction($orderId, $transactionId, $paymentMethod, $paymentType, $paymentSubtype, $request, $name, $surname, $response = false)
    {
        $logging = $this->_getLogSettings($paymentMethod);

        if ($logging == 1) {
            if (($paymentMethod === 'ELV' || $paymentMethod === 'INSTALLMENT') && isset($request->content->customer->{"bank-account"})) {
                $request->content->customer->{"bank-account"}->{"owner"} = "XXXXXX";
                $request->content->customer->{"bank-account"}->{"bank-account-number"} = "XXXXXX";
                $request->content->customer->{"bank-account"}->{"bank-code"} = "XXXXXX";
                $request->content->customer->{"bank-account"}->{"bank-name"} = "XXXXXX";
            }
            $requestXml = $request->asXML();
            $responseXml = '';
            $reason = '';

            if ($response) {
                $result = (string) $response->head->processing->result;
                $resultCode = (string) $response->head->processing->result->attributes()->code;
                $responseXml = $response->asXML();
                $reason = (string) $response->head->processing->reason;
            } else {
                $result = "service unavaible.";
                $resultCode = $result;
            }

            $logEntry = oxNew('pi_ratepay_Logs');

            $oUtilsDate = oxUtilsDate::getInstance();

            $logEntry->assign(array(
                'order_number'    => $orderId,
                'transaction_id'  => $transactionId,
                'payment_method'  => $paymentMethod,
                'payment_type'    => $paymentType,
                'payment_subtype' => $paymentSubtype,
                'result'          => $result,
                'request'         => $requestXml,
                'response'        => $responseXml,
                'result_code'     => $resultCode,
                'first_name'      => $name,
                'last_name'       => $surname,
                'reason'          => $reason,
                'date'            => date('Y-m-d H:i:s', $oUtilsDate->getTime())
            ));

            $logEntry->save();

            return $logEntry;
        }

        return null;
    }

    /**
     * Get either a complete List of Log entries or a List of Log entries filtered by a where clause.
     *
     * @param string $where optional, defaults to null
     * @return getLogList
     */
    public function getLogsList($where = null, $order = null)
    {
        $ratepayLogsList = oxNew('pi_ratepay_LogsList');

        if ($where === null && $order === null)
            return $ratepayLogsList->getList();

        return $ratepayLogsList->getFilteredList($where, $order);
    }

    /**
     * Get RatePAY Settings
     * @param string $paymentMethod
     * @return int
     */
    private function _getLogSettings($paymentMethod)
    {
        $settings = oxNew('pi_ratepay_settings');

        if ($paymentMethod == 'INVOICE' || $paymentMethod == 'INSTALLMENT' || $paymentMethod == 'ELV') {
            $settings->loadByType($paymentMethod);
            return $settings->pi_ratepay_settings__logging->rawValue;
        }

        return 0;
    }

}
