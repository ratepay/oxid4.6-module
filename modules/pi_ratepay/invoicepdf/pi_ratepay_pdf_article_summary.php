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
 * @license http://www.gnu.org/licenses/  GNU General Public License 3
 */

/**
 * {@inheritdoc}
 *
 * Additionally adds RatePAY specific informations.
 *
 * @todo  refactor
 * @package   PayIntelligent_RatePAY
 * @extends PdfArticleSummary
 */
class pi_ratepay_pdf_article_summary
extends pi_ratepay_pdf_article_summary_parent
{

    /**
     * {@inheritdoc}
     *
     * Adds additional RatePAY informations.
     *
     * @param int &$iStartPos text start position
     */
    protected function _setPaymentMethodInfo(&$iStartPos)
    {
        $paymentMethod = $this->_getPaymentMethod();

        switch ($paymentMethod) {
            case 'pi_ratepay_rechnung':
                $this->_setRechnungMethodInfo($iStartPos);
                break;
            case 'pi_ratepay_rate':
                $this->_setRateMethodInfo($iStartPos);
                break;
            case 'pi_ratepay_elv':
                $this->_setElvMethodInfo($iStartPos);
                break;
            default:
                parent::_setPaymentMethodInfo($iStartPos);
                break;
        }
    }

    /**
     * {@inheritdoc}
     *
     * Adds additional RatePAY informations.
     *
     * @param int &$iStartPos text start position
     */
    protected function _setPayUntilInfo(&$iStartPos)
    {
        $paymentMethod = $this->_getPaymentMethod();

        switch ($paymentMethod) {
            case 'pi_ratepay_rechnung':
                $this->_setRechnungUntilInfo($iStartPos);
                break;
            case 'pi_ratepay_rate':
                $this->_setRateUntilInfo($iStartPos);
                break;
            case 'pi_ratepay_elv':
                $this->_setElvUntilInfo($iStartPos);
                break;
            default:
                parent::_setPayUntilInfo($iStartPos);
                break;
        }
    }

   /**
    * Adds additional RatePAY Invoice informations.
    *
    * @param int &$iStartPos text start position
    */
    private function _setRechnungMethodInfo(&$iStartPos)
    {
        $oPayment = oxNew('oxpayment');
        $oPayment->loadInLang(
            $this->_oData->getSelectedLang(),
            $this->_oData->oxorder__oxpaymenttype->value
        );

        $text = $this->_oData->translate('PI_RATEPAY_RECHNUNG_PDF_PAYMETHOD')
            . " " . $oPayment->oxpayments__oxdesc->value;
        $this->font('Arial', '', 10);
        $this->text(15, $iStartPos + 4, $text);
        $iStartPos += 4;
    }

    /**
     * Adds additional RatePAY Installment informations.
     *
     * @param int &$iStartPos text start position
     */
    private function _setRateMethodInfo(&$iStartPos)
    {
        $oPayment = oxNew('oxpayment');
        $oPayment->loadInLang(
            $this->_oData->getSelectedLang(),
            $this->_oData->oxorder__oxpaymenttype->value
        );

        $text = $this->_oData->translate('PI_RATEPAY_RATE_PDF_PAYMETHOD')
            . " " . $oPayment->oxpayments__oxdesc->value;
        $this->font('Arial', '', 10);
        $this->text(15, $iStartPos + 4, $text);
        $iStartPos += 8;

        $text = $this->_oData->translate('PI_RATEPAY_RATE_PLAN_HINT');
        $this->text(15, $iStartPos + 4, $text);
        $iStartPos += 8;
    }

    /**
     * Adds additional RatePAY ELV informations.
     *
     * @param int &$iStartPos text start position
     */
    private function _setElvMethodInfo(&$iStartPos)
    {
        $oPayment = oxNew('oxpayment');
        $oPayment->loadInLang(
            $this->_oData->getSelectedLang(),
            $this->_oData->oxorder__oxpaymenttype->value
        );

        $text = $this->_oData->translate('PI_RATEPAY_ELV_PDF_PAYMETHOD')
            . " " . $oPayment->oxpayments__oxdesc->value;
        $this->font('Arial', '', 10);
        $this->text(15, $iStartPos + 4, $text);
        $iStartPos += 4;
    }

    /**
     * Adds additional RatePAY Invoice informations.
     *
     * @param int &$iStartPos text start position
     */
    private function _setRechnungUntilInfo(&$iStartPos)
    {
        $settings = oxNew('pi_ratepay_settings');
        $settings->loadByType('invoice');

        $text = $this->_oData->translate('PI_RATEPAY_RECHNUNG_PDF_PAYUNTIL_1');
        $this->text(15, $iStartPos + 4, $text);

        $width = 15 + $this->_oPdf->getStringWidth($text);
        $due = $settings->pi_ratepay_settings__duedate->rawValue;
        $text = $this->_oData->translate('PI_RATEPAY_RECHNUNG_PDF_PAYUNTIL_2');
        $this->text($width, $iStartPos + 4, $due . $text);
        $iStartPos += 4;

        $text = $this->_oData->translate('PI_RATEPAY_RECHNUNG_PDF_PAYTRANSFER');
        $this->text(15, $iStartPos + 8, $text);
        $iStartPos += 8;

        $value = $settings->pi_ratepay_settings__account_holder->rawValue;
        $text = $this->_oData->translate(
            'PI_RATEPAY_RECHNUNG_PDF_ACCOUNTHOLDER'
        ) . " $value";
        $this->text(15, $iStartPos + 8, $text);
        $iStartPos += 8;

        $value = $settings->pi_ratepay_settings__bank_name->rawValue;
        $text = $this->_oData->translate(
            'PI_RATEPAY_RECHNUNG_PDF_BANKNAME'
        ) . " $value";
        $this->text(15, $iStartPos + 4, $text);
        $iStartPos += 4;

        $value = $settings->pi_ratepay_settings__bank_code_number->rawValue;
        $text = $this->_oData->translate(
            'PI_RATEPAY_RECHNUNG_PDF_BANKCODENUMBER'
        ) . " $value";
        $this->text(15, $iStartPos + 4, $text);
        $iStartPos += 4;

        $value = $settings->pi_ratepay_settings__account_number->rawValue;
        $text = $this->_oData->translate(
            'PI_RATEPAY_RECHNUNG_PDF_ACCOUNTNUMBER'
        ) . " $value";
        $this->text(15, $iStartPos + 4, $text);
        $iStartPos += 4;


        $oid = $this->_oData->getId();

        $ratepayOrder = oxNew('pi_ratepay_orders');
        $ratepayOrder->loadByOrderNumber($oid);

        $value = $ratepayOrder->pi_ratepay_orders__descriptor->rawValue;
        $text = $this->_oData->translate(
            'PI_RATEPAY_RECHNUNG_PDF_REFERENCE'
        ) . " " . $value;
        $this->text(15, $iStartPos + 4, $text);
        $iStartPos += 4;


        $text = $this->_oData->translate(
            'PI_RATEPAY_RECHNUNG_PDF_INTERNATIONALDESC'
        );
        $this->text(15, $iStartPos + 4, $text);
        $iStartPos += 4;

        $value = $settings->pi_ratepay_settings__swift_bic->rawValue;
        $values = $settings->pi_ratepay_settings__iban->rawValue;
        $text = $this->_oData->translate('PI_RATEPAY_RECHNUNG_PDF_SWIFTBIC')
            . " $value "
            . $this->_oData->translate('PI_RATEPAY_RECHNUNG_PDF_IBAN')
            . " $values";
        $this->text(15, $iStartPos + 4, $text);
        $iStartPos += 4;

        $text = $this->_oData->translate(
            'PI_RATEPAY_RECHNUNG_PDF_ADDITIONALINFO_1'
        );
        $this->text(15, $iStartPos + 8, $text);
        $iStartPos += 8;

        $text = $this->_oData->translate(
            'PI_RATEPAY_RECHNUNG_PDF_ADDITIONALINFO_2'
        );
        $this->text(15, $iStartPos + 4, $text);
        $iStartPos += 4;

        $text = $this->_oData->translate(
            'PI_RATEPAY_RECHNUNG_PDF_ADDITIONALINFO_3'
        );
        $this->text(15, $iStartPos + 4, $text);
        $iStartPos += 4;

        $text = $this->_oData->translate(
            'PI_RATEPAY_RECHNUNG_PDF_ADDITIONALINFO_4'
        );
        $this->text(15, $iStartPos + 4, $text);
        $iStartPos += 4;

        $value = $settings->pi_ratepay_settings__invoice_field->rawValue;

        if ($value != "") {
            $iStartPos += 4;
            $textArray = explode("\r\n", $value);

            foreach ($textArray as $text) {
                $this->text(15, $iStartPos + 4, $text);
                $iStartPos += 4;
            }
        }
    }

    /**
     * Adds additional RatePAY Installment informations.
     *
     * @param int &$iStartPos text start position
     */
    private function _setRateUntilInfo(&$iStartPos)
    {
        $settings = oxNew('pi_ratepay_settings');
        $settings->loadByType('installment');

        $value = $settings->pi_ratepay_settings__debt_holder->rawValue;
        $text = $this->_oData->translate(
            'PI_RATEPAY_RATE_PDF_ADDITIONALINFO_1'
        ) . $value . ', ';
        $this->text(15, $iStartPos + 4, $text);
        $iStartPos += 4;

        $text = $this->_oData->translate(
            'PI_RATEPAY_RATE_PDF_ADDITIONALINFO_2'
        ) . $value;
        $this->text(15, $iStartPos + 4, $text);
        $iStartPos += 4;

        $text = $this->_oData->translate(
            'PI_RATEPAY_RATE_PDF_ADDITIONALINFO_3'
        ) . $value;
        $this->text(15, $iStartPos + 4, $text);
        $iStartPos += 4;

        $text = $this->_oData->translate(
            'PI_RATEPAY_RATE_PDF_ADDITIONALINFO_4'
        );
        $this->text(15, $iStartPos + 4, $text);
        $iStartPos += 8;

        $text = $this->_oData->translate('PI_RATEPAY_RATE_PAYMENT_HINT');
        $this->text(15, $iStartPos + 4, $text);
        $iStartPos += 4;

        // Payment Information
        $accountHolder =
            $settings->pi_ratepay_settings__account_holder->rawValue;
        $bankName = $settings->pi_ratepay_settings__bank_name->rawValue;
        $bankCode = $this->_oData->translate(
            'PI_RATEPAY_RATE_PDF_BANKCODENUMBER_SHORT')
            . ': '
            . $settings->pi_ratepay_settings__bank_code_number->rawValue;
        $accountNumber = $this->_oData->translate(
            'PI_RATEPAY_RATE_PDF_ACCOUNTNUMBER_SHORT')
            . ': ' . $settings->pi_ratepay_settings__account_number->rawValue;

        $text = $accountHolder
            . ', ' . $bankName
            . ', ' . $bankCode
            . ', ' . $accountNumber
            . '.';
        $this->text(15, $iStartPos + 4, $text);
        $iStartPos += 4;

        $value = $settings->pi_ratepay_settings__invoice_field->rawValue;

        if ($value != "") {
            $iStartPos += 4;
            $textArray = explode("\r\n", $value);

            foreach ($textArray as $text) {
                $this->text(15, $iStartPos + 4, $text);
                $iStartPos += 4;
            }
        }
    }

    /**
     * Adds additional RatePAY ELV informations.
     *
     * @param int &$iStartPos text start position
     */
    private function _setElvUntilInfo(&$iStartPos)
    {
        $paymentMethod = pi_ratepay_util_utilities::getPaymentMethod(
            $oPayment->oxpayments__oxid->value
        );
        $settings = oxNew('pi_ratepay_settings');
        $settings->loadByType($paymentMethod);

        $text = $this->_oData->translate('PI_RATEPAY_ELV_PDF_PAYUNTIL_1');
        $this->text(15, $iStartPos + 4, $text);
        $iStartPos += 4;

        $text = $this->_oData->translate('PI_RATEPAY_ELV_PDF_PAYUNTIL_2');
        $this->text(15, $iStartPos + 4, $text);
        $iStartPos += 4;

        $text = $this->_oData->translate('PI_RATEPAY_ELV_PDF_PAYUNTIL_3');
        $this->text(15, $iStartPos + 4, $text);

        $width = 15 + $this->_oPdf->getStringWidth($text);
        $due = $settings->pi_ratepay_settings__duedate->rawValue;
        $text = $this->_oData->translate('PI_RATEPAY_ELV_PDF_PAYUNTIL_4');
        $this->text($width, $iStartPos + 4, $due . $text);
        $iStartPos += 4;

        $text = $this->_oData->translate('PI_RATEPAY_ELV_PDF_ADDITIONALINFO_1');
        $this->text(15, $iStartPos + 8, $text);
        $iStartPos += 8;

        $text = $this->_oData->translate('PI_RATEPAY_ELV_PDF_ADDITIONALINFO_2');
        $this->text(15, $iStartPos + 4, $text);
        $iStartPos += 4;

        $text = $this->_oData->translate('PI_RATEPAY_ELV_PDF_ADDITIONALINFO_3');
        $this->text(15, $iStartPos + 4, $text);
        $iStartPos += 4;

        $text = $this->_oData->translate('PI_RATEPAY_ELV_PDF_ADDITIONALINFO_4');
        $this->text(15, $iStartPos + 4, $text);
        $iStartPos += 4;

        $value = $settings->pi_ratepay_settings__invoice_field->rawValue;

        if ($value != "") {
            $iStartPos += 4;
            $textArray = explode("\r\n", $value);

            foreach ($textArray as $text) {
                $this->text(15, $iStartPos + 4, $text);
                $iStartPos += 4;
            }
        }
    }

    /**
     * Name of payment method used for order.
     * @return string Payment method
     */
    private function _getPaymentMethod()
    {
        $oPayment = oxNew('oxpayment');
        $oPayment->loadInLang(
            $this->_oData->getSelectedLang(),
            $this->_oData->oxorder__oxpaymenttype->value
        );

        return $oPayment->oxpayments__oxid->value;
    }

}
