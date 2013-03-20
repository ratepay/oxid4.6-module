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
 * {@inheritdoc}
 *
 * Additonally sends PAYMENT_CONFIRM (final request) to RatePAY.
 *
 * @package   PayIntelligent_RatePAY
 * @extends Thankyou
 */
class pi_ratepay_thankyou extends pi_ratepay_thankyou_parent
{

    /**
     * Holds paymentid (basket payment)
     * @var string
     */
    private $_ratepayPaymentType = '';

    /**
     * {@inherhitdoc}
     *
     * Additonally executes ratepayRequest (PAYMENT_CONFIRM)
     *
     * @see Thankyou::render()
     * @return string
     */
    public function render()
    {
        if (in_array($this->getBasket()->getPaymentId(), pi_ratepay_util_utilities::$_RATEPAY_PAYMENT_METHOD)) {
            $this->_ratepayPaymentType = $this->getBasket()->getPaymentId();

            $thankyouTpl = parent::render();

            $this->_ratepayRequest();

            return $thankyouTpl;
        } else {
            return parent::render();
        }
    }

    /**
     * Do RatePAY PAYMENT_CONFIRM
     *
     * Checks if RatePAY Modul is set to sandbox if true sets the pi_ratepay_xml_service->live to false.
     * Creates request object (type: SimpleXMLExtended) for payment request. Sends the request with
     * pi_ratepay_xml_service::paymentOperation and logs transaction.
     *
     * @uses  function _setRatepayHead
     */
    private function _ratepayRequest()
    {
        $ratepayRequest = $this->_getRatepayRequest();

        $name = $this->getUser()->oxuser__oxfname->value;
        $surname = $this->getUser()->oxuser__oxlname->value;

        $confirmPayment = $ratepayRequest->confirmPayment();

        pi_ratepay_LogsService::getInstance()->logRatepayTransaction($this->_oBasket->getOrderId(), $this->getSession()->getVar($this->_ratepayPaymentType . '_trans_id'), pi_ratepay_util_utilities::getPaymentMethod($this->_ratepayPaymentType), 'PAYMENT_CONFIRM', '', $confirmPayment['request'], $name, $surname, $confirmPayment['response']);

        if ($confirmPayment['response'] && ((string) $confirmPayment['response']->head->processing->status->attributes()->code) == "OK" && ((string) $confirmPayment['response']->head->processing->result->attributes()->code) == "400") {
            return true;
        }

        return false;
    }

    /**
     * Get RatePAY Request object.
     * @return  pi_ratepay_ratepayrequest
     */
    protected function _getRatepayRequest()
    {
        $requestDataProvider = oxNew('pi_ratepay_requestdatafrontend', $this->_ratepayPaymentType, $this->getBasket());
        $ratepayRequest = oxNew('pi_ratepay_ratepayrequest', $this->_ratepayPaymentType, $requestDataProvider);

        return $ratepayRequest;
    }

}
