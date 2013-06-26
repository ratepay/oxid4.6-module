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
class pi_ratepay_Profile extends pi_ratepay_admin_SettingsAbstract
{

    public function render()
    {
        parent::render();

        $ratepayRequest = oxNew('pi_ratepay_ratepayrequest', 'pi_ratepay_rate');
        $profileRequestResult = $ratepayRequest->profileRequest();

        $response = $profileRequestResult['response'];

        if ($response && $response->head->processing->status!="Error") { 
            $this->addTplParam('error', false);
            $this->_setTemplateVariables($response);
        } else {
            $this->addTplParam('error', true);
        }

        return "pi_ratepay_profile.tpl";
    }

    /**
     * Adds template data from response.
     * @param SimpleXMLElement $response
     */
    private function _setTemplateVariables(SimpleXMLElement $response)
    {
        $this->addTplParam('merchantname', $response->content->{'master-data'}->{'merchant-name'});
        $this->addTplParam('merchantstatus', $response->content->{'master-data'}->{'merchant-status'});
        $this->addTplParam('shopname', $response->content->{'master-data'}->{'shop-name'});
        $this->addTplParam('activation_invoice', $response->content->{'master-data'}->{'activation-status-invoice'});
        $this->addTplParam('activation_installment', $response->content->{'master-data'}->{'activation-status-installment'});
        $this->addTplParam('activation_elv', $response->content->{'master-data'}->{'activation-status-elv'});
        $this->addTplParam('activation_prepayment', $response->content->{'master-data'}->{'activation-status-prepayment'});
        $this->addTplParam('eligibility_invoice', $response->content->{'master-data'}->{'eligibility-ratepay-invoice'});
        $this->addTplParam('eligibility_installment', $response->content->{'master-data'}->{'eligibility-ratepay-installment'});
        $this->addTplParam('eligibility_elv', $response->content->{'master-data'}->{'eligibility-ratepay-elv'});
        $this->addTplParam('eligibility_prepayment', $response->content->{'master-data'}->{'eligibility-ratepay-prepayment'});
        $this->addTplParam('limit_invoice_min', $response->content->{'master-data'}->{'tx-limit-invoice-min'});
        $this->addTplParam('limit_invoice_max', $response->content->{'master-data'}->{'tx-limit-invoice-max'});
        $this->addTplParam('limit_installment_min', $response->content->{'master-data'}->{'tx-limit-installment-min'});
        $this->addTplParam('limit_installment_max', $response->content->{'master-data'}->{'tx-limit-installment-max'});
        $this->addTplParam('limit_elv_min', $response->content->{'master-data'}->{'tx-limit-elv-min'});
        $this->addTplParam('limit_elv_max', $response->content->{'master-data'}->{'tx-limit-elv-max'});
        $this->addTplParam('limit_prepayment_min', $response->content->{'master-data'}->{'tx-limit-prepayment-min'});
        $this->addTplParam('limit_prepayment_max', $response->content->{'master-data'}->{'tx-limit-prepayment-max'});
        $this->addTplParam('deliveryaddress_invoice', $response->content->{'master-data'}->{'delivery-address-invoice'});
        $this->addTplParam('b2b_invoice', $response->content->{'master-data'}->{'b2b-invoice'});
        $this->addTplParam('deliveryaddress_installment', $response->content->{'master-data'}->{'delivery-address-installment'});
        $this->addTplParam('b2b_installment', $response->content->{'master-data'}->{'b2b-installment'});
        $this->addTplParam('deliveryaddress_elv', $response->content->{'master-data'}->{'delivery-address-elv'});
        $this->addTplParam('b2b_elv', $response->content->{'master-data'}->{'b2b-elv'});
        $this->addTplParam('deliveryaddress_prepayment', $response->content->{'master-data'}->{'delivery-address-prepayment'});
        $this->addTplParam('b2b_prepayment', $response->content->{'master-data'}->{'b2b-prepayment'});        
    }

    public function reloadRatepayProfile()
    {
        $ratepayRequest = oxNew('pi_ratepay_ratepayrequest', 'pi_ratepay_rate');
        $profileRequestResult = $ratepayRequest->profileRequest();

        $response = $profileRequestResult['response']->content->{'master-data'};

        $listOfPaymentMethods = array('invoice' => "rechnung",
                                      'installment' => "rate",
                                      'elv' => "elv",
                                      'prepayment' => "vorkasse");

        foreach($listOfPaymentMethods AS $paymentMethod => $paymentMethodDE) {
            $tbl = new oxBase();
            $tbl->init('oxpayments');
            $tbl->load('pi_ratepay_' . $paymentMethodDE);

            if($tbl->{'_sOXID'}) {
                $oxpayments['OXACTIVE'] = ( $response->{'eligibility-ratepay-' . $paymentMethod} == 'yes' && $response->{'activation-status-' . $paymentMethod} == '2' ) ? '1' : '0';
                $oxpayments['OXFROMAMOUNT'] = $response->{'tx-limit-' . $paymentMethod . '-min'};
                $oxpayments['OXTOAMOUNT'] = $response->{'tx-limit-' . $paymentMethod . '-max'};

                $tbl->assign($oxpayments);

                $tbl->save();
            }

            $tbl = new oxBase();
            $tbl->init('pi_ratepay_settings');
            
            $selectQuery = $tbl->buildSelectString(array($tbl->getViewName() . ".type" => strtolower($paymentMethod)));

            $tbl->_isLoaded = $tbl->assignRecord($selectQuery);

            if($tbl->{'_sOXID'}) {
                $rpaysettings['B2B'] = ($response->{'b2b-' . $paymentMethod} == "yes") ? "1" : "0";
                $rpaysettings['DELIVERY_ADDRESS'] = ($response->{'delivery-address-' . $paymentMethod} == "yes") ? "1" : "0";

                $tbl->assign($rpaysettings);

                $tbl->save();
            }
        }
    }
}
