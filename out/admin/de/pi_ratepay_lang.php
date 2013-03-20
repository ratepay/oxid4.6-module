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
$aLang = array(
    'charset'                                  => 'UTF-8',
    'PI_RATEPAY_RATEPAY'                       => 'RatePAY',
    'PI_RATEPAY_NODETAILS'                     => 'Keine RatePAY Bezahlung.',
    'PI_RATEPAY_LOGGING'                       => "Logging",
    'PI_RATEPAY_LOGGING_ID'                    => "ID",
    'PI_RATEPAY_LOGGING_ORDERNUMBER'           => "Bestellnummer",
    'PI_RATEPAY_LOGGING_TRANSACTIONID'         => "Transaktionsnummer",
    'PI_RATEPAY_LOGGING_PAYMENTMETHOD'         => "Bezahlmethode",
    'PI_RATEPAY_LOGGING_PAYMENTTYPE'           => "Bezahltyp",
    'PI_RATEPAY_LOGGING_PAYMENTSUBTYPE'        => "Bezahluntertyp",
    'PI_RATEPAY_LOGGING_RESULT'                => "Ergebnis",
    'PI_RATEPAY_LOGGING_REQUEST'               => "Anfrage",
    'PI_RATEPAY_LOGGING_RESPONSE'              => "Antwort",
    'PI_RATEPAY_LOGGING_DATE'                  => "Datum",
    'PI_RATEPAY_LOGGING_DAYS'                  => "Tage",
    'PI_RATEPAY_LOGGING_DELETE'                => "L&ouml;schen",
    'PI_RATEPAY_LOGGING_TEXTDAYS'              => "L&ouml;schen Sie alle Eintr&auml;ge die &auml;lter sind als ",
    'PI_RATEPAY_LOGGING_SUCCESS'               => "L&ouml;schen war erfolgreich.",
    'PI_RATEPAY_ARTICLENR'                     => "Art.-Nr.",
    'PI_RATEPAY_ARTICLENAME'                   => "Bezeichnung",
    'PI_RATEPAY_UNITPRICE'                     => "Einzelpreis (Brutto)",
    'PI_RATEPAY_TOTALPRICE'                    => "Gesamtpreis (Brutto)",
    'PI_RATEPAY_ORDERED'                       => "Bestellt",
    'PI_RATEPAY_SHIPPED'                       => "Geliefert",
    'PI_RATEPAY_CANCELLED'                     => "Storniert",
    'PI_RATEPAY_RETURNED'                      => "Retourniert",
    'PI_RATEPAY_TAX'                           => "MwSt.",
    'PI_RATEPAY_QUANTITY'                      => "Anzahl",
    'PI_RATEPAY_SHIPPING'                      => "versenden",
    'PI_RATEPAY_CANCELLING'                    => "stornieren",
    'PI_RATEPAY_KOMMA'                         => ",",
    'PI_RATEPAY_RETURNING'                     => "retournieren",
    'PI_RATEPAY_RETURNING_TABLE_HEAD'          => "Retoure",
    'PI_RATEPAY_VOUCHER'                       => "Gutschrift erzeugen",
    'PI_RATEPAY_HISTORY'                       => "Historie",
    'PI_RATEPAY_CONFIRMDELIVER'                => "Lieferung",
    'PI_RATEPAY_SHIPPING_TABLE_HEAD'           => "Lieferung/Stornierung",
    'PI_RATEPAY_GOODWILL'                      => "Gutschrift",
    'PI_RATEPAY_PARTIALRETURN'                 => "Teilretournierung",
    'PI_RATEPAY_FULLRETURN'                    => "Komplettretournierung",
    'PI_RATEPAY_PARTIALCANCELLATION'           => "Teilstornierung",
    'PI_RATEPAY_FULLCANCELLATION'              => "Komplettstornierung",
    'PI_RATEPAY_ACTION'                        => "Aktion",
    'PI_RATEPAY_DATE'                          => "Datum",
    'PI_RATEPAY_SUCCESSPARTIALCANCELLATION'    => "Teilstornierung war erfolgreich.",
    'PI_RATEPAY_SUCCESSFULLCANCELLATION'       => "Komplettstornierung war erfolgreich.",
    'PI_RATEPAY_SUCCESSPARTIALRETURN'          => "Teilretournierung war erfolgreich.",
    'PI_RATEPAY_SUCCESSFULLRETURN'             => "Komplettretournierung war erfolgreich.",
    'PI_RATEPAY_SUCCESSDELIVERY'               => "Lieferung war erfolgreich.",
    'PI_RATEPAY_SUCCESSVOUCHER'                => "Gutschrift wurde erfolgreich ausgef&uuml;hrt",
    'PI_RATEPAY_ERRORPARTIALCANCELLATION'      => "Teilstornierung war nicht erfolgreich.",
    'PI_RATEPAY_ERRORFULLCANCELLATION'         => "Komplettstornierung war nicht erfolgreich.",
    'PI_RATEPAY_ERRORPARTIALRETURN'            => "Teilretournierung war nicht erfolgreich.",
    'PI_RATEPAY_ERRORFULLRETURN'               => "Komplettretournierung war nicht erfolgreich.",
    'PI_RATEPAY_ERRORDELIVERY'                 => "Lieferung war nicht erfolgreich.",
    'PI_RATEPAY_ERRORVOUCHER'                  => "Gutschrift wurde nicht erfolgreich ausgef&uuml;hrt",
    'PI_RATEPAY_ERRORTYPING'                   => "Falsche Eingabe. Eingabe wurde zur&uuml;ckgesetzt. Sie d&uuml;rfen nur Zahlen eintragen, die den vorausgef&uuml;llten Wert nicht &uuml;berschreiten.",
    'PI_RATEPAY_ADMIN_MENU_CONFIGURATION'      => "Ratekonfiguration",
    'PI_RATEPAY_RECHNUNG_SETTINGS_DUEDATE'     => "Fällig nach",
    'PI_RATEPAY_RECHNUNG_SETTINGS_DUEDATE_DAY' => "Tagen",
    'PI_RATEPAY_RATE_PAYMENTFIRSTDAY'          => "Abweichende Fälligkeit für Kunden aktivieren",
    'PI_RATEPAY_ELV_SETTINGS'                  => "Lastschrift Einstellungen",
    'PI_RATEPAY_ELV_SETTINGS_TITLE'            => "RatePAY Lastschrift Einstellungen",
    'PI_RATEPAY_SAVEBANKDATA'                  => "Bankdaten speichern (verschlüsselt)",
    'PI_RATEPAY_ACTIVATE_ELV'                  => "Lastschrift für Rate aktivieren"
);
