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
 * Additionally adds RatePAY specific informations.
 *
 * @package PayIntelligent_RatePAY
 * @extends oxOrder
 */
class pi_ratepay_oxorder extends pi_ratepay_oxorder_parent
{

    /**
     * installment, invoice or elv; 'pi_ratepay_rate' || 'pi_ratepay_rechnung' || 'pi_ratepay_elv'
     * @var string
     */
    private $_ratepayPaymentMethod = '';

    /**
     * same as $_ratepayPaymentMethod just in upper case
     * @var string
     */
    private $_ratepayPaymentMethodUpperCase = '';

    /**
     * {@inheritdoc}
     *
     * Additionally adds RatePAY informations.
     *
     * @see MyOrder::pdfFooter()
     * @param oxPDF $oPdf pdf document object
     */
    public function pdfFooter($oPdf)
    {
        $this->_ratepayPaymentMethod = $this->oxorder__oxpaymenttype->getRawValue();
        if ($this->_ratepayPaymentMethod && in_array($this->_ratepayPaymentMethod, pi_ratepay_util_utilities::$_RATEPAY_PAYMENT_METHOD)) {
            $this->_ratepayPaymentMethodUpperCase = strtoupper($this->_ratepayPaymentMethod);

            $oShop = $this->_getActShop();

            $oPdf->line(15, 272, 195, 272);

            /* column 1 - company name, shop owner info, shop address */
            $oPdf->setFont('Arial', '', 7);

            $oPdf->text(
                    15, 275, strip_tags($oShop->oxshops__oxcompany->getRawValue())
                    . $this->translate($this->_ratepayPaymentMethodUpperCase . '_PDF_BULL')
                    . strip_tags($oShop->oxshops__oxurl->getRawValue())
            );

            $oPdf->text(
                    15, 278, strip_tags($oShop->oxshops__oxstreet->getRawValue()) . ','
                    . strip_tags($oShop->oxshops__oxzip->getRawValue()) . " "
                    . strip_tags($oShop->oxshops__oxcity->getRawValue())
                    . $this->translate($this->_ratepayPaymentMethodUpperCase . '_PDF_BULL')
                    . $this->translate($this->_ratepayPaymentMethodUpperCase . '_PDF_FON') . " "
                    . strip_tags($oShop->oxshops__oxtelefon->getRawValue())
                    . $this->translate($this->_ratepayPaymentMethodUpperCase . '_PDF_BULL')
                    . $this->translate($this->_ratepayPaymentMethodUpperCase . '_PDF_FAX') . " "
                    . strip_tags($oShop->oxshops__oxtelefax->getRawValue())
                    . $this->translate($this->_ratepayPaymentMethodUpperCase . '_PDF_BULL')
                    . $this->translate($this->_ratepayPaymentMethodUpperCase . '_PDF_EMAIL') . " "
                    . strip_tags($oShop->oxshops__oxorderemail->getRawValue())
            );

            $text = '';

            if ($oShop->oxshops__oxfname->getRawValue() != "" && $oShop->oxshops__oxlname->getRawValue() != "") {
                $text = $this->translate($this->_ratepayPaymentMethodUpperCase . '_PDF_OWNER') . " "
                        . strip_tags($oShop->oxshops__oxfname->getRawValue()) . " "
                        . strip_tags($oShop->oxshops__oxlname->getRawValue());
            }

            if ($oShop->oxshops__oxcourt->getRawValue() != "") {
                if ($text != "") {
                    $text = $text
                            . $this->translate($this->_ratepayPaymentMethodUpperCase . '_PDF_BULL')
                            . $this->translate($this->_ratepayPaymentMethodUpperCase . '_PDF_COURT') . " "
                            . strip_tags($oShop->oxshops__oxcourt->getRawValue());
                } else {
                    $text = $this->translate($this->_ratepayPaymentMethodUpperCase . '_PDF_COURT') . " "
                            . strip_tags($oShop->oxshops__oxcourt->getRawValue());
                }
            }

            if ($oShop->oxshops__oxhrbnr->getRawValue() != "") {
                if ($text != "") {
                    $text = $text
                            . $this->translate($this->_ratepayPaymentMethodUpperCase . '_PDF_BULL')
                            . $this->translate($this->_ratepayPaymentMethodUpperCase . '_PDF_HR') . " "
                            . strip_tags($oShop->oxshops__oxhrbnr->getRawValue());
                } else {
                    $text = $this->translate($this->_ratepayPaymentMethodUpperCase . '_PDF_HR') . " "
                            . strip_tags($oShop->oxshops__oxhrbnr->getRawValue());
                }
            }

            if ($oShop->oxshops__oxvatnumber->getRawValue() != "") {
                if ($text != "") {
                    $text = $text
                            . $this->translate($this->_ratepayPaymentMethodUpperCase . '_PDF_BULL')
                            . $this->translate('ORDER_OVERVIEW_PDF_TAXIDNR') . " "
                            . strip_tags($oShop->oxshops__oxvatnumber->getRawValue());
                } else {
                    $text = $this->translate('ORDER_OVERVIEW_PDF_TAXIDNR') . " "
                            . strip_tags($oShop->oxshops__oxvatnumber->getRawValue());
                }
            }

            $oPdf->text(15, 281, $text);

            //logo
            $myConfig = $this->getConfig();
            $aSize = getimagesize($myConfig->getImageDir(true) . 'pi_ratepay_pdf_logo.png');
            $iMargin = 195 - $aSize[0] * 0.15;
            $height = 272;
            $oPdf->image($myConfig->getImageDir(true) . 'pi_ratepay_pdf_logo.png', $iMargin, $height, $aSize[0] * 0.15, $aSize[1] * 0.15, 'PNG', $oShop->oxshops__oxurl->value);
        } else {
            parent::pdfFooter($oPdf);
        }
    }

    /**
     * {@inheritdoc}
     *
     * Additionally adds RatePAY informations.
     *
     * @see MyOrder::exportStandart()
     * @param oxPDF $oPdf pdf document object
     */
    public function exportStandart($oPdf)
    {
        $this->_ratepayPaymentMethod = $this->oxorder__oxpaymenttype->getRawValue();
        if ($this->_ratepayPaymentMethod && in_array($this->_ratepayPaymentMethod, pi_ratepay_util_utilities::$_RATEPAY_PAYMENT_METHOD)) {
            $this->_ratepayPaymentMethodUpperCase = strtoupper($this->_ratepayPaymentMethod);

            // preparing order curency info
            $myConfig = $this->getConfig();

            $this->_oCur = $myConfig->getCurrencyObject($this->oxorder__oxcurrency->value);

            if (!$this->_oCur) {
                $this->_oCur = $myConfig->getActShopCurrencyObject();
            }

            // loading active shop
            $oShop = $this->_getActShop();

            // shop information
            $oPdf->setFont('Arial', '', 6);
            $oPdf->text(15, 55, $oShop->oxshops__oxname->getRawValue() . ' - ' . $oShop->oxshops__oxstreet->getRawValue() . ' - ' . $oShop->oxshops__oxzip->value . ' - ' . $oShop->oxshops__oxcity->getRawValue());

            // billing address
            $this->_setBillingAddressToPdf($oPdf);

            // delivery address
            if ($this->oxorder__oxdelsal->value) {
                $this->_setDeliveryAddressToPdf($oPdf);
            }

            // loading user info
            $oUser = oxNew('oxuser');
            $oUser->load($this->oxorder__oxuserid->value);

            // customer number
            $sCustNr = $this->translate('ORDER_OVERVIEW_PDF_CUSTNR') . ' ' . $oUser->oxuser__oxcustnr->value;
            $oPdf->setFont('Arial', '', 7);
            $oPdf->text(195 - $oPdf->getStringWidth($sCustNr), 59, $sCustNr);


            if ($this->_ratepayPaymentMethod == 'pi_ratepay_rate') {
                $settings = oxNew('pi_ratepay_settings');
                $settings->loadByType('installment');
                // Header bank details
                $accountHolder = $settings->pi_ratepay_settings__account_holder->rawValue;
                $bankName = $settings->pi_ratepay_settings__bank_name->rawValue;
                $bankCode = $settings->pi_ratepay_settings__bank_code_number->rawValue;
                $accountNumber = $settings->pi_ratepay_settings__account_number->rawValue;
                $bankCodeTitle = $this->translate('PI_RATEPAY_RATE_PDF_BANKCODENUMBER_SHORT');
                $accountNumberTitle = $this->translate('PI_RATEPAY_RATE_PDF_ACCOUNTNUMBER_SHORT');
                $bankCodeText = $bankCodeTitle . ': ' . $bankCode;
                $accountNumberText = $accountNumberTitle . ': ' . $accountNumber;

                $oPdf->setFont('Arial', '', 10);
                $iTopHeaderBankDetails = 70;
                $oPdf->text(195 - $oPdf->getStringWidth($accountHolder), $iTopHeaderBankDetails, $accountHolder);
                $oPdf->text(195 - $oPdf->getStringWidth($bankName), $iTopHeaderBankDetails += 4, $bankName);
                $oPdf->text(195 - $oPdf->getStringWidth($bankCodeText), $iTopHeaderBankDetails += 4, $bankCodeText);
                $oPdf->text(195 - $oPdf->getStringWidth($accountNumberText), $iTopHeaderBankDetails += 4, $accountNumberText);
            }

            // setting position if delivery address is used
            if ($this->oxorder__oxdelsal->value) {
                $iTop = 115;
            } else {
                $iTop = 91;
            }

            // shop city
            $sText = $oShop->oxshops__oxcity->getRawValue() . ', ' . date('d.m.Y');
            $oPdf->setFont('Arial', '', 10);
            $oPdf->text(195 - $oPdf->getStringWidth($sText), $iTop + 8, $sText);

            // shop VAT number
            if ($oShop->oxshops__oxvatnumber->value) {
                $sText = $this->translate('ORDER_OVERVIEW_PDF_TAXIDNR') . ' ' . $oShop->oxshops__oxvatnumber->value;
                $oPdf->text(195 - $oPdf->getStringWidth($sText), $iTop + 12, $sText);
                $iTop += 8;
            } else {
                $iTop += 4;
            }

            // invoice number
            $sText = $this->translate('ORDER_OVERVIEW_PDF_COUNTNR') . ' ' . $this->oxorder__oxbillnr->value;
            $oPdf->text(195 - $oPdf->getStringWidth($sText), $iTop + 8, $sText);

            // marking if order is canceled
            if ($this->oxorder__oxstorno->value == 1) {
                $this->oxorder__oxordernr->setValue($this->oxorder__oxordernr->getRawValue() . '   ' . $this->translate('ORDER_OVERVIEW_PDF_STORNO'), oxField::T_RAW);
            }

            // order number
            $oPdf->setFont('Arial', '', 12);
            $oPdf->text(15, $iTop, $this->translate('ORDER_OVERVIEW_PDF_PURCHASENR') . ' ' . $this->oxorder__oxordernr->value);

            //RATEPAY
            $oid = $this->getId();
            $ratepayOrder = oxNew('pi_ratepay_orders');
            $ratepayOrder->loadByOrderNumber($oid);

            $value = $ratepayOrder->pi_ratepay_orders__descriptor->rawValue;
            $oPdf->text(15, $iTop + 4, $this->translate($this->_ratepayPaymentMethodUpperCase . '_PDF_RATEPAYID') . ' ' . $value);

            // order date
            $oPdf->setFont('Arial', '', 10);
            $aOrderDate = explode(' ', $this->oxorder__oxorderdate->value);
            $sOrderDate = oxUtilsDate::getInstance()->formatDBDate($aOrderDate[0]);
            $oPdf->text(15, $iTop + 8, $this->translate('ORDER_OVERVIEW_PDF_ORDERSFROM') . $sOrderDate . $this->translate('ORDER_OVERVIEW_PDF_ORDERSAT') . $oShop->oxshops__oxurl->value);

            $oPdf->text(15, $iTop + 12, $this->translate($this->_ratepayPaymentMethodUpperCase . '_PDF_ABOVEARTICLE'));

            $iTop += 16;

            // product info header
            $oPdf->setFont('Arial', '', 8);
            $oPdf->text(15, $iTop, $this->translate('ORDER_OVERVIEW_PDF_AMOUNT'));
            $oPdf->text(30, $iTop, $this->translate('ORDER_OVERVIEW_PDF_ARTID'));
            $oPdf->text(45, $iTop, $this->translate('ORDER_OVERVIEW_PDF_DESC'));
            $oPdf->text(145, $iTop, $this->translate('ORDER_OVERVIEW_PDF_VAT'));
            $oPdf->text(158, $iTop, $this->translate('ORDER_OVERVIEW_PDF_UNITPRICE'));
            $sText = $this->translate('ORDER_OVERVIEW_PDF_ALLPRICE');
            $oPdf->text(195 - $oPdf->getStringWidth($sText), $iTop, $sText);

            // separator line
            $iTop += 2;
            $oPdf->line(15, $iTop, 195, $iTop);

            // #345
            $siteH = $iTop;
            $oPdf->setFont('Arial', '', 10);

            // order articles
            $this->_oArticles = null;
            $this->_setOrderArticlesToPdf($oPdf, $siteH, true);

            // generating pdf file
            switch ($this->_ratepayPaymentMethod) {
                case 'pi_ratepay_rate':
                    $oArtSumm = new pi_ratepay_rate_pdf_article_summary($this, $oPdf);
                    break;
                case 'pi_ratepay_rechnung':
                    $oArtSumm = new pi_ratepay_rechnung_pdf_article_summary($this, $oPdf);
                    break;
                case 'pi_ratepay_elv':
                    $oArtSumm = new pi_ratepay_elv_pdf_article_summary($this, $oPdf);
                    break;
                default:
                    $oArtSumm = new PdfArticleSummary($this, $oPdf);
                    break;
            }

            $iHeight = $oArtSumm->generate($siteH);
            if ($siteH + $iHeight > 258) {
                $this->pdfFooter($oPdf);
                $iTop = $this->pdfHeader($oPdf);
                $oArtSumm->ajustHeight($iTop - $siteH);
                $siteH = $iTop;
            }

            $oArtSumm->run($oPdf);
            $siteH += $iHeight + 8;

            $oPdf->text(15, $siteH, $this->translate('ORDER_OVERVIEW_PDF_GREETINGS'));
        } else {
            parent::exportStandart($oPdf);
        }
    }

    /**
     * {@inheritdoc}
     *
     * Additionally adds RatePAY informations.
     *
     * @param oxPDF $oPdf
     */
    public function exportDeliveryNote($oPdf)
    {
        if ($this->oxorder__oxpaymenttype->getRawValue() == 'pi_ratepay_rechnung' || $this->oxorder__oxpaymenttype->getRawValue() == 'pi_ratepay_rate') {
            $this->_ratepayPaymentMethod = $this->oxorder__oxpaymenttype->getRawValue();
            $this->_ratepayPaymentMethodUpperCase = strtoupper($this->_ratepayPaymentMethod);

            $myConfig = $this->getConfig();
            $oShop = $this->_getActShop();

            $oLang = oxLang::getInstance();
            $sSal = $this->oxorder__oxdelsal->value;
            try {
                $sSal = $oLang->translateString($this->oxorder__oxdelsal->value, $this->_iSelectedLang);
            } catch (Exception $e) {

            }

            // loading order currency info
            $this->_oCur = $myConfig->getCurrencyObject($this->oxorder__oxcurrency->value);
            if (!isset($this->_oCur)) {
                $this->_oCur = $myConfig->getActShopCurrencyObject();
            }

            // shop info
            $oPdf->setFont('Arial', '', 6);
            $oPdf->text(15, 55, $oShop->oxshops__oxname->getRawValue() . ' - ' . $oShop->oxshops__oxstreet->getRawValue() . ' - ' . $oShop->oxshops__oxzip->value . ' - ' . $oShop->oxshops__oxcity->getRawValue());

            // delivery address
            $oPdf->setFont('Arial', '', 10);
            if ($this->oxorder__oxdelsal->value) {
                $oPdf->text(15, 59, $sSal);
                $oPdf->text(15, 63, $this->oxorder__oxdellname->getRawValue() . ' ' . $this->oxorder__oxdelfname->getRawValue());
                $oPdf->text(15, 67, $this->oxorder__oxdelcompany->getRawValue());
                $oPdf->text(15, 71, $this->oxorder__oxdelstreet->getRawValue() . ' ' . $this->oxorder__oxdelstreetnr->value);
                $oPdf->setFont('Arial', 'B', 10);
                $oPdf->text(15, 75, $this->oxorder__oxdelzip->value . ' ' . $this->oxorder__oxdelcity->getRawValue());
                $oPdf->setFont('Arial', '', 10);
                $oPdf->text(15, 79, $this->oxorder__oxdelcountry->getRawValue());
            } else {
                // no delivery address - billing address is used for delivery
                $this->_setBillingAddressToPdf($oPdf);
            }

            // loading user info
            $oUser = oxNew('oxuser');
            $oUser->load($this->oxorder__oxuserid->value);

            // customer number
            $sCustNr = $this->translate('ORDER_OVERVIEW_PDF_CUSTNR') . ' ' . $oUser->oxuser__oxcustnr->value;
            $oPdf->setFont('Arial', '', 7);
            $oPdf->text(195 - $oPdf->getStringWidth($sCustNr), 73, $sCustNr);

            // shops city
            $sText = $oShop->oxshops__oxcity->getRawValue() . ', ' . date('d.m.Y');
            $oPdf->setFont('Arial', '', 10);
            $oPdf->text(195 - $oPdf->getStringWidth($sText), 95, $sText);

            $iTop = 99;
            // shop VAT number
            if ($oShop->oxshops__oxvatnumber->value) {
                $sText = $this->translate('ORDER_OVERVIEW_PDF_TAXIDNR') . ' ' . $oShop->oxshops__oxvatnumber->value;
                $oPdf->text(195 - $oPdf->getStringWidth($sText), $iTop, $sText);
                $iTop += 4;
            }

            // invoice number
            $sText = $this->translate('ORDER_OVERVIEW_PDF_COUNTNR') . ' ' . $this->oxorder__oxbillnr->value;
            $oPdf->text(195 - $oPdf->getStringWidth($sText), $iTop, $sText);

            // canceled order marker
            if ($this->oxorder__oxstorno->value == 1) {
                $this->oxorder__oxordernr->setValue($this->oxorder__oxordernr->getRawValue() . '   ' . $this->translate('ORDER_OVERVIEW_PDF_STORNO'), oxField::T_RAW);
            }

            // order number
            $oPdf->setFont('Arial', '', 12);
            $oPdf->text(15, 108, $this->translate('ORDER_OVERVIEW_PDF_DELIVNOTE') . ' ' . $this->oxorder__oxordernr->value);

            //RATEPAY
            $oid = $this->getId();

            $ratepayOrder = oxNew('pi_ratepay_orders');
            $ratepayOrder->loadByOrderNumber($oid);

            $value = $ratepayOrder->pi_ratepay_orders__descriptor->rawValue;
            $oPdf->text(15, 104, $this->translate($this->_ratepayPaymentMethodUpperCase . '_PDF_RATEPAYID') . ' ' . $value);

            // order date
            $aOrderDate = explode(' ', $this->oxorder__oxorderdate->value);
            $sOrderDate = oxUtilsDate::getInstance()->formatDBDate($aOrderDate[0]);
            $oPdf->setFont('Arial', '', 10);
            $oPdf->text(15, 119, $this->translate('ORDER_OVERVIEW_PDF_ORDERSFROM') . $sOrderDate . $this->translate('ORDER_OVERVIEW_PDF_ORDERSAT') . $oShop->oxshops__oxurl->value);

            // product info header
            $oPdf->setFont('Arial', '', 8);
            $oPdf->text(15, 128, $this->translate('ORDER_OVERVIEW_PDF_AMOUNT'));
            $oPdf->text(30, 128, $this->translate('ORDER_OVERVIEW_PDF_ARTID'));
            $oPdf->text(45, 128, $this->translate('ORDER_OVERVIEW_PDF_DESC'));

            // line separator
            $oPdf->line(15, 130, 195, 130);

            // product list
            $oPdf->setFont('Arial', '', 10);
            $siteH = 130;

            // order articles
            $this->_oArticles = null;
            $this->_setOrderArticlesToPdf($oPdf, $siteH, false);

            // sine separator
            $oPdf->line(15, $siteH + 2, 195, $siteH + 2);
            $siteH += 4;

            // payment date
            $oPdf->setFont('Arial', '', 10);
            $text = $this->translate('ORDER_OVERVIEW_PDF_PAYUPTO') . date('d.m.Y', mktime(0, 0, 0, date('m'), date('d') + 7, date('Y')));
            $oPdf->text(15, $siteH + 4, $text);
        } else {
            parent::exportDeliveryNote($oPdf);
        }
    }

}
