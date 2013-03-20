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
 * RatePAY Logging View
 *
 * Shows RatePAY Transaction Logs
 *
 * Also:
 * {@inheritdoc}
 *
 * @package PayIntelligent_RatePAY
 * @extends oxAdminView
 */
class pi_ratepay_Log extends oxAdminView
{
    /**
     * Renders transaction log table, calls method to sort entries.
     *
     * Also:
     * {@inheritdoc}
     *
     * @see oxAdminView::render()
     * @uses function piRatepayGetSortedArray
     * @return string
     */
    function render()
    {
        parent::render();

        $this->_setTemplateData();

        return "pi_ratepay_log.tpl";
    }

    /**
     * Generate log data for consumption in template.
     */
    private function _setTemplateData()
    {
        $logList = $this->_getSortedArray();
        $tplData = array();
        $resultSuccesArray = array('350', '402', '400', '404', '403', '500');

        foreach ($logList as $logEntry) {
            $operationSubtype = $logEntry->pi_ratepay_logs__payment_subtype->rawValue;
            $orderNr = oxDb::getDb()->getOne('SELECT OXORDERNR FROM oxorder where oxid = ?', array($logEntry->pi_ratepay_logs__order_number->rawValue));

            $tplDataEntry = array(
                'oxid' => $logEntry->pi_ratepay_logs__oxid->value,
                'orderid' => empty($orderNr) ? 'Not created' : $orderNr,
                'transactionid' => $logEntry->pi_ratepay_logs__transaction_id->rawValue,
                'paymentmethod' => $logEntry->pi_ratepay_logs__payment_method->rawValue,
                'operationtype' => $logEntry->pi_ratepay_logs__payment_type->rawValue,
                'ratepayresult' => $logEntry->pi_ratepay_logs__result->rawValue,
                'request' => str_replace("&gt;&lt;", "&gt;\n&lt;", htmlentities(utf8_decode($logEntry->pi_ratepay_logs__request->rawValue))),
                'response' => str_replace("&gt;&lt;", "&gt;\n&lt;", htmlentities(utf8_decode($logEntry->pi_ratepay_logs__response->rawValue))),
                'result' => in_array($logEntry->pi_ratepay_logs__result_code->rawValue, $resultSuccesArray) ? 'SUCCESS' : 'ERROR',
                'operationsubtype' => empty($operationSubtype) ? 'n/a' : $operationSubtype,
                'reason' => $logEntry->pi_ratepay_logs__reason->rawValue,
                'firstname' => $logEntry->pi_ratepay_logs__first_name->rawValue,
                'lastname' => $logEntry->pi_ratepay_logs__last_name->rawValue,
                'ratepaycode' => $logEntry->pi_ratepay_logs__result_code->rawValue,
                'date' => $logEntry->pi_ratepay_logs__date->rawValue
            );

            array_push($tplData, $tplDataEntry);
        }

        $this->addTplParam('logs', $tplData);
    }

    /**
     * Checks parameter for sortmethod and sortType, sorts data according to values of sortmethod and sorttype.
     *
     * @return pi_ratepay_LogList
     */
    private function _getSortedArray()
    {
        $sortType = oxConfig::getParameter('sortType');
        $sortMethod = oxConfig::getParameter('sortmethod');

        if (oxConfig::getParameter('sortmethod') === null) {
            $sortMethod = 'sortDate';
        }
        if (oxConfig::getParameter('sortType') === null || oxConfig::getParameter('sortType') == "asc") {
            $sortType = "desc";
        }
        if (oxConfig::getParameter('sortType') !== null && oxConfig::getParameter('sortType') == "desc") {
            $sortType = 'asc';
        }

        $sortMethodList = array(
            'sortOrderId' => 'order_number',
            'sortTransactionId' => 'transaction_id',
            'sortFirstName' => 'first_name',
            'sortLastName' => 'last_name',
            'sortPaymentMethod' => 'payment_method',
            'sortPaymentType' => 'payment_type',
            'sortPaymentSubType' => 'payment_subtype',
            'sortResult' => 'result',
            'sortReason' => 'reason',
            'sortDate' => 'date'
        );

        $orderBy = array(
            array(
                'column' => $sortMethodList[$sortMethod],
                'direction' => $sortType
            )
        );

        $this->addTplParam('sortmethod', $sortMethod);
        $this->addTplParam('sortType', $sortType);

        $result = pi_ratepay_LogsService::getInstance()->getLogsList(null, $orderBy);

        return $result;
    }

    /**
     * Removes all log entries from db which are older than x days.
     */
    public function deleteLogs()
    {
        if (preg_match("/^[0-9]{1,2}$/", oxConfig::getParameter('logdays'))) {
            $days = oxConfig::getParameter('logdays');
            if ($days == 0) {
                oxDb::getDb()->execute("delete from pi_ratepay_logs");
            } else {
                $days = oxConfig::getParameter('logdays');
                $sql = "DELETE FROM pi_ratepay_logs WHERE TO_DAYS(now()) - TO_DAYS(date) > " . $days;
                oxDb::getDb()->execute($sql);
            }
            $this->addTplParam('deleteSuccess', 'Success');
        }
    }

}
