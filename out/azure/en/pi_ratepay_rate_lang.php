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
 * @package   PayIntelligent_RatePAY_Rate
 * @copyright (C) 2011 PayIntelligent GmbH  <http://www.payintelligent.de/>
 * @license	http://www.gnu.org/licenses/  GNU General Public License 3
 */
// -------------------------------
// RESOURCE IDENTITFIER = STRING
// -------------------------------
$sLangName = "English";

$piErrorAge = 'Um eine Zahlung per RatePAY Rate durchzuf&uuml;hren, m&uuml;ssen Sie mindestens 18 Jahre alt sein.';
$piErrorBirth = 'To make a payment via RatePAY Rate, please provide your birth date.';
$piErrorPhone = 'To make a payment via RatePAY Rate, please provide your phone numer.';
$piErrorCompany = 'Geben Sie bitte Ihren Firmennamen und Ihre Umsatzsteuer-ID ein.';
$piErrorBirthdayDigits = 'Geben Sie bitte Ihr Geburtsjahr vierstellig ein. (z.B. 1982)';

$aLang = array(
    'charset'                                       => 'UTF-8',
    'PI_RATEPAY_RATE_VIEW_INFORMATION_TEXT_1'       => 'Mit RatePAY-Ratenzahlung w&auml;hlen Sie eine Bezahlung in Raten.',
    'PI_RATEPAY_RATE_VIEW_INFORMATION_TEXT_2'       => 'RatePAY-Ratenzahlung kann <b>ab einem Einkaufswert von ',
    'PI_RATEPAY_RATE_VIEW_INFORMATION_TEXT_3'       => ' &#8364;</b> und <b>bis zu einem Einkaufswert von ',
    'PI_RATEPAY_RATE_VIEW_INFORMATION_TEXT_4'       => ' &#8364;</b> (jeweils inklusive Mehrwertsteuer und Versandkosten) genutzt werden.',
    'PI_RATEPAY_RATE_VIEW_INFORMATION_TEXT_5'       => 'Bitte beachten Sie, dass RatePAY-Rate nur genutzt werden kann, wenn Rechnungs- und Lieferaddresse identisch sind und Ihrem privaten Wohnort entsprechen. (keine Firmen- und keine Postfachadresse). Ihre Adresse muss im Gebiet der Bundesrepublik Deutschland liegen. Bitte gehen Sie gegebenenfalls zur&uuml;ck und korrigieren Sie Ihre Daten.',
    'PI_RATEPAY_RATE_VIEW_INFORMATION_TEXT_6'       => 'Ihre monatlichen Teilzahlungsrate, die Laufzeit der Teilzahlung und den entsprechenden Zinsaufschlag k&ouml;nnen Sie mit dem Ratenrechner im Anschluss ermitteln und festlegen.',
    'PI_RATEPAY_RATE_VIEW_POLICY_TEXT_1'            => 'I have read and accepted  the ',
    'PI_RATEPAY_RATE_VIEW_POLICY_TEXT_2'            => '. I was informed about my ',
    'PI_RATEPAY_RATE_VIEW_POLICY_TEXT_3'            => '. ',
    'PI_RATEPAY_RATE_VIEW_POLICY_AGB'               => 'general terms and conditions',
    'PI_RATEPAY_RATE_VIEW_POLICY_WIDER'             => 'withdrawal',
    'PI_RATEPAY_RATE_VIEW_POLICY_PRIVACYPOLICY'     => 'RatePAY Data Privacy Statement',
    'PI_RATEPAY_RATE_ERROR'                         => 'Sorry, there is no payment with RatePAY possible. This decision was taken by RatePAY on the basis of an automated data processing algorithm. For Details, please read the ',
    'PI_RATEPAY_RATE_AGBERROR'                      => 'Please accept the conditions.',
    'PI_RATEPAY_RATE_SUCCESS'                       => 'Order completed successfully',
    'PI_RATEPAY_RATE_ERROR_BIRTH'                   => $piErrorBirth,
    'PI_RATEPAY_RATE_ERROR_PHONE'                   => $piErrorPhone,
    'PI_RATEPAY_RATE_ERROR_ADDRESS'                 => 'Please note that RatePAY Rate can only be used as a payment method when billing and shipping address entered are equal.',
    'PI_RATEPAY_RATE_ERROR_AGE'                     => $piErrorAge,
    'PI_RATEPAY_RATE_VIEW_PAYMENT_FON'              => 'Fon:',
    'PI_RATEPAY_RATE_VIEW_PAYMENT_MOBILFON'         => 'Mobilfon:',
    'PI_RATEPAY_RATE_VIEW_PAYMENT_BIRTHDATE'        => 'Birthdate:',
    'PI_RATEPAY_RATE_VIEW_PAYMENT_BIRTHDATE_FORMAT' => '(dd.mm.yyyy)',
    'PI_RATEPAY_RATE_VIEW_PAYMENT_FON_NOTE'         => 'Please insert Mobilfon or Telefonnumber.',
    'PI_RATEPAY_RATE_VIEW_PAYMENT_COMPANY'          => 'Company:',
    'PI_RATEPAY_RATE_VIEW_PAYMENT_UST'              => 'UST-ID:',
    'PI_RATEPAY_ERROR_BIRTHDAY_YEAR_DIGITS'         => $piErrorBirthdayDigits,
    'PI_RATEPAY_ERROR_COMPANY'                      => $piErrorCompany,
    'PI_RATEPAY_RATE_ERROR_CALCULATE_TO_PROCEED'    => 'Please create an installment plan to proceed.'
);
