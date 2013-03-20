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
class pi_ratepay_Configuration extends oxAdminView
{

    public function render()
    {
        parent::render();

        $ratepayRequest = oxNew('pi_ratepay_ratepayrequest', 'pi_ratepay_rate');
        $configRequestResult = $ratepayRequest->configRequest();

        $response = $configRequestResult['response'];

        pi_ratepay_LogsService::getInstance()->logRatepayTransaction('', '', 'INSTALLMENT', 'CONFIGURATION_REQUEST', '', $configRequestResult['request'], '', '', $response);

        if ($response && $response->head->processing->result->attributes()->code == '500') {
            $this->addTplParam('error', false);
            $this->_setTemplateVariables($response);
        } else {
            $this->addTplParam('error', true);
        }

        return "pi_ratepay_configuration.tpl";
    }

    /**
     * Adds template data from response.
     * @param SimpleXMLElement $response
     */
    private function _setTemplateVariables(SimpleXMLElement $response)
    {
        $this->addTplParam('interestrateMin', $response->content->{'installment-configuration-result'}->{'interestrate-min'});
        $this->addTplParam('interestrateDefault', $response->content->{'installment-configuration-result'}->{'interestrate-default'});
        $this->addTplParam('interestrateMax', $response->content->{'installment-configuration-result'}->{'interestrate-max'});
        $this->addTplParam('monthNumberMin', $response->content->{'installment-configuration-result'}->{'month-number-min'});
        $this->addTplParam('monthNumberMax', $response->content->{'installment-configuration-result'}->{'month-number-max'});
        $this->addTplParam('monthLongrun', $response->content->{'installment-configuration-result'}->{'month-longrun'});
        $this->addTplParam('monthAllowed', $response->content->{'installment-configuration-result'}->{'month-allowed'});
        $this->addTplParam('paymentFirstday', $response->content->{'installment-configuration-result'}->{'payment-firstday'});
        $this->addTplParam('paymentAmount', $response->content->{'installment-configuration-result'}->{'payment-amount'});
        $this->addTplParam('paymentLastrate', $response->content->{'installment-configuration-result'}->{'payment-lastrate'});
        $this->addTplParam('rateMinNormal', $response->content->{'installment-configuration-result'}->{'rate-min-normal'});
        $this->addTplParam('rateMinLongrun', $response->content->{'installment-configuration-result'}->{'rate-min-longrun'});
        $this->addTplParam('serviceCharge', $response->content->{'installment-configuration-result'}->{'service-charge'});
    }

}
