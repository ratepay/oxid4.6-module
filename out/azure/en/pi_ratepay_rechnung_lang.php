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
 * @package   PayIntelligent_RatePAY_Rechnung
 * @copyright (C) 2011 PayIntelligent GmbH  <http://www.payintelligent.de/>
 * @license	http://www.gnu.org/licenses/  GNU General Public License 3
 */
// -------------------------------
// RESOURCE IDENTITFIER = STRING
// -------------------------------
$sLangName = "English";

$piErrorAge = 'Um eine Zahlung per RatePAY Rechnung durchzuf&uuml;hren, m&uuml;ssen Sie mindestens 18 Jahre alt sein.';
$piErrorBirth = 'To make a payment via RatePAY Rechnung, please provide your birth date.';
$piErrorPhone = 'To make a payment via RatePAY Rechnung, please provide your phone numer.';
$piErrorCompany = 'Geben Sie bitte Ihren Firmennamen und Ihre Umsatzsteuer-ID ein.';
$piErrorBirthdayDigits = 'Geben Sie bitte Ihr Geburtsjahr vierstellig ein. (z.B. 1982)';

$aLang = array(
    'charset'                                            => 'UTF-8',
    'PI_RATEPAY_RECHNUNG_VIEW_INFORMATION_TEXT_1'        => ' offers the payment method RatePAY Invoicing in cooperation with RatePAY. You are purchasing on account. The invoice is die for payment within ',
    'PI_RATEPAY_RECHNUNG_VIEW_INFORMATION_TEXT_1_PART_2' => ' days after invoice date.',
    'PI_RATEPAY_RECHNUNG_VIEW_INFORMATION_TEXT_2'        => 'RatePAY Invoicing can be used as a payment method <b>from a minimum shopping basket value of ',
    'PI_RATEPAY_RECHNUNG_VIEW_INFORMATION_TEXT_3'        => ' &#8364;</b><b> to a maximum shopping basket value of ',
    'PI_RATEPAY_RECHNUNG_VIEW_INFORMATION_TEXT_4'        => ' &#8364;</b> (values including VAT and shipping costs).',
    'PI_RATEPAY_RECHNUNG_VIEW_INFORMATION_TEXT_5'        => 'Please note that RatePAY Invoicing can only be used as a payment method when billing and shipping address entered is your address registered with the authorities (company addresses and post-office box addresses are not accepted). Your address registered with the authorities has to be in Germany. If necessary please go back to the previous page and amend your personal data.',
    'PI_RATEPAY_RECHNUNG_VIEW_POLICY_TEXT_1'             => 'I have read and accepted  the ',
    'PI_RATEPAY_RECHNUNG_VIEW_POLICY_TEXT_2'             => '. I was informed about my ',
    'PI_RATEPAY_RECHNUNG_VIEW_POLICY_TEXT_3'             => '. ',
    'PI_RATEPAY_RECHNUNG_VIEW_POLICY_AGB'                => 'general terms and conditions',
    'PI_RATEPAY_RECHNUNG_VIEW_POLICY_WIDER'              => 'withdrawal',
    'PI_RATEPAY_RECHNUNG_VIEW_POLICY_TEXT_4'             => 'In addition I also agree that my personal data is utilized by RatePAY according to the ',
    'PI_RATEPAY_RECHNUNG_VIEW_POLICY_TEXT_5'             => ' and ',
    'PI_RATEPAY_RECHNUNG_VIEW_POLICY_OWNERPOLICY'        => 'Shop Data Privacy Statement',
    'PI_RATEPAY_RECHNUNG_VIEW_POLICY_TEXT_6'             => '. In order to accomplish the contract I agree in particular to be contacted by all parties involved via my email address provided.',
    'PI_RATEPAY_RECHNUNG_VIEW_POLICY_PRIVACYPOLICY'      => 'RatePAY Data Privacy Statement',
    'PI_RATEPAY_RECHNUNG_ERROR'                          => 'Sorry, there is no payment with RatePAY possible. This decision was taken by RatePAY on the basis of an automated data processing algorithm. For Details, please read the ',
    'PI_RATEPAY_RECHNUNG_AGBERROR'                       => 'Please accept the conditions.',
    'PI_RATEPAY_RECHNUNG_SUCCESS'                        => 'Order completed successfully',
    'PI_RATEPAY_RECHNUNG_ERROR_BIRTH'                    => $piErrorBirth,
    'PI_RATEPAY_RECHNUNG_ERROR_PHONE'                    => $piErrorPhone,
    'PI_RATEPAY_RECHNUNG_ERROR_ADDRESS'                  => 'Please note that RatePAY Invoicing can only be used as a payment method when billing and shipping address entered are equal.',
    'PI_RATEPAY_RECHNUNG_ERROR_AGE'                      => $piErrorAge,
    'PI_RATEPAY_RECHNUNG_VIEW_PAYMENT_FON'               => 'Fon:',
    'PI_RATEPAY_RECHNUNG_VIEW_PAYMENT_MOBILFON'          => 'Mobilfon:',
    'PI_RATEPAY_RECHNUNG_VIEW_PAYMENT_BIRTHDATE'         => 'Birthdate:',
    'PI_RATEPAY_RECHNUNG_VIEW_PAYMENT_BIRTHDATE_FORMAT'  => '(dd.mm.yyyy)',
    'PI_RATEPAY_RECHNUNG_VIEW_PAYMENT_FON_NOTE'          => 'Please insert Mobilfon or Telefonnumber.',
    'PI_RATEPAY_RECHNUNG_VIEW_PAYMENT_COMPANY'           => 'Company:',
    'PI_RATEPAY_RECHNUNG_VIEW_PAYMENT_UST'               => 'Vat ID No:',
    'PI_RATEPAY_ERROR_BIRTHDAY_YEAR_DIGITS'              => $piErrorBirthdayDigits,
    'PI_RATEPAY_ERROR_COMPANY'                           => $piErrorCompany
);
