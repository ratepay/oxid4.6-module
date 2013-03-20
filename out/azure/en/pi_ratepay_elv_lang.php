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
 * @package   PayIntelligent_RatePAY_Elv
 * @copyright (C) 2011 PayIntelligent GmbH  <http://www.payintelligent.de/>
 * @license	http://www.gnu.org/licenses/  GNU General Public License 3
 */
// -------------------------------
// RESOURCE IDENTITFIER = STRING
// -------------------------------
$sLangName = "English";

$piErrorAge = 'Um eine Zahlung per RatePAY Lastschrift durchzuf&uuml;hren, m&uuml;ssen Sie mindestens 18 Jahre alt sein.';
$piErrorBirth = 'To make a payment via RatePAY Lastschrift, please provide your birth date.';
$piErrorPhone = 'To make a payment via RatePAY Lastschrift, please provide your phone numer.';
$piErrorCompany = 'Geben Sie bitte Ihren Firmennamen und Ihre Umsatzsteuer-ID ein.';
$piErrorBirthdayDigits = 'Geben Sie bitte Ihr Geburtsjahr vierstellig ein. (z.B. 1982)';

$aLang = array(
    'charset'                                      => 'UTF-8',
    'PI_RATEPAY_ELV_VIEW_INFORMATION_TEXT_1'       => ' offers the payment method RatePAY Lastschrift in cooperation with RatePAY. You are purchasing on account.',
    'PI_RATEPAY_ELV_VIEW_INFORMATION_TEXT_2'       => 'RatePAY Lastschrift can be used as a payment method <b>from a minimum shopping basket value of ',
    'PI_RATEPAY_ELV_VIEW_INFORMATION_TEXT_3'       => ' &#8364;</b><b> to a maximum shopping basket value of ',
    'PI_RATEPAY_ELV_VIEW_INFORMATION_TEXT_4'       => ' &#8364;</b> (values including VAT and shipping costs).',
    'PI_RATEPAY_ELV_VIEW_INFORMATION_TEXT_5'       => 'Please note that RatePAY Lastschrift can only be used as a payment method when billing and shipping address entered is your address registered with the authorities (company addresses and post-office box addresses are not accepted). Your address registered with the authorities has to be in Germany. If necessary please go back to the previous page and amend your personal data.',
    'PI_RATEPAY_ELV_VIEW_POLICY_TEXT_1'            => 'I have read and accepted  the ',
    'PI_RATEPAY_ELV_VIEW_POLICY_TEXT_2'            => '. I was informed about my ',
    'PI_RATEPAY_ELV_VIEW_POLICY_TEXT_3'            => '. ',
    'PI_RATEPAY_ELV_VIEW_POLICY_AGB'               => 'general terms and conditions',
    'PI_RATEPAY_ELV_VIEW_POLICY_WIDER'             => 'withdrawal',
    'PI_RATEPAY_ELV_VIEW_POLICY_TEXT_4'            => 'In addition I also agree that my personal data is utilized by RatePAY according to the ',
    'PI_RATEPAY_ELV_VIEW_POLICY_TEXT_5'            => ' and ',
    'PI_RATEPAY_ELV_VIEW_POLICY_OWNERPOLICY'       => 'Shop Data Privacy Statement',
    'PI_RATEPAY_ELV_VIEW_POLICY_TEXT_6'            => '. In order to accomplish the contract I agree in particular to be contacted by all parties involved via my email address provided.',
    'PI_RATEPAY_ELV_VIEW_POLICY_PRIVACYPOLICY'     => 'RatePAY Data Privacy Statement',
    'PI_RATEPAY_ELV_ERROR'                         => 'Sorry, there is no payment with RatePAY possible. This decision was taken by RatePAY on the basis of an automated data processing algorithm. For Details, please read the ',
    'PI_RATEPAY_ELV_AGBERROR'                      => 'Please accept the conditions.',
    'PI_RATEPAY_ELV_SUCCESS'                       => 'Order completed successfully',
    'PI_RATEPAY_ELV_ERROR_BIRTH'                   => $piErrorBirth,
    'PI_RATEPAY_ELV_ERROR_PHONE'                   => $piErrorPhone,
    'PI_RATEPAY_ELV_ERROR_ADDRESS'                 => 'Please note that RatePAY Lastschrift can only be used as a payment method when billing and shipping address entered are equal.',
    'PI_RATEPAY_ELV_ERROR_AGE'                     => $piErrorAge,
    'PI_RATEPAY_ELV_VIEW_PAYMENT_FON'              => 'Fon:',
    'PI_RATEPAY_ELV_VIEW_PAYMENT_MOBILFON'         => 'Mobilfon:',
    'PI_RATEPAY_ELV_VIEW_PAYMENT_BIRTHDATE'        => 'Birthdate:',
    'PI_RATEPAY_ELV_VIEW_PAYMENT_BIRTHDATE_FORMAT' => '(dd.mm.yyyy)',
    'PI_RATEPAY_ELV_VIEW_PAYMENT_FON_NOTE'         => 'Please insert Mobilfon or Telefonnumber.',
    'PI_RATEPAY_ELV_VIEW_PAYMENT_COMPANY'          => 'Company:',
    'PI_RATEPAY_ELV_VIEW_PAYMENT_UST'              => 'Vat ID No:',
    'PI_RATEPAY_ERROR_BIRTHDAY_YEAR_DIGITS'        => $piErrorBirthdayDigits,
    'PI_RATEPAY_ERROR_COMPANY'                     => $piErrorCompany,
    'PI_RATEPAY_ELV_ERROR_OWNER'                   => 'Um eine Zahlung per RatePAY Lastschrift durchzuf&uuml;hren, geben Sie bitte den Namen des Kontoinhabers ein.',
    'PI_RATEPAY_ELV_ERROR_ACCOUNT_NUMBER'          => 'Um eine Zahlung per RatePAY Lastschrift durchzuf&uuml;hren, geben Sie bitte die Kontonummer ein.',
    'PI_RATEPAY_ELV_ERROR_CODE'                    => 'Um eine Zahlung per RatePAY Lastschrift durchzuf&uuml;hren, geben Sie bitte die BLZ ein.',
    'PI_RATEPAY_ELV_ERROR_NAME'                    => 'Um eine Zahlung per RatePAY Lastschrift durchzuf&uuml;hren, geben Sie bitte den Banknamen ein.',
    'PI_RATEPAY_ELV_VIEW_BANK_OWNER'               => 'Kontoinhaber',
    'PI_RATEPAY_ELV_VIEW_BANK_ACCOUNT_NUMBER'      => 'Kontonummer',
    'PI_RATEPAY_ELV_VIEW_BANK_CODE'                => 'BLZ',
    'PI_RATEPAY_ELV_VIEW_BANK_NAME'                => 'Bankname',
    'PI_RATEPAY_ELV_ERROR_BANKCODE_TO_SHORT'       => 'Die Bankleitzahl muss acht Zeichen lang sein.'
);
