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
$sLangName = "Deutsch";

$piErrorAge = 'Um eine Zahlung per RatePAY Rate durchzuf&uuml;hren, m&uuml;ssen Sie mindestens 18 Jahre alt sein.';
$piErrorBirth = 'Um eine Zahlung per RatePAY Rate durchzuf&uuml;hren, geben Sie bitte Ihr Geburtsdatum ein.';
$piErrorPhone = 'Um eine Zahlung per RatePAY Rate durchzuf&uuml;hren, geben Sie bitte Ihre Telefonnummer ein.';
$piErrorCompany = 'Geben Sie bitte Ihren Firmennamen und Ihre Umsatzsteuer-ID ein.';
$piErrorBirthdayDigits = 'Geben Sie bitte Ihr Geburtsjahr vierstellig ein. (z.B. 1982)';

$aLang = array(
    'charset'                                       => 'UTF-8',
    'PI_RATEPAY_RATE_VIEW_WHITELABEL_TEXT'          => 'Ratenzahlung',
    'PI_RATEPAY_RATE_VIEW_INFORMATION_TEXT_1'       => 'Mit RatePAY-Ratenzahlung w&auml;hlen Sie eine Bezahlung in Raten.',
    'PI_RATEPAY_RATE_VIEW_INFORMATION_TEXT_2'       => 'RatePAY-Ratenzahlung kann <b>ab einem Einkaufswert von ',
    'PI_RATEPAY_RATE_VIEW_INFORMATION_TEXT_3'       => ' &#8364;</b> und <b>bis zu einem Einkaufswert von ',
    'PI_RATEPAY_RATE_VIEW_INFORMATION_TEXT_4'       => ' &#8364;</b> (jeweils inklusive Mehrwertsteuer und Versandkosten) genutzt werden.',
    'PI_RATEPAY_RATE_VIEW_INFORMATION_TEXT_5'       => 'Bitte beachten Sie, dass RatePAY-Rate nur genutzt werden kann, wenn Rechnungs- und Lieferaddresse identisch sind und Ihrem privaten Wohnort entsprechen. (keine Firmen- und keine Postfachadresse). Ihre Adresse muss im Gebiet der Bundesrepublik Deutschland liegen. Bitte gehen Sie gegebenenfalls zur&uuml;ck und korrigieren Sie Ihre Daten.',
    'PI_RATEPAY_RATE_VIEW_INFORMATION_TEXT_6'       => 'Ihre monatlichen Teilzahlungsrate, die Laufzeit der Teilzahlung und den entsprechenden Zinsaufschlag k&ouml;nnen Sie mit dem Ratenrechner im Anschluss ermitteln und festlegen.',
    'PI_RATEPAY_RATE_VIEW_POLICY_TEXT_1'            => 'Ich habe die ',
    'PI_RATEPAY_RATE_VIEW_POLICY_TEXT_2'            => ' zur Kenntnis genommen und erkl&auml;re mich mit deren Geltung einverstanden. Ich wurde &uuml;ber mein ',
    'PI_RATEPAY_RATE_VIEW_POLICY_TEXT_3'            => ' informiert.',
    'PI_RATEPAY_RATE_VIEW_POLICY_AGB'               => 'Allgemeinen Gesch&auml;ftsbedingungen',
    'PI_RATEPAY_RATE_VIEW_POLICY_WIDER'             => 'Widerrufsrecht',
    'PI_RATEPAY_RATE_VIEW_POLICY_PRIVACYPOLICY'     => 'RatePAY-Datenschutzerkl&auml;rung',
    'PI_RATEPAY_RATE_ERROR'                         => 'Leider ist eine Bezahlung mit RatePAY nicht m&ouml;glich. Diese Entscheidung ist von RatePAY auf der Grundlage einer automatisierten Datenverarbeitung getroffen worden. Einzelheiten erfahren Sie in der ',
    'PI_RATEPAY_RATE_ERROR_ADDRESS'                 => 'Bitte beachten Sie, dass RatePAY Rate nur genutzt werden kann, wenn Rechnungs- und Lieferaddresse identisch sind.',
    'PI_RATEPAY_RATE_ERROR_BIRTH'                   => $piErrorBirth,
    'PI_RATEPAY_RATE_ERROR_PHONE'                   => $piErrorPhone,
    'PI_RATEPAY_RATE_AGBERROR'                      => 'Bitte akzeptieren Sie die Bedingungen.',
    'PI_RATEPAY_RATE_SUCCESS'                       => 'Bestellung erfolgreich abgeschlossen',
    'PI_RATEPAY_RATE_ERROR_AGE'                     => $piErrorAge,
    'PI_RATEPAY_RATE_VIEW_PAYMENT_FON'              => 'Telefon:',
    'PI_RATEPAY_RATE_VIEW_PAYMENT_MOBILFON'         => 'Mobiltelefon:',
    'PI_RATEPAY_RATE_VIEW_PAYMENT_BIRTHDATE'        => 'Geburtsdatum:',
    'PI_RATEPAY_RATE_VIEW_PAYMENT_BIRTHDATE_FORMAT' => '(tt.mm.jjjj)',
    'PI_RATEPAY_RATE_VIEW_PAYMENT_FON_NOTE'         => 'Tragen Sie bitte entweder Ihr Telefon oder Mobiltelefon ein.',
    'PI_RATEPAY_RATE_VIEW_PAYMENT_COMPANY'          => 'Firma:',
    'PI_RATEPAY_RATE_VIEW_PAYMENT_UST'              => 'UST-ID:',
    'PI_RATEPAY_ERROR_BIRTHDAY_YEAR_DIGITS'         => $piErrorBirthdayDigits,
    'PI_RATEPAY_ERROR_COMPANY'                      => $piErrorCompany,
    'PI_RATEPAY_RATE_ERROR_CALCULATE_TO_PROCEED'    => 'Um Fortfahren zu können erstellen Sie bitte zuerst einen Ratenplan.'
);
